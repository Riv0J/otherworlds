<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $table = 'sources';

    protected $fillable = ['place_id', 'locale', 'url', 'content'];

    public function place(){
        return $this->belongsTo(Place::class);
    }
}
