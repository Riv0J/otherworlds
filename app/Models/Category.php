<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = "categories";
    public $translatedAttributes = ['name','description','keyword'];
    protected $fillable = [];
}
