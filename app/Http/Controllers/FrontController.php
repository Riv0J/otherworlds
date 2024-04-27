<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Place;
use App\Models\Category;

class FrontController extends Controller{
    protected $PER_PAGE = 10;

    function home($locale){
        $variables = [
            'current_section' => 'Home',
            'place' => Place::inRandomOrder()->take(1)->first(),
            'locale' => $locale
        ];
        return view('front.home', $variables);
    }

    function place_index($locale, $section_slug){
        // check if this section_slug is valid

        //get the places in the first page
        $places = FrontController::getPlaces($page = 1, $per_page = $this->PER_PAGE);

        //get the countries of the places
        $countries = $places->pluck('country')->unique()->values()->all();

        $fav_places_ids = [];
        $user = Auth::user();
        if($user){
            $fav_places_ids = $user->favorites->pluck('id');
        }
        $variables = [
            'current_section' => 'Places',
            'places' => $places,
            'countries' => $countries,
            'all_categories' => Category::all(),

            'fav_places_ids' => $fav_places_ids,
            'locale' => $locale,
            'section_slug_key' => 'places_slug'
        ];
        return view('front.place_index', $variables);
    }

    function place_view($locale, $section_slug, $place_slug){
        // check if this section_slug is valid

        // try to get the place
        $place = Place::whereHas('translations', function ($query) use ($place_slug) {
            $query->where('slug', $place_slug);
        })->first();

        // redirect if no place is found
        if( $place == null){return redirect()->route('place_index', ['locale' => $locale, 'section_slug' => trans('otherworlds.places_slug')]); }

        // add a view to the place
        $place->views_count += 1;
        $place->save();

        // add place_id to session
        session()->put('place_id', $place->id);

        $variables = [
            'place' => $place,
            'source' => $place->getSource($locale),
            'locale' => $locale,
            'section_slug_key' => 'places_slug'
        ];

        return view('front.place_view', $variables);
    }

    //show the logged user's profile
    function profile(){
        $user = Auth::user();
        return view('front.profile', ['user' => $user]);
    }

    //---------------------------------------------------------------------------------------AJAX
    function ajax_place_request(Request $request){
        $request_data = $request->all(); //get request data
        $next_page = $request_data['current_page'] + 1; //advance page

        //get the places for next page
        $places = FrontController::getPlaces($page = $next_page, $per_page = $this->PER_PAGE);

        //get the countries for these places
        $countries = $places->pluck('country')->unique()->values()->all();

        if(count($places) === 0){
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
        if (!$user) { return false; }

        $request_data = $request->all(); //get request data
        $place = Place::findOrFail($request_data['place_id']);

        $is_fav = $place->is_favorite($user);

        if($is_fav === true){
            $user->favorites()->detach($place->id);
            $place->favorites_count -= 1;
        } else if ($is_fav === false){
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
    public static function getPlaces($page, $per_page){
        // calculate the start index based on the page, and per page
        $startIndex = ($page - 1) * $per_page;

        // get the places ordered by name and return
        return Place::skip($startIndex)
                    ->take($per_page)
                    ->get();
    }
}
