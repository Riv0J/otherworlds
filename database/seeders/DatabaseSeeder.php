<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
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
                    'name' => 'Monte Roraima',
                    'synopsis' => 'Alta meseta de roca, con millones de años de antigüedad',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Mount Roraima',
                    'synopsis' => "Tall, millions of years old rock plateau",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Venezuela',
            ],
            [
                'es' => [
                    'name' => 'Gruta de Fingal',
                    'synopsis' => 'Cueva formada por columnas de basalto hexagonales',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => "Fingal's Cave",
                    'synopsis' => "Cave formed from Hexagonal basalt columns",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Scotland',
            ],
            [
                'es' => [
                    'name' => 'Cataratas del Niágara',
                    'synopsis' => 'Las tres hermosas cascadas en el rio Niágara',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Niagara Falls',
                    'synopsis' => "The three beautiful waterfalls at the southern end of Niagara Gorge",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Canada',
            ],
            [
                'es' => [
                    'name' => 'Lago Cocibolca & Ometepe',
                    'synopsis' => 'El lago más grande de america central con su isla volcánica',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Lake Cocibolca & Ometepe',
                    'synopsis' => "Central America's largest lake and it's volcanic island",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Nicaragua',
            ],
            [
                'es' => [
                    'name' => 'Montañas Zangye Danxia',
                    'synopsis' => 'Formaciones geológicas de arenisca multicolor',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Zangye Danxia Mountains',
                    'synopsis' => "Colorful sandstone rock formations",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'China',
            ],
            [
                'es' => [
                    'name' => 'Cañón del Colca',
                    'synopsis' => 'Montañas con profundidad de 3250m a lo largo del río Colca',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Colca Canyon',
                    'synopsis' => "Mountains with a depth of 3250 meters along the Colca River",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Peru',
            ],
        ];


        foreach ($places as $place_entry) {

            $place_data = [
                'views_count'=> rand(100,1000),
                'favorites_count'=> rand(100,1000),
                'country_id' => Country::where('name', $place_entry['country_name'])->value('id') ?? Country::where('name', 'Unknown')->value('id'),
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

            $this->command->info($seeder_images_path);

            if(File::exists($seeder_images_path)){
                //copiar los contenidos de seeder_images_path a $path
                File::copyDirectory($seeder_images_path, $path);
            }


        }


        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
        ]);
    }

}
