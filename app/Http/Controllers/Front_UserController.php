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
class Front_UserController extends Controller{
    /*
     * Show a user's profile
     */
    function show($locale, $username){
        $user = User::where('name', $username)->first();
        if ($user == null) { redirect()->route('home', ['locale', $locale]); }

        //get the favorite places
        $places = $user->favorites;

        //get the logged in user
        $logged = Auth::user();

        //get the countries of the places
        $variables = [
            'slug_key' => 'profile_slug',
            'locale' => $locale,

            'user' => $user,
            'logged' => $logged,
            'can_edit' => $user->is_editable($logged),

            //#places_container variables
            'places' => $places,
            'countries' => $places->pluck('country')->unique()->values()->all(),
            'categories' => Category::all(),
        ];
        return view('front.users.show', $variables);
    }

    /*
     * Show logged-in user's profile edit form
     */
    public function edit($locale){
        $variables = [
            'slug_key' => 'profile_slug',
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
            $user->save_img($request->file('profile_img'));
        }

        $user->save();
        Session::flash('message', new Message(Message::TYPE_SUCCESS, trans('otherworlds.user_edit_success')));
        return redirect(get_url($locale,'profile_slug').'/'.$user->name);
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
