<?php

namespace App\Http\Controllers;

use App\Models\Place;

class Front_Controller extends Controller{
    function home($locale){
        $variables = [
            'slug_key' => 'home_slug',
            'locale' => $locale,
            'places' => Place::inRandomOrder()->take(3)->get(),
        ];
        return view('front.home', $variables);
    }

    function show_development($locale){
        $variables = [
            'slug_key' => 'dev_slug',
            'locale' => $locale
        ];
        return view('front.show_development', $variables);
    }

}
