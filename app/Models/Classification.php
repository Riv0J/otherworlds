<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Classification extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name','description','keyword'];
    protected $fillable = [];
}
