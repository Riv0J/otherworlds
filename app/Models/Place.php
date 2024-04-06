<?php

namespace App\Models;
use App\Models\PlaceTranslation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Place extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name', 'synopsis', 'description'];
    protected $fillable = ['country_id', 'views_count','favorites_count','source','natural'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function is_favorite(User $user){
        return $user->favorites()->where('place_id', $this->id)->exists();
    }
}

