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

        // places data
        $places_data = [
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
                'classification_keyword' => 'Valleys',
                'source' => 'https://en.wikipedia.org/wiki/Antelope_Canyon',
            ],
            [
                'es' => [
                    'name' => 'Punto Bryce',
                    'synopsis' => 'Increible vista de formaciones de roca en forma de torres "hoodos"',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Bryce Point',
                    'synopsis' => 'Incredible vistas of "hoodoo" rock formations',
                    'description' => 'Description in English',
                ],
                'country_name' => 'United States',
                'classification_keyword' => 'Mountains',
                'source' => 'https://en.wikipedia.org/wiki/Bryce_Canyon_National_Park'
            ],
            [
                'es' => [
                    'name' => 'Valle de los monumentos',
                    'synopsis' => 'Conjunto de formaciones rocosas "butte" en el valle del Colorado',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Monument Valley',
                    'synopsis' => 'Cluster of sandstone "buttes" rock formations in the Colorado plateau',
                    'description' => 'Description in English',
                ],
                'country_name' => 'United States',
                'classification_keyword' => 'Valleys',
                'source' => 'https://en.wikipedia.org/wiki/Monument_Valley'
            ],
            [
                'es' => [
                    'name' => 'Gran Cañón del Colorado',
                    'synopsis' => 'Vistosa y escarpada garganta de roca excavada por el río Colorado a lo largo de millones de años',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Grand Canyon',
                    'synopsis' => 'A steep-sided canyon carved by the Colorado River over millions of years',
                    'description' => 'Description in English',
                ],
                'country_name' => 'United States',
                'classification_keyword' => 'Valleys',
                'source' => 'https://en.wikipedia.org/wiki/Grand_Canyon',
            ],
            [
                'es' => [
                    'name' => 'Acantilados de Nullarbor',
                    'synopsis' => 'Linea costera de 210Km de acantilados rocosos de 60 metros de altura',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Nullarbor Cliffs',
                    'synopsis' => '210 km of coastline featuring rocky cliffs towering 60 meters in height',
                    'description' => 'Description in English',
                ],
                'country_name' => 'Australia',
                'classification_keyword' => 'Coastal',
                'source' => 'https://en.wikipedia.org/wiki/Bunda_Cliffs',
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
                'classification_keyword' => 'Volcanic',
                'source' => 'https://en.wikipedia.org/wiki/Grand_Prismatic_Spring',
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
                'classification_keyword' => 'Valleys',
                'source' => 'https://en.wikipedia.org/wiki/Salar_de_Uyuni',
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
                'classification_keyword' => 'Water',
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
                'classification_keyword' => 'Mountains',
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
                'classification_keyword' => 'Caves',
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
                'classification_keyword' => 'Water',
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
                'classification_keyword' => 'Volcanic',
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
                'classification_keyword' => 'Mountains',
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
                'classification_keyword' => 'Valleys',
            ],
            [
                'es' => [
                    'name' => 'Isla de Socotra',
                    'synopsis' => 'Santuario natural de flora y paisajes de otro planeta',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Socotra Island',
                    'synopsis' => "Natural sanctuary of flora and landscapes from another planet",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Yemen',
                'classification_keyword' => 'Vegetation',
                'source' => 'https://es.wikipedia.org/wiki/Socotra'
            ],
            [
                'es' => [
                    'name' => 'Río Tinto',
                    'synopsis' => 'Vertiente de aguas rojizas por alta concentración de minerales',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Tinto River',
                    'synopsis' => 'Spring of red waters due to high mineral levels',
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Spain',
                'classification_keyword' => 'Water',
            ],
            [
                'es' => [
                    'name' => 'Monte Neme',
                    'synopsis' => 'Monte rico en wolframio, con lagos tóxicos de agua turquesa',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Mount Neme',
                    'synopsis' => 'Mountain rich in tungsten, with toxic lakes of turquoise water',
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Spain',
                'classification_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'Cueva de los cristales',
                    'synopsis' => 'Los cristales naturales más grandes jamás encontrados, a una profundidad de 300 metros',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Cave of the crystals',
                    'synopsis' => 'The largest natural crystals ever found, at a depth of 300 meters',
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Mexico',
                'classification_keyword' => 'Caves',
                'source' => 'https://en.wikipedia.org/wiki/Cave_of_the_Crystals'
            ],
            [
                'es' => [
                    'name' => 'Valle de la muerte',
                    'synopsis' => 'Valle desértico con una de las temperaturas más altas del mundo durante el verano',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Death Valley',
                    'synopsis' => 'Desertic valley thought to be the hottest place on earth during summer',
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'United States',
                'classification_keyword' => 'Valleys',
                'source' => 'https://en.wikipedia.org/wiki/Death_Valley_National_Park'
            ],
        ];



        $unknown_country_id = CountryTranslation::where('name', 'Unknown')->value('country_id');
        $unknown_classification_id = ClassificationTranslation::where('keyword', 'Unknown')->value('classification_id');

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
