<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table = 'categories_translations';
    public $timestamps = false;
    protected $fillable = ['name','description','keyword'];
}
