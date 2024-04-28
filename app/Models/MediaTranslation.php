<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaTranslation extends Model{
    protected $table = 'medias_translations';
    public $timestamps = false;
    protected $fillable = ['locale', 'description'];
}
