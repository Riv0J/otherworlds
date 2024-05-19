<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\CountryTranslation;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $unknown = Country::find(CountryTranslation::where('name','Unknown')->first()->country_id)->first();
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => [
                'required',
                'string',
                'max:255',
                Rule::notIn([$unknown->id]) // Aquí se asegura de que el valor no sea igual al ID del país desconocido
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user_role = Role::where('name','user')->first();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'birth_date' => $data['birth_date'],
            'password' => Hash::make($data['password']),
            'role_id' => $user_role->id,
            'country_id' => $data['country'],
        ]);
    }

    /**
     * Show register form
     */
    function show_register($locale){
        $variables = [
            'slug_key' => 'register_slug',
            'locale' => $locale,
            'countries' => Country::all()
        ];
        return view('auth.register', $variables);
    }

    /**
     * Handle a registration request
     */
    public function handle_register(Request $request, string $locale){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($locale.$this->redirectTo);
    }
}
