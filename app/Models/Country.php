<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Country extends Model{
    use Translatable;
    protected $table = "countries";
    public $timestamps = false;
    public $translatedAttributes = ['name'];
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
}
