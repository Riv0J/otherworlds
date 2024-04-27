<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceTranslation extends Model{
    protected $table = 'places_translations';
    protected $fillable = ['locale', 'name', 'synopsis', 'slug'];
    public $timestamps = false;

}
