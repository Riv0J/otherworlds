<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Place;
use App\Models\PlaceTranslation;
use App\Models\Country;

class FrontController extends Controller
{
    function home(){
        $variables = [
            'current_section' => 'Home',
            'place' => Place::inRandomOrder()->take(1)->first(),
        ];
        return view('front.home', $variables);
    }

    function places_index(){
        $variables = [
            'current_section' => 'Places',
            'all_places' => Place::all()->sortBy('name'),
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

        // app()->setLocale($place_translation->locale);

        $variables = [
            'place' => $place,
        ];

        return view('front.view_place', $variables);
    }

    public static function getPhrases(string $locale){
        $phrases =[
            'en' => [
                'Ever wondered why... *| some places just feel out of this world...?',
                'We have places to be... *| And people to meet.',
                'Discover the unknown beauty... *| In the same planet we call home.'
            ],
            'es' => [
                'Alguna vez te has preguntado... *| sobre los lugares que parecen de otro mundo...?',
                'Tenemos lugares en los que estar... *| Y personas que conocer.',
                'Descubre la belleza escondida... *| En el mismo planeta que llamamos hogar.'
            ]
        ];
        return $phrases[$locale];
    }
}
