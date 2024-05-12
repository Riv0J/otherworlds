<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Message;
use App\Models\Country;
use App\Models\Category;
class FrontUserController extends Controller{
    /*
     * Show a user's profile
     */
    function show($locale, $username){
        $user = User::where('name', $username)->first();
        if ($user == null) { redirect()->route('home', ['locale', $locale]); }

        //get the favorites
        $places = $user->favorites;

        //get the favorites of the loggeed
        $logged = Auth::user();
        $fav_places_ids = [];
        if($logged){
            $fav_places_ids = $logged->favorites->pluck('id');
        }

        //get the countries of the places
        $countries = $places->pluck('country')->unique()->values()->all();
        $variables = [
            'section_slug_key' => 'profile_slug',
            'locale' => $locale,

            'user' => $user,
            'logged' => $logged,
            'can_edit' => $user->is_editable($logged),

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
            'locale' => $locale,
            'user' => \Auth::user(),
            'countries' => Country::all(),
        ];

        return view('front.users.edit', $variables);
    }

    /**
     * Process a user's edit request
     */
    public function update(Request $request, $locale){
        $data = $request->all();

        $user = User::find($data['user_id']);
        if(!$user){ return redirect()->back()->withErrors("User not found"); }

        $can_edit = $user->is_editable(Auth::user());
        if(!$can_edit){ return redirect()->back()->withErrors("You cannot edit this user"); }

        $country = Country::find($data['country_id']);
        if(!$country){ return redirect()->back()->withErrors("Country not found"); }

        $validator = Validator::make($data, $user->rules($request));

        // redirect if validator fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $name_exists = User::where('name', $data['name'])->where('id','!=',$user->id)->exists();
        if($name_exists){ return redirect()->back()->withErrors(trans('otherworlds.name_taken', ['field' => $data['name']])); }

        $user->name = $data['name'];
        $user->country_id = $country->id;
        $user->birth_date = $data['birth_date'];

        if ($request->hasFile('profile_img')) {
            //delete current img file
            $user->delete_img();

            // move the new file into public/users
            $image = $request->file('profile_img');
            $image->move(public_path('users'), $user->id . '.' . $image->getClientOriginalExtension());
            $user->img = $user->id . '.' . $image->getClientOriginalExtension();
        }

        $user->save();
        Session::flash('message', new Message(Message::TYPE_SUCCESS, trans('otherworlds.user_edit_success')));
        return redirect()->route('user_show',['locale'=> $locale, 'username'=> $user->name]);
    }

    /**
     * Resets a logged-in user's profile image
     */
    public function reset_img(Request $request, $locale, $user_id){
        $user = User::find($user_id);
        if(!$user){ return redirect()->back()->withErrors("User not found"); }

        $can_edit = $user->is_editable(Auth::user());
        if(!$can_edit){ return redirect()->back()->withErrors("You cannot edit this user"); }

        //delete current img file
        $user->delete_img();

        $user->img = 'premade/ph'.rand(1,8).'.png';
        $user->save();

        Session::flash('message', new Message(Message::TYPE_SUCCESS, trans('otherworlds.user_edit_success')));
        return redirect()->back();
    }
}
