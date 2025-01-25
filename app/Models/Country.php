<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Country extends Model{
    use Translatable;
    protected $table = "countries";
    public $timestamps = false;
    public $translatedAttributes = ['name'];

    public function main_places(){ //about to be deprecated
        return $this->hasMany(Place::class);
    }
    public function places(){
        return $this->belongsToMany(Place::class, 'places_countries');
    }

    /**
     * Determine if the place is unknown
     */
    public function is_unknown(){
        $unknown = CountryTranslation::where('name', 'Unknown')->first();
        return $this->id == $unknown->country_id;
    }
    
    /*
     *  Get Countries that are not unknown
     */
    public static function getAvailableCountries(){
        $unknown = Country::find(CountryTranslation::where('name','Unknown')->first()->country_id)->first();

        return Country::where('id','!=',$unknown->id)->get();
    }

    /*
     *  Get a random country
     */
    public static function random(){
        return Country::inRandomOrder()->first();
    }

    /*
     *  Get the unknown country
     */
    public static function unknown_id(){
        return (CountryTranslation::where('name', 'Unknown')->first())->country_id;
    }
}
