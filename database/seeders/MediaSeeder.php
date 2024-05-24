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
        $this->command->info('MEDIA SEEDER START --------------');
        $path = public_path('places/');
        $premade_thumbnails = [
            'great-barrier-reef' => 'https://unsplash.com/es/fotos/tortuga-marina-blanca-y-negra-bajo-el-agua-TLxTFr9AoO0',
            'great-blue-hole' => 'https://wallpapers.com/wallpapers/great-blue-hole-of-belize-m2bxmdinyppbfu9n.html',
            'geirangerfjord' => 'https://es.wikipedia.org/wiki/Fiordo_de_Geiranger#/media/Archivo:Fiordo_de_Geiranger,_Noruega,_2019-09-07,_DD_36.jpg',
            'mount-etna' => 'https://unsplash.com/es/fotos/vista-de-la-montana-m96cH5FOXOM',
            'mauna-loa' => 'https://commons.wikimedia.org/wiki/Category:Satellite_pictures_of_Mauna_Loa#/media/File:ISS-47_Mauna_Loa,_Hawaii.jpg',
            'towers-of-paine' => 'https://commons.wikimedia.org/wiki/Category:Torres_del_Paine_(mountain)#/media/File:CL_Torres_del_Paine_PN_0702_091_(17227574802).jpg',
            'los-glaciares' => 'https://commons.wikimedia.org/wiki/File:Perito_Moreno_Glacier_Patagonia_Argentina_Luca_Galuzzi_2005.JPG',
            'victoria-falls' => 'https://commons.wikimedia.org/wiki/Category:Aerial_photographs_of_Victoria_Falls#/media/File:Cataratas_Victoria,_Zambia-Zimbabue,_2018-07-27,_DD_04.jpg',
            'hopewell-rocks' => 'https://www.parcsnbparks.info/en/parks/33/hopewell-rocks-provincial-park',
            'rwenzori-mountains' => 'https://commons.wikimedia.org/wiki/Category:Ruwenzori_Range#/media/File:Ruwenzori_Vegetation_7.jpg',
            'bungle-bungle-range' => 'https://commons.wikimedia.org/wiki/File:00_2161_Purnululu-Nationalpark_-_Western_Australia.jpg',
            'caucasus-mountains '=> 'https://commons.wikimedia.org/wiki/File:Maly_and_Bolshoy_Tkhach%27s,_Adygea,_%D0%9C%D0%B0%D0%BB%D1%8B%D0%B9_%D0%B8_%D0%91%D0%BE%D0%BB%D1%8C%D1%88%D0%BE%D0%B9_%D0%A2%D1%85%D0%B0%D1%87,_%D0%90%D0%B4%D1%8B%D0%B3%D0%B5%D1%8F.jpg',
            'wrangel-island' => 'https://commons.wikimedia.org/wiki/File:%D0%9C%D0%B0%D0%BC%D0%B0-%D0%BC%D0%B5%D0%B4%D0%B2%D0%B5%D0%B4%D0%B8%D1%86%D0%B0_%D1%81_%D1%82%D1%80%D0%BE%D0%B9%D0%BD%D1%8F%D1%88%D0%BA%D0%B0%D0%BC%D0%B8.jpg',
            'lut-desert' => 'https://commons.wikimedia.org/wiki/File:Irnj256-Po%C5%9Br%C3%B3d_osta%C5%84c%C3%B3w_na_Pustyni_Loota.jpg',
            'the-sundarbans' => 'https://en.wikipedia.org/wiki/Tiger_attacks_in_the_Sundarbans#/media/File:Sundarban_Tiger.jpg',
            'okavango-delta' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cb/Red_Lechwe_in_the_Okavango.jpg/2560px-Red_Lechwe_in_the_Okavango.jpg',

        ];

        foreach (\App\Models\Place::all() as $place) {

            // create media for each image inside each place's public slug
            $place_path = $path.$place->public_slug;
            $files = glob($place_path . '/*.jpg');
            $files = array_merge($files, glob($place_path . '/*.jpeg'));
            $files = array_merge($files, glob($place_path . '/*.png'));
            $files = array_merge($files, glob($place_path . '/*.gif'));

            foreach ($files as $file_path) {
                $media_data = [
                    'url' => asset('otherworlds/public/places/'.$place->public_slug).'/'.basename($file_path),
                    'place_id' => $place->id
                ];
                if(isset($premade_thumbnails[$place->public_slug])){
                    $media_data['page_url'] = $premade_thumbnails[$place->public_slug];
                }

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
                    $this->command->info('Media seeder wikimedia gallery: '.$wikimedia_url);
                }

                if($sucess == true){
                    $place->gallery_url = $wikimedia_url;
                    $place->save();
                    break;
                }
            }
        }
    }
}
