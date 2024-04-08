<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Place;
use App\Models\PlaceTranslation;
use App\Models\Category;

class FrontController extends Controller{
    protected $PER_PAGE = 10;

    function home(){
        $variables = [
            'current_section' => 'Home',
            'place' => Place::inRandomOrder()->take(1)->first(),
        ];
        return view('front.home', $variables);
    }

    function places_index(){
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
        ];
        return view('front.places', $variables);
    }

    function view_place(string $place_name){
        //try to get the place:
        $place_translation = PlaceTranslation::where('name', $place_name)->first();
        if($place_translation == null){
            return redirect()->route('places');
        }

        $place = Place::find($place_translation->place_id);
        if($place == null){
            return redirect()->route('places');
        }

        // add a view to the place
        $place->views_count += 1;
        $place->save();

        $variables = [
            'place' => $place,
        ];

        return view('front.view_place', $variables);
    }

    //show the logged user's profile
    function profile(){
        $user = Auth::user();
        return view('front.profile', ['user' => $user]);
    }

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

    //get places based on page
    public static function getPlaces($page, $per_page){
        // Calcular el índice de inicio para la consulta basado en el número de página
        $startIndex = ($page - 1) * $per_page;

        // Obtener los lugares ordenados por nombre
        return Place::skip($startIndex)
                    ->take($per_page)
                    ->get();
    }
}
