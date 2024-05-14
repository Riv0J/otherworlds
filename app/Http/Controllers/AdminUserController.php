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
class AdminUserController extends Controller{

    /**
     * Show a the index of users to an admin
     */
    public function index($locale){
        $users = $this->get_users(1);
        $variables = [
            'locale' => $locale,
            'users' => $users,
            'roles' => Role::all(),
            'countries' => $users->pluck('country')->unique()->values()->all(),
            'logged' => auth()->user()
        ];
        return view('admin.users.index', $variables);
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
        if($name_exists){ return redirect()->back()->withErrors(trans('otherworlds.name_taken', ['field' => $data['name']]))->withInput(); }

        $email_exists = User::where('email', $data['email'])->where('id','!=',$user->id)->exists();
        if($email_exists){ return redirect()->back()->withErrors(trans('otherworlds.email_taken', ['field' => $data['email']]))->withInput(); }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->country_id = $country->id;
        $user->birth_date = $data['birth_date'];
        $user->active = $request->has('active');
        $user->password = Hash::make($data['password']);

        // can change role if current user role is user or admin
        if($user->is_public() || $user->is_admin()){
            $role = Role::find($data['role']);
            if(!$role || $role->name == 'owner'){ return redirect()->back()->withErrors("Setting of owner role not permitted")->withInput(); }
            $user->role_id = $role->id;
        }

        if ($request->hasFile('profile_img')) {
            $user->save_img($request->file('profile_img'));
        }

        $user->save();
        Session::flash('message', new Message(Message::TYPE_SUCCESS, trans('otherworlds.user_edit_success')));
        return redirect()->route('user_edit',['locale'=> $locale, 'username'=> $user->name]);
    }
    /**
     * Show a create user form to an admin
     */
    public function create($locale){
        $variables = [
            'locale' => $locale,
            'logged' => \Auth::user(),
            'countries' => Country::all(),
            'roles' => Role::where('name', '!=',"owner")->get(),
        ];

        return view('admin.users.create', $variables);
    }

    /**
     * Store a new user created by an admin
     */
    public function store(Request $request, $locale){
        $data = $request->all();
        $rules = User::store_rules($request);

        $validator = Validator::make($data, $rules);

        // redirect if validator fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $name_exists = User::where('name', $data['name'])->exists();
        if($name_exists){ return redirect()->back()->withErrors(trans('otherworlds.name_taken', ['field' => $data['name']]))->withInput(); }

        $email_exists = User::where('email', $data['email'])->exists();
        if($email_exists){ return redirect()->back()->withErrors(trans('otherworlds.email_taken', ['field' => $data['email']]))->withInput(); }

        $new_user = User::create([
            'active'=> $request->has('active'),
            'name'=> $data['name'],
            'email'=> $data['email'],
            'password'=> Hash::make($data['password']),
            'role_id'=> $data['role_id'],
            'country_id'=> $data['country_id'],
            'birth_date'=> $data['birth_date']
        ]);

        if ($request->hasFile('profile_img')) {
            $new_user->save_img($request->file('profile_img'));
        }

        Session::flash('message', new Message(Message::TYPE_SUCCESS, trans('otherworlds.user_create_success')));
        return redirect()->route('user_index',['locale'=>$locale]);
    }

    /**
     * Get Users based on page
     */
    public static function get_users($page){
        // calculate the start index based on the page, and per page
        $per_page = 30;
        $start_index = ($page - 1) * $per_page;

        return User::orderBy('role_id','asc')
        ->skip($start_index)
        ->take($per_page)
        ->get('users.*');
    }

    /**
     * Ajax, request more users by page
     */

    public function ajax_user_request(Request $request){
        $request_data = $request->all(); //get request data
        app()->setLocale($request_data['locale']); //set locale to request
        $next_page = $request_data['current_page'] + 1; //advance page

        //get the places for next page
        $users = AdminUserController::get_users($page = $next_page);

        //get the countries for these users
        $countries = $users->pluck('country')->unique()->values()->all();

        if(count($users) === 0){
            //if no places, means there is no next page
            $next_page = -1;
        }

        $variables = [
            'current_page' => $next_page,
            'users' => $users,
            'countries' => $countries,
        ];

        return response()->json($variables); //convert vars to json
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

            $user->img = 'premade/ph'.rand(1,8).'.png';
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
