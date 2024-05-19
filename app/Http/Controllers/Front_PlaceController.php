<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Place;
use App\Models\Category;
class Front_PlaceController extends Controller{
    protected const PER_PAGE = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index($locale){
        // check if this section_slug is valid

        //get the places in the first page
        $places = Front_PlaceController::getPlaces($page = 1);

        //get the countries of the places
        $countries = $places->pluck('country')->unique()->values()->all();

        $fav_places_ids = [];
        $user = Auth::user();
        if($user){
            $fav_places_ids = $user->favorites->pluck('id');
        }
        $variables = [
            'slug_key' => 'places_slug',
            'locale' => $locale,

            //#places_container variables
            'places' => $places,
            'countries' => $countries,
            'all_categories' => Category::all(),
            'fav_places_ids' => $fav_places_ids
        ];
        return view('front.places.index', $variables);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function show($locale, $place_slug){
        // try to get the place
        $place = Place::whereHas('translations', function ($query) use ($place_slug) {
            $query->where('slug', $place_slug);
        })->first();

        // redirect if no place is found
        if( $place == null){ return redirect(places_url($locale)); }

        // add a view to the place
        $place->views_count += 1;
        $place->save();

        // add place_id to session
        session()->put('place_id', $place->id);

        $variables = [
            'slug_key' => 'place_view',
            'locale' => $locale,

            'place' => $place,
            'source' => $place->getSource($locale)
        ];

        return view('front.places.show', $variables);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //---------------------------------------------------------------------------------------AJAX
    function ajax_place_request(Request $request){
        $request_data = $request->all(); //get request data
        app()->setLocale($request_data['locale']); //set locale to request
        $next_page = $request_data['current_page'] + 1; //advance page

        //get the places for next page
        $places = Front_PlaceController::getPlaces($page = $next_page);

        //get the countries for these places
        $countries = $places->pluck('country')->unique()->values()->all();

        if (count($places) === 0) {
            //if no places, means there is no next page
            $next_page = -1;
        }

        $variables = [
            'current_page' => $next_page,
            'places' => $places,
            'countries' => $countries,
        ];

        return response()->json($variables); //convert vars to json
    }

    function ajax_place_favorite(Request $request){
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        $request_data = $request->all(); //get request data
        $place = Place::findOrFail($request_data['place_id']);

        $is_fav = $place->is_favorite($user);

        if ($is_fav === true) {
            $user->favorites()->detach($place->id);
            $place->favorites_count -= 1;
        } else if ($is_fav === false) {
            $user->favorites()->attach($place->id);
            $place->favorites_count += 1;
        }
        $place->save();

        $variables = [
            'is_fav' => !$is_fav,
            'favorites_count' => $place->favorites_count
        ];
        return response()->json($variables); //convert vars to json
    }

    // get places based on page
    public static function getPlaces($page){
        // calculate the start index based on the page, and per page
        $startIndex = ($page - 1) * Front_PlaceController::PER_PAGE;

        //get the places ordered by name
        // $places = Place::join('places_translations', 'places.id', '=', 'places_translations.place_id')
        //         ->where('places_translations.locale', app()->getLocale())
        //         ->orderBy('places_translations.name')
        //         ->skip($startIndex)
        //         ->take($per_page)
        //         ->get('places.*');

        // get the places ordered by favorites
        $places = Place::orderBy('favorites_count', 'desc')
            ->skip($startIndex)
            ->take(Front_PlaceController::PER_PAGE)
            ->get('places.*');
        return $places;
    }
}
