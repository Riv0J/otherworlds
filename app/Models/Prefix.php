<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prefix extends Model{
    protected $table = 'prefixes';
    protected $fillable = ['keyword', 'url', 'description'];
    public $timestamps = false;
}
