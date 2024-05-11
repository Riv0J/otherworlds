<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;

class User extends Authenticatable{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'birth_date',
        'role_id',
        'country_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function active(){
        return $this->active;
    }

    //get the user's role
    public function role(){
        return $this->belongsTo(Role::class);
    }

    //get the user's favorite places
    public function favorites(){
        return $this->belongsToMany(Place::class, 'favorites', 'user_id', 'place_id');
    }

    //get the user's country
    public function country(){
        return $this->belongsTo(Country::class);
    }
    //check if user is owner
    public function is_owner(){
        return $this->role->name === 'owner';
    }
    //check if user is an admin
    public function is_admin(){
        return $this->role->name === 'admin';
    }
    //check if user is a public user
    public function is_public(){
        if($this->role->name === 'user'){
            return true;
        }
        return false;
    }
    //check if user is editable by another
    public function is_editable(?User $user){
        if($user == null){ return false; }

        //if the user editing is owner
        if($user->is_owner()){
            return true;
        }

        //if the user editing is admin, and it's trying to edit a public user
        if($user->is_admin() && $this->is_public()){
            return true;
        }

        //if the id is the same, true
        if ($this->id == $user->id) {
            return true;
        }

        return false;
    }
    //override Model create
    public static function create(array $attributes = []){
        // check country_id attribute
        if(!isset($attributes['country_id'])){
            $unknown_country_id = CountryTranslation::where('name', 'Unknown')->value('country_id');

            //set unknown_country_id
            $attributes['country_id'] = $unknown_country_id;
        }
        if(!isset($attributes['img'])){
            $attributes['img'] = 'ph'.rand(1,9).'.png';
        }

        // create instance with given array
        $model = new static($attributes);
        // save instance
        $model->save();

        return $model;
    }

    /*
     * Get the rules to validate a user update request, used in UserController update
     */
    public function rules(Request $request){
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'country_id' => 'required',
            'birth_date' => 'nullable|date|date_format:Y-m-d|before_or_equal:today|after_or_equal:1900-01-01',
        ];

        if ($request->hasFile('profile_img')) {
            $rules['profile_img'] = 'image|mimes:jpg,jpeg,png,gif,webp';
            if($this->is_public()){
                $rules['profile_img'] = $rules['profile_img'].'|max:2048';
            }
        }

        return $rules;
    }
}
