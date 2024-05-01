<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

use \App\Models\Crawly;
class Place extends Model{
    use Translatable;
    protected $table = 'places';
    protected $fillable = ['country_id', 'public_slug', 'views_count','favorites_count','natural', 'gallery_url', 'latitude', 'longitude'];
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

    /**
     * Generates the Wikimedia URL for this place's gallery
     *
     * Examples:
     * - Standard URL: https://commons.wikimedia.org/wiki/Antelope_Canyon
     * - Alternate URL (with $alternate = true): https://commons.wikimedia.org/wiki/Category:Antelope_Canyon
     *
     * @param string $locale The locale to generate the url
     * @param bool $alternate (Optional) Whether to generate an alternate URL. Default is false
     * @return string|null The generated Wikimedia URL, or null if the source is not available
     */
    public function create_gallery_url(string $locale, bool $alternate = false){
        // get the place's source in english
        $source = $this->getSource($locale);

        if($source == null){ return false; } //if no source, return false

        // build link to wikimedia gallery
        $place_gallery_slug = str_replace(' ','_',$source->title);

        // wikimedia gallery prefix + slug source title
        $wikimedia_url = null;

        if($alternate == true){
            $wikimedia_url = 'https://commons.wikimedia.org/wiki/Category:'.$place_gallery_slug;
        }else{
            $wikimedia_url = 'https://commons.wikimedia.org/wiki/'.$place_gallery_slug;
        }
        return $wikimedia_url;
    }

    /**
     * Given a Wikimedia URL, try to create the medias for this place
     *
     * @param string $wikimedia_url The URL of the Wikimedia page
     * @return bool True if images were successfully retrieved and processed, otherwise false
     */
    public function create_medias(string $wikimedia_url){
        // try crawling $wikimedia_url
        $images_count = 20;
        try {
            // get the urls of all the images in the wikimedia_url
            $gallery_urls = Crawly::get_gallery_urls($wikimedia_url, $images_count);
        } catch (\Throwable $th) {
            error_log("---".$this->name.": Error while fetching ".$wikimedia_url.". Either does not exist or: " . $th->getMessage());
            return false;
        }

        // if image urls were found, continue the process
        if($gallery_urls != null){

            // save the place gallery url if it was null
            if($this->gallery_url == null){
                $this->gallery_url = $wikimedia_url;
                $this->save();
            }

            // create a Media for each $file_url
            foreach ($gallery_urls as $media_urls) {
                try {
                    // let crawly get the media data from a media page url
                    $media_data = Crawly::get_media_data($media_urls['media_page_url']);

                    // add urls to media_data
                    $media_data['thumbnail_url'] = $media_urls['thumbnail_url'];
                    $media_data['page_url'] = $media_urls['media_page_url'];
                    $media_data['place_id'] = $this->id;

                    // crawl the file page url and extract the image url
                    \App\Models\Media::create($media_data);
                } catch (\Throwable $th) {
                    error_log("---ERROR TRYING TO FETCH IMAGE PAGE: ".$media_urls['media_page_url']."\n " . $th->getMessage());
                }
            }
            return true;
        } else {
            error_log("---NO IMAGES IN WIKI GALLERY: ".$wikimedia_url);
        }
        return false;
    }
}

