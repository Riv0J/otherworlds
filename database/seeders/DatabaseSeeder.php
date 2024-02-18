<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

use App\Models\Country;
use App\Models\Place;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // // Ruta del directorio
        // $directory = public_path('img/places');

        // // Verificar si el directorio existe
        // if (File::isDirectory($directory)) {
        //     // Obtener una lista de todos los archivos y directorios dentro del directorio
        //     $files = File::allFiles($directory);
        //     $directories = File::directories($directory);

        //     // Borrar todos los archivos dentro del directorio
        //     foreach ($files as $file) {
        //         File::delete($file);
        //     }

        //     // Borrar todos los directorios dentro del directorio
        //     foreach ($directories as $dir) {
        //         File::deleteDirectory($dir);
        //     }

        //     echo "Archivos y directorios borrados correctamente.";
        // } else {
        //     echo "El directorio no existe.";
        // }

        // execute the independent seeders
        $this->call([
            CountrySeeder::class,
        ]);

        $places = [
            [
                'es' => [
                    'name' => 'Cañón del Antílope',
                    'synopsis' => 'Cañón en el suroeste de Estados Unidos, en tierras navajos al este de Lechee, Arizona.',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Antelope Canyon',
                    'synopsis' => 'A slot canyon in the American Southwest, on Navajo land east of Lechee, Arizona.',
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
                    'synopsis' => 'The largest hot spring in the United States, and the third largest in the world.',
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'United States',
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

        }
    }

}
