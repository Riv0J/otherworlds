<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Place;
use App\Models\Country;
use App\Models\Category;
class Front_PlaceController extends Controller{
    protected const PER_PAGE = 10;

    function index($locale){
        $variables = [
            'slug_key' => 'places_slug',
            'locale' => $locale,

            //#places_container variables
            //get the places in the first page
            'places' => Front_PlaceController::getPlaces($page = 1),
            'countries' => Country::has('places')->get(),
            'categories' => Category::all(),
        ];
        return view('front.places.index', $variables);
    }

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

    //---------------------------------------------------------------------------------------AJAX
    function ajax_place_request(Request $request){
        $request_data = $request->all(); //get request data
        app()->setLocale($request_data['locale']); //set locale to request
        $next_page = $request_data['current_page'] + 1; //advance page

        //get the places for next page
        $places = Front_PlaceController::getPlaces($page = $next_page);

        if (count($places) === 0) {
            //if no places, means there is no next page
            $next_page = -1;
        }

        $variables = [
            'current_page' => $next_page,
            'places' => $places,
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
        $places = Place::orderBy('id', 'asc')
            ->skip($startIndex)
            ->take(Front_PlaceController::PER_PAGE)
            ->get('places.*');
        return $places;
    }
}
