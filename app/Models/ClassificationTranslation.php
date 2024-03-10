<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationTranslation extends Model
{
    protected $table = 'classifications_translations';
    public $timestamps = false;
    protected $fillable = ['name','description','keyword'];
}
