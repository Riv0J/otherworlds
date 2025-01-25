<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryTranslation;
use App\Models\CountryTranslation;
use App\Models\PlaceTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\Models\Place;
use App\Models\Category;
use App\Models\Country;
use App\Models\Media;
use App\Models\Source;
use App\Models\Message;
use App\Models\OHelper;
class Admin_PlaceController extends Controller{
    /**
     * Show a list of places to an admin
     */
    public function index($locale){
        $variables = [
            'locale' => $locale,
            'total' => Place::count(),
            'categories' => Category::all(),
            // 'countries' => Country::whereExists(function ($query) {
            //     $query->select('country_id')
            //     ->from('places')
            //     ->whereRaw('places.country_id = countries.id');
            // })->get(),
            'countries' => Country::all(),
            'logged' => auth()->user(),
            'places' => self::get_places(1,'',$locale,0,0)
        ];
        return view('admin.places.index',$variables);
    }

    /**
     * Show the create place form to an admin
     */
    public function create($locale){
        $variables = [
            'locale' => $locale,
            'categories' => Category::all(),
            'countries' => Country::all()
        ];
        return view('admin.places.create', $variables);
    }

    /**
     * Get Users based on page and search term
     */
    public static function get_places($page, $search, $locale, $category_id, $country_id){
        // calculate the start index based on the page, and per page
        $per_page = 30;
        $start_index = ($page - 1) * $per_page;
        $query = Place::with('medias')->with('sources')->with('countries')
        ->join('places_translations', 'places_translations.place_id', 'places.id')
        ->where('places_translations.locale', $locale)
        ->where('places_translations.name', 'like', '%' . $search . '%')
        // ->orderBy('places.views_count', 'desc');
        ->orderBy('places.created_at', 'desc')
        ->orderBy('places.id', 'asc');
        if($category_id != null && $category_id != 0){
            $query->where('category_id',$category_id);
        }
        if($country_id != null && $country_id != 0){
            $query->where('country_id',$country_id);
        }

        return $query->select('places.*', 'places_translations.name')
        ->skip($start_index)
        ->take($per_page)
        ->get();
    }

    /**
     * Ajax, request more places by page and search
     */
    public function ajax_place_request(Request $request){
        $data = $request->all(); //get request data
        app()->setLocale($data['locale']); //set locale to request
        $next_page = $data['page'] + 1;
        $search = $data['search'];

        //get places for the page requested
        $places = self::get_places($next_page, $search, $data['locale'], $data['category_id'], $data['country_id']);

        if(count($places) === 0){
            //if no places, means there is no next page
            $next_page = -1;
        }

        $variables = [
            'next_page' => $next_page,
            'places' => $places,
        ];

        return response()->json($variables);
    }

