<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Place;

class LocaleController extends Controller
{
    public function setLocale($locale){

        $locales = config('translatable.locales');
        if (in_array($locale, $locales) == false) {
            //if the locale is not valid, return to places index
            return redirect()->route('places');
        }

        // set app locale
        \App::setLocale($locale);

        // create a new cookie
        $cookie = cookie('o_locale', $locale, 60 * 24 * 30); // 30 días

        // check if theres a place_id in session
        if (session()->has('place_id') && str_contains(url()->previous(),'/place/')) {
            $place = Place::find(session('place_id'));
            if($place == null){
                return back()->withCookie($cookie);
            }

            // redirect with translated name with cookie
            return redirect()->route('view_place', ['place_slug' => $place->slug])->withCookie($cookie);
        }

        // redirect back with cookie
        return back()->withCookie($cookie);

    }


}
