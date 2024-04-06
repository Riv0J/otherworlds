<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

use App\Models\CountryTranslation;
use App\Models\CategoryTranslation;
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

        // Decodificar el contenido JSON en un array asociativo
        $places_data = PlaceSeeder::getPlacesData();

        //2. get the ids for unknown country and unknown category
        $unknown_country_id = CountryTranslation::where('name', 'Unknown')->value('country_id');
        $unknown_category_id = CategoryTranslation::where('keyword', 'Unknown')->value('category_id');

        //3. create all the places in $places_data
        foreach ($places_data as $place_entry) {

            $place_data = [
                'views_count' => rand(100, 1000000),
                'favorites_count' => rand(100, 100000),
                'country_id' => CountryTranslation::where('name', $place_entry['country_name'])->value('country_id') ?? $unknown_country_id,
                'category_id' => CategoryTranslation::where('keyword', $place_entry['category_keyword'])->value('category_id') ?? $unknown_category_id,
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
    public static function savePlacesSeederJSON($places_data){
        // Ruta del JSON
        $places_path = database_path('seeders/places_seeder.json');

        // Codificar a JSON
        $places_json = json_encode($places_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Guardar el JSON en la ruta especificada
        file_put_contents($places_path, $places_json);
    }

    public static function getPlacesData(){
        // places data
        return[
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
                'category_keyword' => 'Valleys',
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
                'category_keyword' => 'Mountains',
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
                'category_keyword' => 'Valleys',
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
                'category_keyword' => 'Valleys',
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
                'category_keyword' => 'Coastal',
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
                'category_keyword' => 'Volcanic',
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
                'category_keyword' => 'Valleys',
                'source' => 'https://en.wikipedia.org/wiki/Salar_de_Uyuni',
            ],
            [
                'es' => [
                    'name' => 'Salinas de Torrevieja',
                    'synopsis' => 'Lago de agua salada rosa en España',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Torrevieja Salt Lake',
                    'synopsis' => "Pink water salt lake in Spain",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Spain',
                'category_keyword' => 'Water',
                'source' => 'https://es.wikipedia.org/wiki/Parque_natural_de_las_Lagunas_de_La_Mata_y_Torrevieja',
            ],
            [
                'es' => [
                    'name' => 'Lago Hillier',
                    'synopsis' => 'Lago de agua salada rosa en Australia',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Lake Hillier',
                    'synopsis' => "Pink water salt lake in Australia",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Australia',
                'category_keyword' => 'Water',
                'source' => 'https://en.wikipedia.org/wiki/Lake_Hillier',
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
                'category_keyword' => 'Mountains',
                'source' => 'https://en.wikipedia.org/wiki/Mount_Roraima',
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
                'category_keyword' => 'Caves',
                'source' => 'https://en.wikipedia.org/wiki/Fingal%27s_Cave',
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
                'category_keyword' => 'Water',
                'source' => 'https://en.wikipedia.org/wiki/Niagara_Falls',
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
                'category_keyword' => 'Volcanic',
                'source' => 'https://en.wikipedia.org/wiki/Ometepe',
            ],
            [
                'es' => [
                    'name' => 'Montañas Zhangye Danxia',
                    'synopsis' => 'Formaciones geológicas de arenisca multicolor',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Zhangye Danxia Mountains',
                    'synopsis' => "Colorful sandstone rock formations",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'China',
                'category_keyword' => 'Mountains',
                'source' => 'https://en.wikipedia.org/wiki/Zhangye_National_Geopark',
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
                'category_keyword' => 'Valleys',
                'source' => 'https://es.wikipedia.org/wiki/Valle_del_Colca',
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
                'category_keyword' => 'Vegetation',
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
                'category_keyword' => 'Water',
                'source' => 'https://en.wikipedia.org/wiki/Rio_Tinto_(river)',
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
                'category_keyword' => 'Mountains',
                'source' => 'https://es.wikipedia.org/wiki/Monte_Neme',
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
                'category_keyword' => 'Caves',
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
                'category_keyword' => 'Valleys',
                'source' => 'https://en.wikipedia.org/wiki/Death_Valley_National_Park'
            ],
            [
                'es' => [
                    'name' => 'Cuevas Luminosas de Waitomo',
                    'synopsis' => 'Cueva conocida por sus especies de gusanos luminosos',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Waitomo Glowworm Caves',
                    'synopsis' => "Cave known for its glowworm species",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'New Zealand',
                'category_keyword' => 'Caves',
                'source' => 'https://en.wikipedia.org/wiki/Waitomo_Glowworm_Caves'
            ],
            [
                'es' => [
                    'name' => 'Depresión de Danakil',
                    'synopsis' => 'Depresión geológica que da lugar a un paisaje volcánico de aspecto extraterrestre',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Danakil Depression',
                    'synopsis' => "Geological depression resulting in an otherworldly volcanic landscape",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Ethiopia',
                'category_keyword' => 'Volcanic',
                'source' => 'https://en.wikipedia.org/wiki/Danakil_Depression'
            ],
            [
                'es' => [
                    'name' => 'Pamukkale',
                    'synopsis' => 'Terrazas de minerales de carbonato formadas por el flujo de aguas termales',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Pamukkale',
                    'synopsis' => "Terraces of carbonate minerals created by the flow of thermal spring waters",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Turkey',
                'category_keyword' => 'Volcanic',
                'source' => 'https://en.wikipedia.org/wiki/Pamukkale'
            ],
            [
                'es' => [
                    'name' => 'Cráter Ijen',
                    'synopsis' => 'Cráter volcánico lleno de agua ácida, con vistas de fuego azul por las noches',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Ijen Crater',
                    'synopsis' => "Acidic volcanic lake, with views of blue fire at night",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Indonesia',
                'category_keyword' => 'Volcanic',
                'source' => 'https://en.wikipedia.org/wiki/Ijen'
            ],
            [
                'es' => [
                    'name' => 'Cueva de Son Doong',
                    'synopsis' => 'La cueva natural más grande del mundo',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Son Doon Cave',
                    'synopsis' => "World's largest natural cave",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'Vietnam',
                'category_keyword' => 'Caves',
                'source' => 'https://en.wikipedia.org/wiki/Hang_S%C6%A1n_%C4%90o%C3%B2ng'
            ],
            [
                'es' => [
                    'name' => 'Cañón de Zion',
                    'synopsis' => 'Acantilados de arenisca roja y exuberante vegetación',
                    'description' => 'Descripción en español',
                ],
                'en' => [
                    'name' => 'Zion Canyon',
                    'synopsis' => "Red sandstone cliffs and lush vegetation",
                    'description' => 'Descripción en ingles',
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Mountains',
                'source' => 'https://es.wikipedia.org/wiki/Parque_nacional_Zion'
            ],
        ];
    }
}
