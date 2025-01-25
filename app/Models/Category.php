<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model{
    use Translatable;
    protected $table = "categories";
    public $timestamps = false;
    protected $fillable = ['image_name'];
    public $translatedAttributes = ['name','description','keyword'];

    /**
     * Get the unknown category
     */
    public static function unknown_id(){
        return (CategoryTranslation::where('name', 'Unknown')->first())->category_id;
    }
}
