<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Message;
use App\Models\Country;
use App\Models\Role;
class UserController extends Controller{

    /*
     * Show a user's edit form to an admin
     */
    public function edit($locale, $username){
        $user = User::where('name', $username)->first();
        if ($user == null) { redirect()->route('home', ['locale', $locale]); }

        $variables = [
            'locale' => $locale,
            'user' => $user,
            'logged' => \Auth::user(),
            'countries' => Country::all(),
            'roles' => Role::all(),
        ];

        return view('admin.users.edit', $variables);
    }

    /*
     * Receive a user edit request from an admin
     */
    public function update(Request $request, $locale){
        $data = $request->all();

        $user = User::find($data['user_id']);
        if(!$user){ return redirect()->back()->withErrors("User not found"); }

        $country = Country::find($data['country_id']);
        if(!$country){ return redirect()->back()->withErrors("Country not found"); }

        $validator = Validator::make($data, $user->rules($request));

        // redirect if validator fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $data['name'];
        $user->country_id = $country->id;
        $user->birth_date = $data['birth_date'];

        if ($request->hasFile('profile_img')) {

            //delete old img
            if ($user->img != null && !str_contains($user->img, 'ph')) {
                $old_img_route = public_path('users/'.$user->img);
                if (File::exists($old_img_route)) {
                    File::delete($old_img_route);
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

        Session::flash('message', new Message(Message::TYPE_SUCCESS, trans('otherworlds.user_edit_sucess')));

        return redirect()->route('user_show',['locale'=> $locale, 'username'=> $user->name]);
    }
}
