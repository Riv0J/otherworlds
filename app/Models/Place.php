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
    protected $table = 'places';

    protected $fillable = ['country_id', 'views_count','favorites_count','natural', 'latitude', 'longitude'];
    public $translatedAttributes = ['name', 'synopsis', 'slug'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function sources(){
        return $this->hasMany(Source::class);
    }

    /*
     *  Determine if this place is a user's favorite
     */
    public function is_favorite(User $user){
        return $user->favorites()->where('place_id', $this->id)->exists();
    }

    /*
     *  Get the place's source in a specific locale
     */
    public function getSource(?string $locale){
        return $this->sources()->where('locale', $locale ?: app()->getLocale())->first();
    }
}

