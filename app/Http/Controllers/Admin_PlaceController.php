<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PlaceTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\Models\Place;
use App\Models\Category;
use App\Models\Country;
use App\Models\Media;
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
        $query = Place::with('medias')->with('sources')
        ->join('places_translations', 'places_translations.place_id', 'places.id')
        ->where('places_translations.locale', $locale)
        ->where('places_translations.name', 'like', '%' . $search . '%')
        // ->orderBy('places.views_count', 'desc');
        ->orderBy('places.created_at', 'desc');
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
        if(PlaceTranslation::where('name', $data['name'])->exists()){
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
     * Ajax, update a place's basic info in a specific locale
     */
    public function ajax_place_update(Request $request){

        $data = $request->all();

        app()->setLocale($data['locale']);
        $place = Place::with('medias')->where('id',$data['place_id'])->first();

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

        if($request->hasFile('thumbnail')){
            $place->save_thumbnail($request->file('thumbnail'));
        }
        $place->save();

        $variables =[
            'locale' => $data['locale'],
            'place' => $place,
            'success' => true,
            'message' => new Message(Message::TYPE_SUCCESS, "Updated place basic info"),
            'thumbnail_edited' => $request->hasFile('thumbnail')
        ];
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
            'place' => Place::with('medias')->where('id',$data['place_id'])->first()
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
        $place->delete();
        $variables = [
            'success' => true,
            'message' => new Message(Message::TYPE_SUCCESS, "Place deleted"),
        ];
        return response()->json($variables);
    }
}
