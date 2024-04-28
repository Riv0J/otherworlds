<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Country extends Model{
    use Translatable;

    public $translatedAttributes = ['name'];

    public static function getAvailableCountries(){
        $unknown = Country::find(CountryTranslation::where('name','Unknown')->first()->country_id)->first();

        return Country::where('id','!=',$unknown->id)->get();
    }
}
