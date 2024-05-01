<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model{
    protected $table = 'countries_translations';
    public $timestamps = false;
    protected $fillable = ['locale', 'name'];

}
