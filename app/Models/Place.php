<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

use \App\Models\Crawly;
use \App\Models\Prefix;
class Place extends Model{
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
    public function fetch_wikimedia_gallery(){
        // get the place's source in english
        $source = $this->getSource('en');


        if($source == null){ return false; } //if no source, return false

        // build link to wikimedia gallery
        $gallery_prefix = Prefix::where('keyword', 'wikimedia_gallery')->first();
        $wikimedia_url = $gallery_prefix->url.''.str_replace(' ','_',$source->title); // wikimedia gallery prefix + slug source title

        // try crawling
        $images_count = 20;
        $gallery_urls = Crawly::get_gallery_files_urls($wikimedia_url, $images_count);

        // if it failed, use alternate wikimedia gallery prefix, it is almost guaranteed to have images
        if($gallery_urls == null){
            $gallery_prefix = Prefix::where('keyword', 'wikimedia_gallery_alt')->first();
            $wikimedia_url = $gallery_prefix->url.str_replace(' ','_',$source->title); // wikimedia gallery alt prefix + slug source title

            // try crawling again with alternate in url
            $gallery_urls = Crawly::get_gallery_files_urls($wikimedia_url, $images_count);
        }

        // if images were found, continue the process
        if($gallery_urls != null){
            // update the place gallery url
            $this->gallery_url = $wikimedia_url;
            $this->save();

            foreach ($gallery_urls as $file_url) {

                // crawl the file page url and extract the image url
                try {
                    $media_data = Crawly::get_media_data($file_url);

                    // add to media_data
                    $media_data['place_id'] = $this->id;
                    $media_data['prefix_id'] = $gallery_prefix->id;

                    \App\Models\Media::create($media_data);
                } catch (\Throwable $th) {
                    error_log("ERROR TRYING TO FETCH: ".$file_url."\n " . $th->getMessage());
                }
            }
            return true;
        } else {
            error_log("NO IMAGES IN WIKI GALLERY FOR: ".$this->name);
        }
        return false;
    }
}