    /**
     * Ajax, create a place from the place index modal view
     */
    public function ajax_create(Request $request){
        $data = $request->all();
        $locale = $data['current_locale'];
        app()->setLocale($locale);
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'country_id' => 'required|integer|exists:countries,id',
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'synopsis' => 'required|string',
            'thumbnail' => 'required|file|mimes:jpeg,png,jpg,gif',

            'thumbnail_url' => 'nullable|string|max:255',
            'gallery_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'messages' => $validator->errors()->all(),
            ], 422);
        }
        if(Place::name_exists($data['name'])){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "A place with that name already exists"),
            ], 200);
        }
        $variables = [];
        try {
            $slug = OHelper::sluggify($data['name']);
            $place_data = [
                'public_slug' => $slug,
                'country_id' => $data['country_id'],
                'category_id' => $data['category_id'],
                'gallery_url' => $data['gallery_url'],
            ];
            $place_data[$locale] = [
                'slug' => $slug,
                'name' => $data['name'],
                'synopsis' => $data['synopsis'],
            ];

            // create translated attributes for this place in each locale
            foreach (config('translatable.locales') as $loc) {
                if($loc == $locale){ continue; }

                $locale_str = '['.strtoupper($loc).']';
                $place_data[$loc] = [
                    'slug' => $slug.'-'.$loc,
                    'name' => $data['name'].' '.$locale_str,
                    'synopsis' => $data['synopsis'].' '.$locale_str,
                ];
            }

            //create using data
            $new_place = Place::create($place_data);

            // create an img directory for this place in english name if it doesnt exist
            $path = public_path('places/'.$place_data['public_slug']);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // save the thumbnail image
            $new_place->save_thumbnail($request->file('thumbnail'));

            // create the thumbnail media
            $media_data = [
                'url' => asset('places/'.$new_place->public_slug).'/'.$new_place->thumbnail,
                'place_id' => $new_place->id,
                'page_url' => $data['thumbnail_url']
            ];
            Media::create($media_data);

            // create media images from the url
            if($new_place->gallery_url){
                $new_place->create_medias($new_place->gallery_url);
            }

            $variables['success'] = true;
            $variables['place'] = Place::with('medias')->where('id',$new_place->id)->first();
            $variables['message'] = new Message(Message::TYPE_SUCCESS, trans('otherworlds.place_created'));
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => new Message(Message::TYPE_ERROR, "Generic error, please try again"),
            ], 500);
        }
        return response()->json($variables);
    }

    /**
     * Ajax, create a place given a Wikipedia URL
     */
    public function ajax_wiki_create(Request $request){
        $messages = [];
        $data = $request->all();
        $locale = $data['locale'];
        app()->setLocale($locale);

        // extract the content from wikipedia page
        $scrape_data = OHelper::getWikiContent($data['wikipedia_url']);

        // use content to create the place
        $slug = OHelper::sluggify($scrape_data['title']);
        $place_name = $scrape_data['title'];

        if(Place::name_exists($place_name)){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "A place with that name already exists"),
            ], 200);
        }

        $place_data = [
            'public_slug' => $slug,
            'country_id' => Country::unknown_id(),
            'category_id' => Category::unknown_id(),
            'gallery_url' => null,
        ];

        // add latitude and longitude (if they were scraped)
        if($scrape_data['latitude'] != null && $scrape_data['longitude'] != null){
            $place_data['latitude'] = $scrape_data['latitude'];
            $place_data['longitude'] = $scrape_data['longitude'];
        }

        $place_data[$locale] = [
            'slug' => $slug,
            'name' => $place_name,
            'synopsis' => '',
        ];

        // create translated attributes for this place in each locale
        foreach (config('translatable.locales') as $loc) {
            if($loc == $locale){ continue; }

            $locale_str = '['.strtoupper($loc).']';
            $place_data[$loc] = [
                'slug' => $slug.'-'.$loc,
                'name' => $place_name.' '.$locale_str,
                'synopsis' => 'Placeholder '.$locale_str,
            ];
        }

        // create place using $place_data
        $new_place = Place::create($place_data);
        $new_place->add_country(Country::unknown_id());

        // create source from content data
        $source = Source::create([
            'locale' => $locale,
            'place_id' => $new_place->id,
            'url' => $data['wikipedia_url'],
            'title' => $scrape_data['title'],
            'content' => $scrape_data['content'],
        ]);

        $messages[] = new Message(Message::TYPE_SUCCESS, 'Created place + source from wikipedia');

        //attempt to get create medias
        if($new_place->attempt_create_medias($scrape_data['gallery_url'])){
            $messages[] = new Message(Message::TYPE_SUCCESS, 'Created medias automatically');

            if($new_place->media_thumbnail()){
                $messages[] = new Message(Message::TYPE_SUCCESS, 'Auto-assigned thumbnail');
            } else {
                $messages[] = new Message(Message::TYPE_ERROR, 'Could not assign thumbnail');
            }
        } else {
            $messages[] = new Message(Message::TYPE_ERROR, 'Could not create medias automatically');
        }

        $variables =[
            'success' => true,
            'place' => Place::with('medias')->with('sources')->with('countries')->where('id', $new_place->id)->first(),
            'messages' => $messages,
        ];
        return response()->json($variables);
    }

    /**
     * Ajax, update a place's basic info in a specific locale
     */
    public function ajax_place_update(Request $request){
        $data = $request->all();

        app()->setLocale($data['locale']);
        $place = Place::with('medias')->with('sources')->with('countries')->where('id',$data['place_id'])->first();

        if(PlaceTranslation::where('name', $data['name'])->where('place_id','!=',$place->id)->exists()){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "A place with that name already exists"),
            ], 200);
        }

        $place->country_id = $data['country_id'];
        $place->category_id = $data['category_id'];
        $place->name = $data['name'];
        $place->slug = OHelper::sluggify($data['name']);
        $place->gallery_url = $data['gallery_url'];
        $place->synopsis = $data['synopsis'];
        $place->checked = $data['checked'] == 'false' ? false : true; //the input arrives as boolean

        if($request->hasFile('thumbnail')){
            $place->save_thumbnail($request->file('thumbnail'));
        }
        $place->save();

        $variables =[
            'locale' => $data['locale'],
            'place' => $place,
            'success' => true,
            'messages' => [new Message(Message::TYPE_SUCCESS, "Updated place basic info")],
            'thumbnail_edited' => $request->hasFile('thumbnail')
        ];
        if($place->checked){
            $variables['messages'][] = new Message(Message::TYPE_SUCCESS, "Place is checked");
        } else {
            $variables['messages'][] = new Message(Message::TYPE_ERROR, "Place is unchecked");
        }
        //si se edita en 'en' entonces, cambiar el public slug del place, y a su vez, mover la carpeta al nuevo nombre
        if($data['locale'] == 'en'){
            
            $old_folder = $place->public_path();
            $place->public_slug = OHelper::sluggify($data['name']);
            $new_folder = $place->public_path();

            if(file_exists($old_folder)){
                rename($old_folder, $new_folder);
            }
            $place->save();
        }
        return response()->json($variables);
    }
    /**
     * Ajax, get a place from an ID and locale
     */
    public function ajax_place_get(Request $request){
        $data = $request->all();
        app()->setLocale($data['locale']);
        $variables =[
            'locale' => $data['locale'],
            'place' => Place::with('medias')->with('sources')->with('countries')->where('id',$data['place_id'])->first()
        ];
        return response()->json($variables);
    }

    /**
     * Ajax, DELETE an specific place
     */
    public function ajax_delete(Request $request){
        $data = $request->all();
        $place = Place::find($data['place_id']);

        if(!$place){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "Could not find this place"),
            ], 200);
        }
        $place->delete_public_slug();
        $place->delete();
        $variables = [
            'success' => true,
            'message' => new Message(Message::TYPE_SUCCESS, "Place deleted"),
        ];
        return response()->json($variables);
    }

    /**
     * Ajax, SET a place's countries
     */
    public function ajax_countries(Request $request){
        try {
            $validated = $request->validate([
                'place_id' => 'required|integer|exists:places,id',
                'countries' => 'required|array|min:1', // Validar que sea un array con al menos un elemento
                'countries.*' => 'integer|exists:countries,id', // Validar que cada elemento del array sea un ID válido
            ]);

            $place = Place::findOrFail($validated['place_id']);
            $countries = $validated['countries'];

            $place->countries()->detach();
            $place->country_id = $countries[0];
            $place->save();
            
            foreach ($countries as $country_id) {
                if($country_id == null || $place->countries()->where('countries.id', $country_id)->exists()){
                    continue;
                }
                $country = Country::findOrFail($country_id);
                if($country->is_unknown() == false){
                    $place->add_country($country_id);
                }
            }
            $variables = [
                'success' => true,
                'message' => new Message(Message::TYPE_SUCCESS, "Countries updated"),
                'place' => Place::where('id', $place->id)->with('medias')->with('sources')->with('countries')->first()
            ];
        } catch (\Throwable $th) {
            $variables = [
                'success' => true,
                'message' => new Message(Message::TYPE_ERROR, "Countries error: ".$th->getMessage()),
            ];
        }
        return response()->json($variables);
    }
    
}
