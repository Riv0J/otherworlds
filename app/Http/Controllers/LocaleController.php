<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;

class LocaleController extends Controller{
    public function setLocale($locale, $slug_key, $new_locale){
        // check if new locale is valid, return to places index if not
        if (in_array($new_locale, config('translatable.locales')) == false) {
            return redirect()->route('home', ['locale' => 'en']);
        }

        //change the locale
        app()->setLocale($new_locale);

        // check if theres a place_id in session
        if (session()->has('place_id') && $slug_key == 'place_view') {
            $place = Place::find(session('place_id'));

            if($place == null){ return back(); }

            return redirect(places_url($new_locale).'/'.$place->slug);
        }

        // rebuild the url slug
        $current_section_trans = trans('otherworlds.'.$slug_key, [], $locale);
        $new_section_trans = trans('otherworlds.'.$slug_key, [], $new_locale);

        $new_url = url()->previous();
        $new_url = str_replace("/".$locale."/", "/".$new_locale."/", $new_url); //replace locale
        $new_url = str_replace($current_section_trans, $new_section_trans, $new_url); //replace section
        // dd($current_section_trans." ".$new_section_trans);
        // redirect back
        return redirect($new_url);
    }
}
