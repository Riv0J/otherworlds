<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

use App\Models\CountryTranslation;
use App\Models\ClassificationTranslation;
use App\Models\Place;
use App\Models\OHelper;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        //2. get all the places seed json
        $places_path = database_path('seeders/places_seeder.json');

        // Decodificar el contenido JSON en un array asociativo
        $places_data = json_decode(file_get_contents($places_path), true);

        // encode to json un
        // $places_json = json_encode($places_data, JSON_PRETTY_PRINT);

        // save the json to a path
        // file_put_contents($places_path, $places_json);

        //3. get the ids for unknown country and unknown class
        $unknown_country_id = CountryTranslation::where('name', 'Unknown')->value('country_id');
        $unknown_classification_id = ClassificationTranslation::where('keyword', 'Unknown')->value('classification_id');

        //4 create all the places in $places_data
        foreach ($places_data as $place_entry) {

            $place_data = [
                'views_count' => rand(100, 1000000),
                'favorites_count' => rand(100, 100000),
                'country_id' => CountryTranslation::where('name', $place_entry['country_name'])->value('country_id') ?? $unknown_country_id,
                'classification_id' => ClassificationTranslation::where('keyword', $place_entry['classification_keyword'])->value('classification_id') ?? $unknown_classification_id,
                'source' => $place_entry['source'] ?? null,
                'es' => $place_entry['es'],
                'en' => $place_entry['en'],
            ];

            $new_place = Place::create($place_data);

            // Crear un directorio para este lugar
            $path = public_path('img/places/' . $new_place->id);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // ver si hay fotos seeder guardadas con el name en ingles
            $seeder_images_path = public_path('img/place_seeders/' . OHelper::makeUrlFriendly($place_entry['en']['name']));

            $this->command->info($seeder_images_path);

            if (File::exists($seeder_images_path)) {
                //copiar los contenidos de seeder_images_path a $path
                File::copyDirectory($seeder_images_path, $path);
            }


        }
    }
}
