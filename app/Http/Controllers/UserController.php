<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Message;
use App\Models\Country;
use App\Models\Role;
class UserController extends Controller{

    /**
     * Show a the index of users to an admin
     */
    function index($locale){
        $variables = [
            'locale' => $locale,
            'users' => User::orderBy('role_id', 'asc')->get(),
            'logged' => auth()->user()
        ];
        return view('admin.users', $variables);
    }
    /**
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
            'roles' => Role::where('name', '!=',"owner")->get(),
        ];

        return view('admin.users.edit', $variables);
    }

    /**
     * Process a user edit request from an admin
     */
    public function update(Request $request, $locale){
        $data = $request->all();

        $user = User::find($data['user_id']);
        if(!$user){ return redirect()->back()->withErrors("User not found"); }

        $can_edit = $user->is_editable(Auth::user());
        if(!$can_edit){ return redirect()->back()->withErrors("You cannot edit this user"); }

        $country = Country::find($data['country_id']);
        if(!$country){ return redirect()->back()->withErrors("Country not found"); }

        $rules = $user->rules($request);
        $rules['email'] = 'required|email';

        if ($data['password'] != null) {
            $rules['password'] = 'string|min:4';
        }

        $validator = Validator::make($data, $rules);

        // redirect if validator fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $name_exists = User::where('name', $data['name'])->where('id','!=',$user->id)->exists();
        if($name_exists){ return redirect()->back()->withErrors(trans('otherworlds.name_taken', ['field' => $data['name']])); }

        $email_exists = User::where('email', $data['email'])->where('id','!=',$user->id)->exists();
        if($email_exists){ return redirect()->back()->withErrors(trans('otherworlds.email_taken', ['field' => $data['email']])); }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->country_id = $country->id;
        $user->birth_date = $data['birth_date'];
        $user->active = $request->has('active');
        $user->password = Hash::make($data['password']);

        // can change role if current user role is user or admin
        if($user->is_public() || $user->is_admin()){
            $role = Role::find($data['role']);
            if(!$role || $role->name == 'owner'){ return redirect()->back()->withErrors("Setting of owner role not permitted"); }
            $user->role_id = $role->id;
        }

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
        return redirect()->route('user_edit',['locale'=> $locale, 'username'=> $user->name]);
    }


    /**
     * Ajax, Resets a user's profile image
     */
    public function ajax_reset_img(Request $request){
        $response = [
            'message' => null,
            'user' => null
        ];
        try {
            $data = $request->all();
            $user = User::find($data['user_id']);
            if(!$user){
                // user not found, place a new message in response
                $response['message'] = new Message(Message::TYPE_ERROR, 'User not found');
                return response()->json($response);
            }

            $can_edit = $user->is_editable(Auth::user());
            if(!$can_edit){
                // no privilige to edit this user, place a new message in response
                $response['message'] = new Message(Message::TYPE_ERROR, 'You can\'t edit this user');
                return response()->json($response);
            }

            //delete current img file
            $user->delete_img();

            $user->img = 'ph'.rand(1,8).'.png';
            $user->save();

            $response['message'] = new Message(Message::TYPE_SUCCESS, "User '".$user->name."' image reset");
            $response['user'] = $user;
        } catch (\Throwable $th) {
            $response['message'] = new Message(Message::TYPE_ERROR, 'Unknown error on user image reset');
        }
        return response()->json($response);
    }

    /**
     * Ajax, toggle a user's active field
     */
    public function ajax_toggle_ban(Request $request){
        $response = [
            'message' => null,
            'user' => null
        ];
        try {
            $data = $request->all();
            $user = User::find($data['user_id']);
            if(!$user){
                // user not found, place a new message in response
                $response['message'] = new Message(Message::TYPE_ERROR, 'User not found');
                return response()->json($response);
            }

            $can_edit = $user->is_editable(Auth::user());
            if(!$can_edit){
                // no privilige to edit this user, place a new message in response
                $response['message'] = new Message(Message::TYPE_ERROR, 'You can\'t edit this user');
                return response()->json($response);
            }

            $user->active = !$user->active;
            $user->save();

            if($user->active == false){
                $response['message'] = new Message(Message::TYPE_BAN, "Banned '".$user->name."'!");
            } else {
                $response['message'] = new Message(Message::TYPE_SUCCESS, "User '".$user->name."' is active!");
            }

            $response['user'] = $user;
        } catch (\Throwable $th) {
            $response['message'] = new Message(Message::TYPE_ERROR, 'Unknown error on user image reset');
        }
        return response()->json($response);
    }

}
