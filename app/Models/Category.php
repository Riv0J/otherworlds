<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model{
    use Translatable;
    protected $table = "categories";
    public $timestamps = false;
    public $translatedAttributes = ['name','description','keyword'];
}
