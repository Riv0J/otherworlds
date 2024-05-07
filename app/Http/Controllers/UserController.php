<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

        $logged = Auth::user();
        $fav_places_ids = [];
        //get the favorites
        $places = $user->favorites;

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
            'user' => \Auth::user(),
            'locale' => $locale,
            'available_countries' => Country::getAvailableCountries(),
        ];

        return view('front.users.edit', $variables);
    }

    /*
     * Receive a user edit request
     */
    public function update(Request $request, $locale){
        $data = $request->all();

        $user = User::find($data['user_id']);
        if(!$user){ return redirect()->back()->withErrors("User not found"); }

        $country = Country::find($data['country_id']);
        if(!$country){ return redirect()->back()->withErrors("Country not found"); }
        $rules = User::rules($request);

        $validator = Validator::make($data, User::rules($request));

        // redirect if validator fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $data['name'];
        $user->country_id = $country->id;
        $user->birth_date = $data['birth_date'];

        if ($request->hasFile('profile_img')) {

            //delete old img
            if ($user->img != null && $user->img != 'ph.png') {
                $old_img_route = storage_path('app/users/'.$user->img);
                if(Storage::exists($old_img_route)){
                    Storage::delete($old_img_route);
                }
            }

            // Define la ruta donde se guardará el archivo en el directorio público
            $publicPath = public_path('users');

            $image = $request->file('profile_img');
            // Mueve el archivo a la ubicación deseada en el directorio público
            $image->move($publicPath, $user->id . '.' . $image->getClientOriginalExtension());

            // Actualiza el campo de imagen del usuario con el nombre del archivo
            $user->img = $user->id . '.' . $image->getClientOriginalExtension();

            // Guarda los cambios en el usuario
            $user->save();
        }

        $user->save();

        return redirect()->route('user_show',['locale'=> $locale, 'username'=> $user->name]);
    }
}
