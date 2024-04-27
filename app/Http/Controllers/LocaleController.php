<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;
use App\Models\Place;

class LocaleController extends Controller{
    public function setLocale($locale, $section_slug_key, $new_locale){
        // check if new locale is valid, return to places index if not
        if (in_array($new_locale, config('translatable.locales')) == false) {
            return redirect()->route('home', ['locale' => 'en']);
        }

        // rebuild the url slugs
        app()->setLocale($locale);
        $current_section_trans = trans('otherworlds.'.$section_slug_key);
        app()->setLocale($new_locale);
        $new_section_trans = trans('otherworlds.'.$section_slug_key);

        // check if theres a place_id in session
        if (session()->has('place_id')) {
            $place = Place::find(session('place_id'));
            if($place == null){
                return back();
            }

            // redirect with translated name
            $variables = [
                'locale' => $new_locale,
                'section_slug' => $new_section_trans,
                'place_slug' => $place->slug,
            ];
            return redirect()->route('place_view', $variables);
        }

        $new_url = url()->previous();
        $new_url = str_replace("/".$locale."/", "/".$new_locale."/", $new_url); //replace locale
        $new_url = str_replace($current_section_trans, $new_section_trans, $new_url); //replace section

        // redirect back
        return Redirect::to($new_url);
    }
}
