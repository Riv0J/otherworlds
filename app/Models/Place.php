<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

use Astrotomic\Translatable\Translatable;

use \App\Models\Crawly;

class Place extends Model{
    use Translatable;
    protected $table = 'places';
    protected $fillable = ['category_id', 'country_id', 'public_slug', 'views_count','favorites_count','natural', 'gallery_url', 'latitude', 'longitude','checked'];
    public $translatedAttributes = ['name', 'synopsis', 'slug'];
    public function country(){ //about to be deprecated
        return $this->belongsTo(Country::class, 'country_id');
    }
    // public function countries(){
    //     return $this->belongsToMany(Country::class, 'places_countries')
    //                 ->withPivot('order')
    //                 ->orderBy('places_countries.order', 'asc'); // ordered
    // }
    // public function add_country($country_id){
    //     $next = ($this->countries()->max('order') ?? 0) + 1;
    //     $this->countries()->attach($country_id, ['order' => $next]);
    // }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function sources(){
        return $this->hasMany(Source::class);
    }
    public function medias(){
        return $this->hasMany(Media::class);
    }
    public function public_path(){
        return public_path('places/'.$this->public_slug);
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
     *  Get a random place
     */
    public static function random(){
        return Place::inRandomOrder()->first();
    }

    /**
     *  Get this place's full public slug directory path
     */
    public function get_path(){
        return public_path('places/'.$this->public_slug);
    }

    /**
     * Update this place's public slug directory
     */
    public function update_public_slug($new_value){
        $old_path = $this->get_path();
        $this->public_slug = $new_value;
        $new_path = $this->get_path();
        if (File::exists($old_path)) {
            File::move($old_path, $new_path);
        }
    }
    /**
     * Delete this place's public slug directory
     */
    public function delete_public_slug(){
        $path = $this->get_path();
        if (File::exists($path)) {
            return File::deleteDirectory($path);
        }
    }
    /*
     * Deletes this places's saved thumbnail image
     */
    public function delete_thumbnail(){
        if($this->thumbnail == null){ return; }
        $old_img_route = public_path('places/'.$this->public_slug.'/'.$this->thumbnail);
        if (File::exists($old_img_route)) {
            File::delete($old_img_route);
        }
    }

    /*
     * Updates this places's saved thumbnail image
     */
    public function save_thumbnail(UploadedFile $image){
        if ($image->isValid() == false) {
            return false;
        }

        $this->delete_thumbnail();
        $filename = 't.' . $image->getClientOriginalExtension();
        $image->move(public_path('places/'.$this->public_slug), $filename);

        $this->thumbnail = $filename;
        $this->save();

        return true;
    }

    /**
     * Set this place's thumbnail to first media
     */
    public function media_thumbnail(){
        for ($i=0; $i < count($this->medias); $i++) {
            $media_url = $this->medias[$i]->url;
            if($this->thumbnail == basename($media_url)){
                continue;
            }

            $image_data = OHelper::download_image($media_url);
            $destination = public_path('places/' . $this->public_slug);

            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            $filename = 't.' . $image_data['extension'];
            error_log($image_data['temp_path']);
            if(!rename($image_data['temp_path'], $destination . '/' . $filename)){
                unlink($image_data['temp_path']);
            } else {
                $this->thumbnail = $filename;
                $this->save();
                return true;
            }
        }
        return false;
    }

    /**
     * Attempt to create medias for this place
     * Assumes this place has already a source at the current locale
     */
    public function attempt_create_medias($gallery_url){
        try {
            //attempt given the gallery url
            $first_attempt = $this->create_medias($gallery_url);
            if($first_attempt == true){
                return true;
            }

            //fabricate the gallery url
            $locale = null;
            $gallery_url = $this->create_gallery_url($locale, false);
            if(!$gallery_url){
                $gallery_url = $this->create_gallery_url($locale, true);
            }
            return $this->create_medias($gallery_url);
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
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
    public function create_gallery_url(?string $locale, bool $alternate = false){
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
            $this->gallery_url = $wikimedia_url;
            $this->save();
            // get the urls of all the images in the wikimedia_url
            $gallery_urls = Crawly::get_gallery_urls($wikimedia_url, $images_count);

        } catch (\Throwable $th) {
            error_log("---".$this->name.": Error while fetching ".$wikimedia_url.". Either does not exist or: " . $th->getMessage());
            return false;
        }

        // if image urls were found, continue the process
        if($gallery_urls != null){

            // save the place gallery url if it was null for this place
            if($this->gallery_url == null){
                $this->gallery_url = $wikimedia_url;
                $this->save();
            }

            // create a Media for each $file_url
            foreach ($gallery_urls as $media_urls) {
                try {
                    // let crawly get the media data from a media page url
                    $media_data = Crawly::get_media_data($media_urls['media_page_url']);

                    $eligible = true;
                    $banned_extensions = ['.tiff'];
                    foreach ($banned_extensions as $ext) {
                        if (Str::endsWith($media_urls['media_page_url'], $ext)) {
                            $eligible = false;
                            break;
                        }
                    }
                    // dont create the media if eligible is false
                    if($eligible = false) { break; }

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

    /**
     * Check if a given name already exists in the database
     */
    public static function name_exists($name){
        return PlaceTranslation::where('name', $name)->exists();
    }
}

