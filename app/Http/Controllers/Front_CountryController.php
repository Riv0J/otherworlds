<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\CountryTranslation;
class Front_CountryController extends Controller
{
    public function show($locale, $country_name){
        // try to get the country
        $country = Country::whereHas('translations', function ($query) use ($country_name) { 
                    $query->where('name', $country_name);
                })->first();
        //return places index view
        $variables = [
            'slug_key' => 'places_slug',
            'locale' => $locale,

            //#places_container variables
            'places' => $country->places()->orderBy('views_count','desc')->orderBy('id','desc')->get(),
            'countries' => Country::has('places')->get(),
            'categories' => Category::all(),
            'selected_country' => $country->id
        ];
        return view('front.places.index', $variables);
    }
}
