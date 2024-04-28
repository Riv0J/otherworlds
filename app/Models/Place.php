<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

class Place extends Model
{
    use HasFactory;
    use Translatable;
    protected $table = 'places';

    protected $fillable = ['country_id', 'views_count','favorites_count','natural', 'gallery_url', 'latitude', 'longitude'];
    public $translatedAttributes = ['name', 'synopsis', 'slug'];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function sources(){
        return $this->hasMany(Source::class);
    }
    public function medias(){
        return $this->hasMany(Media::class);
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

    /*
     * Try to get place's gallery images from Wikimedia
     */
    public function fetch_gallery(){
        // get the place's source in english
        $source = $this->getSource('en');

        if($source == null){ return; }

        // build link to wikimedia
        $wikimedia_url = 'https://commons.wikimedia.org/wiki/'.str_replace(' ','_',$source->title);

        // try crawling
        $img_urls = \App\Models\Crawly::crawl_gallery($wikimedia_url, 20);

        // if it failed, add Category: to url, it is almost guaranteed to have images
        if($img_urls == null){
            $wikimedia_url = 'https://commons.wikimedia.org/wiki/Category:'.str_replace(' ','_',$source->title);
        }

        // try crawling again
        $img_urls = \App\Models\Crawly::crawl_gallery($wikimedia_url, 20);

        // if images were found, continue the process
        if($img_urls != null){

            // update the place source for images
            $this->gallery_url = $wikimedia_url;
            $this->save();

            foreach ($img_urls as $url) {
                $media_data = [
                    'url' => $url,
                    'place_id' => $this->id
                ];
                error_log($url);
                try {
                    \App\Models\Media::create($media_data);
                } catch (\Throwable $th) {
                    //throw $th;
                }

            }
        } else {
            error_log("NO IMAGES IN WIKI GALLERY FOR: ".$this->name);
        }
    }
}

