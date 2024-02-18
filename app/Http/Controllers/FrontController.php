<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Place;
use App\Models\Country;

class FrontController extends Controller
{
    function home(){
        $variables = [
            'current_section' => 'Home',
            'phrases' => FrontController::getPhrases(app()->getLocale()),
        ];
        return view('front.home', $variables);
    }

    function places_index(){
        $variables = [
            'current_section' => 'Places',
            'all_places' => Place::all(),
        ];
        return view('front.places', $variables);
    }
    function view_place(string $place_name){
        return view('front.places', $variables);

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
