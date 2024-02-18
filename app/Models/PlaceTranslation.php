<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceTranslation extends Model
{
    protected $table = 'places_translations';
    public $timestamps = false;
    protected $fillable = ['locale', 'name', 'synopsis', 'description'];

}
