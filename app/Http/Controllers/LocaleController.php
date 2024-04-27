<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;
use App\Models\Place;

class LocaleController extends Controller{
    public function setLocale($locale, $new_locale){
        //dd("changing locale, curren= ".$locale.". New= ".$new_locale);
        // check if new locale is valid, return to places index if not
        if (in_array($new_locale, config('translatable.locales')) == false) {
            return redirect()->route('home', ['locale' => 'en']);
        }

        // replace the locale in url
        $url = url()->previous();
        $url = str_replace("/".$locale."/", "/".$new_locale."/", $url);

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
