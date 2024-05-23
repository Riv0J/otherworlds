<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model{
    protected $table = 'visits';
    protected $fillable = ['ip', 'browser', 'os', 'route', 'country_id'];
    public $timestamps = true;

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
}
