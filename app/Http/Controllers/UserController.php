<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Country;
use App\Models\Category;
class UserController extends Controller{
    /*
     * Show a user's profile
     */
    function show($locale, $username){
        $user = User::where('name', $username)->first();

        if ($user == null) {
            redirect()->route('home', ['locale', $locale]);
        }

        $can_edit = false;
        $logged = Auth::user();
        $fav_places_ids = [];

        if ($logged) {
            $fav_places_ids = $logged->favorites->pluck('id');
            // if the logged user is the same as the user being consulted, can edit
            if ($logged->id == $user->id) {
                $can_edit = true;
            }

            // if the logged user is an admin, and the user doesnt have any privileges, can edit
            if ($logged->is_admin() && $user->is_admin() == false && $user->is_owner() == false) {
                $can_edit = true;
            }

            //if logged user is owner, can edit
            if ($logged->is_owner()) {
                $can_edit = true;
            }
        }

        //get the favorites
        $places = $user->favorites;

        //get the countries of the places
        $countries = $places->pluck('country')->unique()->values()->all();
        $variables = [
            'section_slug_key' => 'profile_slug',
            'locale' => $locale,

            'user' => $user,
            'logged' => $logged,
            'can_edit' => $can_edit,

            //#places_container variables
            'places' => $places,
            'countries' => $countries,
            'all_categories' => Category::all(),
            'fav_places_ids' => $fav_places_ids
        ];
        return view('front.users.show', $variables);
    }

    /*
     * Show logged-in user's profile edit form
     */
    public function edit($locale){
        $variables = [
            'user' => \Auth::user(),
            'locale' => $locale,
            'available_countries' => Country::getAvailableCountries(),
        ];

        return view('front.users.edit', $variables);
    }
}
