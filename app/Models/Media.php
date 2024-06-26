<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
class Media extends Model{
    use Translatable;
    protected $table = 'medias';
    protected $fillable = ['url', 'thumbnail_url', 'page_url', 'place_id'];
    public $translatedAttributes = ['description'];
    public $timestamps = false;
    public function place(){
        return $this->belongsTo(Country::class, 'country_id');
    }

}
