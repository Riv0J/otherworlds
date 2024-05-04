<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    //check if user is an admin
    public function is_admin(){
        return $this->role->name === 'admin';
    }

    //override Model create
    public static function create(array $attributes = []){
        // check country_id attribute
        if(!isset($attributes['country_id'])){
            $unknown_country_id = CountryTranslation::where('name', 'Unknown')->value('country_id');

            //set unknown_country_id
            $attributes['country_id'] = $unknown_country_id;
        }

        // create instance with given array
        $model = new static($attributes);
        // save instance
        $model->save();

        return $model;
    }
}
