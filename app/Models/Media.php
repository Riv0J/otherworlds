<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model{
    protected $table = 'medias';
    protected $fillable = ['url', 'place_id'];

    public function place(){
        return $this->belongsTo(Country::class, 'country_id');
    }
}
