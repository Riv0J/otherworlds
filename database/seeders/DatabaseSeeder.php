<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

use App\Models\Country;
use App\Models\Place;

use App\Models\OHelper;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //1. borrar el contenido de la carpeta places
        $directory = public_path('img/places');

        // Verificar si el directorio existe
        if (File::isDirectory($directory)) {
            // Obtener una lista de todos los archivos y directorios dentro del directorio
            $files = File::allFiles($directory);
            $directories = File::directories($directory);

            // Borrar todos los archivos dentro del directorio
            foreach ($files as $file) {
                File::delete($file);
            }

            // Borrar todos los directorios dentro del directorio
            foreach ($directories as $dir) {
                File::deleteDirectory($dir);
            }

        } else {
            echo "El directorio no existe.";
        }

        // execute the independent seeders
        $this->call([
            CountrySeeder::class,
        ]);

        $places = [
            [
                'es' => [
                    'name' => 'Cañón del Antílope',
                    'synopsis' => 'Cañón en el suroeste de Estados Unidos, en tierras navajos al este de Lechee, Arizona',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Antelope Canyon',
                    'synopsis' => 'A slot canyon in the American Southwest, on Navajo land east of Lechee, Arizona',
                    'description' => 'Description in English',
                ],
                'country_name' => 'United States',
            ],
            [
                'es' => [
                    'name' => 'Gran Manantial Prismático',
                    'synopsis' => 'El manantial termal más grande de Estados Unidos y el tercero más grande del mundo.',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Grand Prismatic Spring',
                    'synopsis' => 'The largest hot spring in the United States, and the third largest in the world',
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'United States',
            ],
            [
                'es' => [
                    'name' => 'Salar de Uyuni',
                    'synopsis' => 'El mayor desierto de sal continuo y alto del mundo',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Uyuni Salt Flat',
                    'synopsis' => "The world's largest salt flat playa",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Bolivia',
            ],
            [
                'es' => [
                    'name' => 'Laguna Rosa de Torrevieja',
                    'synopsis' => 'Sumérgete en un lago de agua de color rosa',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Pink Lake of Torrevieja',
                    'synopsis' => "Submerge yourself into a pink-water lake",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Spain',
            ],
            [
                'es' => [
                    'name' => 'Parque Nacional Canaima',
                    'synopsis' => 'Sumérgete en un lago de agua de color rosa.',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Canaima National Park',
                    'synopsis' => "Occupied by plateaus of rock, with millions of years old",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Spain',
            ],
        ];

        foreach ($places as $place_entry) {

            $place_data = [
                'country_id' => Country::where('name', $place_entry['country_name'])->value('id'),
                'es' => $place_entry['es'],
                'en' => $place_entry['en'],
            ];

            $new_place = Place::create($place_data);

            // Crear un directorio para este lugar
            $path = public_path('img/places/'.$new_place->id);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // ver si hay fotos seeder guardadas con el name en ingles
            $seeder_images_path = public_path('img/place_seeders/'.OHelper::makeUrlFriendly($place_entry['en']['name']));

            if(File::exists($seeder_images_path)){
                //copiar los contenidos de seeder_images_path a $path
                File::copyDirectory($seeder_images_path, $path);
            }

        }
    }

}
