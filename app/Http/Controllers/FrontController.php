<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    function home(){
        $variables = [
            'current_section' => 'Home',
        ];
        return view('front.home', $variables);
    }

    function places_index(){
        $variables = [
            'current_section' => 'Places',
        ];
        return view('front.places', $variables);
    }
}
