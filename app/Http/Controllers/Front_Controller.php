<?php

namespace App\Http\Controllers;

use App\Models\Place;

class Front_Controller extends Controller{
    function home($locale){
        $variables = [
            'section_slug_key' => 'home_slug',
            'locale' => $locale,

            'place' => Place::random(),
        ];
        return view('front.home', $variables);
    }

    function show_development($locale){
        $variables = [
            'section_slug_key' => 'dev_slug',
            'locale' => $locale
        ];
        return view('front.show_development', $variables);
    }

}
