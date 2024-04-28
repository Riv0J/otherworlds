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
        $place_gallery_slug = str_replace(' ','_',$source->title);

        // wikimedia gallery prefix + slug source title
        $wikimedia_url = 'https://commons.wikimedia.org/wiki/'.$place_gallery_slug;

        // try crawling
        $images_count = 20;
        $gallery_urls = Crawly::get_gallery_files_urls($wikimedia_url, $images_count);

        // if it failed, use alternate wikimedia gallery prefix, it is almost guaranteed to have images
        if($gallery_urls == null){

            // try build with Category to wikimedia gallery
            $wikimedia_url = 'https://commons.wikimedia.org/wiki/Category:'.$place_gallery_slug;

            // try crawling again with new url
            $gallery_urls = Crawly::get_gallery_files_urls($wikimedia_url, $images_count);
        }

        // if images were found, continue the process
        if($gallery_urls != null){

            // update the place gallery url
            $this->gallery_url = $wikimedia_url;
            $this->save();

            // create a Media for each $file_url
            foreach ($gallery_urls as $file_url) {

                try {
                    // let crawly get the media data
                    $media_data = Crawly::get_media_data($file_url);

                    // add to media_data
                    $media_data['place_id'] = $this->id;

                    // crawl the file page url and extract the image url
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

