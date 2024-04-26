<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;
use App\Models\Place;

class LocaleController extends Controller{
    public function setLocale($new_locale){
        // get current app locale
        $current_locale = \App::getLocale($new_locale);
        // dd("changing locale, curren= ".$current_locale.". New= ".$new_locale);
        // check if new locale is valid, return to places index if not
        if (in_array($new_locale, config('translatable.locales')) == false) {
            return redirect()->route('places', ['locale' => $current_locale]);
        }

        // // set new app locale
        \App::setLocale($new_locale);
        
        // replace the locale in url
        $url = url()->previous();
        $url = str_replace("/".$current_locale."/", "/".$new_locale."/", $url);

        // check if theres a place_id in session
        if (session()->has('place_id') && str_contains(url()->previous(),'/place/')) {
            $place = Place::find(session('place_id'));
            if($place == null){
                return back();
            }
            // redirect with translated name
            return redirect()->route('view_place', ['locale' => $new_locale, 'place_slug' => $place->slug]);
        }

        // redirect back
        return Redirect::to($url);

    }

}
