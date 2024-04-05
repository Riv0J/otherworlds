<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $variables = [
            'current_section' => 'Places',
            'places' => $places,
            'countries' => $countries,
            'all_categories' => Category::all(),
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

    function ajax_place_request(Request $request){
        // Obtener los datos enviados mediante la solicitud POST
        $request_data = $request->all();
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

        // Convertir los datos en formato JSON y devolverlos como respuesta
        return response()->json($variables);
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
