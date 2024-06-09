<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model{
    protected $table = 'sources';
    protected $fillable = ['place_id', 'locale', 'url', 'title', 'content'];
    public $timestamps = true;
    public function place(){
        return $this->belongsTo(Place::class);
    }

    /**
     * Fill this source's attributes with its URL
     */
    public function scrape_fill(){
        $content_data = OHelper::getWikiContent($this->url);

        $this->content = $content_data['content'];
        $this->title = $content_data['title'];
        $this->save();

        //apply the coords
        if($content_data['latitude'] != null && $content_data['longitude'] != null){
            $this->place->latitude = $content_data['latitude'];
            $this->place->longitude = $content_data['longitude'];
            $this->place->save();
        }
        return $content_data;
    }
}
