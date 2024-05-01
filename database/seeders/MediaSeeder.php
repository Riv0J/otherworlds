<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        foreach (\App\Models\Place::all() as $place) {

            // create media for each image inside each place's public slug
            $path = public_path('places/'.$place->public_slug);
            $files = glob($path . '/*.jpg');
            $files = array_merge($files, glob($path . '/*.jpeg'));
            $files = array_merge($files, glob($path . '/*.png'));
            $files = array_merge($files, glob($path . '/*.gif'));

            foreach ($files as $file_path) {
                $media_data = [
                    'url' => asset('otherworlds/public/places/'.$place->public_slug).'/'.basename($file_path),
                    'place_id' => $place->id
                ];
                // $this->command->info($media_data['url']);
                \App\Models\Media::create($media_data);
            }

            // create the medias for the place
            $locales = ['en','es'];

            for ($i=0; $i < count($locales); $i++) {
                $locale = $locales[$i];
                $sucess = false;

                // if place already has a gallery_url, use it
                $wikimedia_url = $place->gallery_url;
                if($wikimedia_url != null){
                    $sucess = $place->create_medias($wikimedia_url);
                } else {
                    // else try to fabricate the gallery url
                    $wikimedia_url = $place->create_gallery_url($locale);
                    $sucess = $place->create_medias($wikimedia_url);

                    // if fail, else try with the alternate gallery url
                    if($sucess == false){
                        $wikimedia_url = $place->create_gallery_url($locale, true);
                        $sucess = $place->create_medias($wikimedia_url);
                    }
                    $this->command->info($wikimedia_url);
                }

                if($sucess == true){ break; }
            }
        }
    }
}
