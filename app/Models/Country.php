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
}
