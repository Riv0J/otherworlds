<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Country extends Model
{
    use Translatable;
    use HasFactory;

    public $translatedAttributes = ['name'];

    public static function getAvailableCountries(){
        $unknown = Country::find(CountryTranslation::where('name','Unknown')->first()->country_id)->first();

        return Country::where('id','!=',$unknown->id)->get();
    }
}
