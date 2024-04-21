<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;

use App\Models\CountryTranslation;
use App\Models\CategoryTranslation;
use App\Models\Place;
use App\Models\Source;
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
                'views_count' => rand(1, 1000000),
                'favorites_count' => rand(1, 1500),
                'country_id' => CountryTranslation::where('name', $place_entry['country_name'])->value('country_id') ?? $unknown_country_id,
                'category_id' => CategoryTranslation::where('keyword', $place_entry['category_keyword'])->value('category_id') ?? $unknown_category_id,
                'es' => $place_entry['es'],
                'en' => $place_entry['en'],
            ];
            // create the place
            $new_place = Place::create($place_data);

            // create the place's sources
            $sources_data = $place_entry['sources'] ?? [];
            foreach ($sources_data as $source_data) {
                $source_data['place_id'] = $new_place->id;
                Source::create($source_data);
            }

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
        return [
            [
                'es' => [
                    'name' => 'Cañón del Antílope',
                    'synopsis' => 'Cañón en el suroeste de Estados Unidos, en tierras navajos al este de Lechee, Arizona',
                ],
                'en' => [
                    'name' => 'Antelope Canyon',
                    'synopsis' => 'A slot canyon in the American Southwest, on Navajo land east of Lechee, Arizona',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Ca%C3%B1%C3%B3n_del_Ant%C3%ADlope',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Antelope_Canyon',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Valleys',
            ],
            [
                'es' => [
                    'name' => 'Punto Bryce',
                    'synopsis' => 'Increible vista de formaciones de roca en forma de torres "hoodos"',
                ],
                'en' => [
                    'name' => 'Bryce Point',
                    'synopsis' => 'Incredible vistas of "hoodoo" rock formations',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_nacional_del_Ca%C3%B1%C3%B3n_Bryce',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Bryce_Canyon_National_Park',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'Valle de los monumentos',
                    'synopsis' => 'Conjunto de formaciones rocosas "butte" en el valle del Colorado',
                ],
                'en' => [
                    'name' => 'Monument Valley',
                    'synopsis' => 'Cluster of sandstone "buttes" rock formations in the Colorado plateau',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Valle_de_los_Monumentos',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Monument_Valley',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Valleys',
            ],
            [
                'es' => [
                    'name' => 'Gran Cañón del Colorado',
                    'synopsis' => 'Vistosa y escarpada garganta de roca excavada por el río Colorado a lo largo de millones de años',
                ],
                'en' => [
                    'name' => 'Grand Canyon',
                    'synopsis' => 'A steep-sided canyon carved by the Colorado River over millions of years',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Gran_Ca%C3%B1%C3%B3n',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Grand_Canyon',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Valleys',
            ],
            [
                'es' => [
                    'name' => 'Acantilados de Nullarbor',
                    'synopsis' => 'Linea costera de 210Km de acantilados rocosos de 60 metros de altura',

                ],
                'en' => [
                    'name' => 'Nullarbor Cliffs',
                    'synopsis' => '210 km of coastline featuring rocky cliffs towering 60 meters in height',
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Bunda_Cliffs',
                    ],
                ],
                'country_name' => 'Australia',
                'category_keyword' => 'Coastal',
            ],
            [
                'es' => [
                    'name' => 'Gran Manantial Prismático',
                    'synopsis' => 'El manantial termal más grande de Estados Unidos y el tercero más grande del mundo.',

                ],
                'en' => [
                    'name' => 'Grand Prismatic Spring',
                    'synopsis' => 'The largest hot spring in the United States, and the third largest in the world',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Gran_Fuente_Prism%C3%A1tica',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Grand_Prismatic_Spring',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Volcanic',
            ],
            [
                'es' => [
                    'name' => 'Salar de Uyuni',
                    'synopsis' => 'El mayor desierto de sal continuo y alto del mundo',

                ],
                'en' => [
                    'name' => 'Uyuni Salt Flat',
                    'synopsis' => "The world's largest salt flat playa",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Salar_de_Uyuni',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Salar_de_Uyuni',
                    ],
                ],
                'country_name' => 'Bolivia',
                'category_keyword' => 'Valleys',
            ],
            [
                'es' => [
                    'name' => 'Salinas de Torrevieja',
                    'synopsis' => 'Lago de agua salada rosa en España',

                ],
                'en' => [
                    'name' => 'Torrevieja Salt Lake',
                    'synopsis' => "Pink water salt lake in Spain",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_natural_de_las_Lagunas_de_La_Mata_y_Torrevieja',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://www.sunshineseeker.com/destinations/spain-pink-lake-laguna-salada-de-torrevieja/',
                    ],
                ],
                'country_name' => 'Spain',
                'category_keyword' => 'Water',
            ],
            [
                'es' => [
                    'name' => 'Lago Hillier',
                    'synopsis' => 'Lago de agua salada rosa en Australia',

                ],
                'en' => [
                    'name' => 'Lake Hillier',
                    'synopsis' => "Pink water salt lake in Australia",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Lago_Hillier',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Lake_Hillier',
                    ],
                ],
                'country_name' => 'Australia',
                'category_keyword' => 'Water',
            ],
            [
                'es' => [
                    'name' => 'Monte Roraima',
                    'synopsis' => 'Alta meseta de roca, con millones de años de antigüedad',

                ],
                'en' => [
                    'name' => 'Mount Roraima',
                    'synopsis' => "Tall, millions of years old rock plateau",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Roraima_(tepuy)',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Mount_Roraima',
                    ],
                ],
                'country_name' => 'Venezuela',
                'category_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'Gruta de Fingal',
                    'synopsis' => 'Cueva formada por columnas de basalto hexagonales',

                ],
                'en' => [
                    'name' => "Fingal's Cave",
                    'synopsis' => "Cave formed from Hexagonal basalt columns",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Gruta_de_Fingal',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Fingal%27s_Cave',
                    ],
                ],
                'country_name' => 'Scotland',
                'category_keyword' => 'Caves',
            ],
            [
                'es' => [
                    'name' => 'Cataratas del Niágara',
                    'synopsis' => 'Las tres hermosas cascadas en el rio Niágara',

                ],
                'en' => [
                    'name' => 'Niagara Falls',
                    'synopsis' => "The three beautiful waterfalls at the southern end of Niagara Gorge",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Cataratas_del_Ni%C3%A1gara',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Niagara_Falls',
                    ],
                ],
                'country_name' => 'Canada',
                'category_keyword' => 'Water',
            ],
            [
                'es' => [
                    'name' => 'Lago Cocibolca & Ometepe',
                    'synopsis' => 'El lago más grande de america central con su isla volcánica',

                ],
                'en' => [
                    'name' => 'Lake Cocibolca & Ometepe',
                    'synopsis' => "Central America's largest lake and it's volcanic island",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Ometepe',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Ometepe',
                    ],
                ],
                'country_name' => 'Nicaragua',
                'category_keyword' => 'Volcanic',
            ],
            [
                'es' => [
                    'name' => 'Montañas Zhangye Danxia',
                    'synopsis' => 'Formaciones geológicas de arenisca multicolor',

                ],
                'en' => [
                    'name' => 'Zhangye Danxia Mountains',
                    'synopsis' => "Colorful sandstone rock formations",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_geol%C3%B3gico_nacional_Zhangye_Danxia',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Zhangye_National_Geopark',
                    ],
                ],
                'country_name' => 'China',
                'category_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'Cañón del Colca',
                    'synopsis' => 'Montañas con profundidad de 3250m a lo largo del río Colca',

                ],
                'en' => [
                    'name' => 'Colca Canyon',
                    'synopsis' => "Mountains with a depth of 3250 meters along the Colca River",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Valle_del_Colca',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Colca_Canyon',
                    ],
                ],
                'country_name' => 'Peru',
                'category_keyword' => 'Valleys',
            ],
            [
                'es' => [
                    'name' => 'Isla de Socotra',
                    'synopsis' => 'Santuario natural de flora y paisajes de otro planeta',

                ],
                'en' => [
                    'name' => 'Socotra Island',
                    'synopsis' => "Natural sanctuary of flora and landscapes from another planet",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Socotra',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Socotra',
                    ],
                ],
                'country_name' => 'Yemen',
                'category_keyword' => 'Vegetation',
            ],
            [
                'es' => [
                    'name' => 'Río Tinto',
                    'synopsis' => 'Vertiente de aguas rojizas por alta concentración de minerales',

                ],
                'en' => [
                    'name' => 'Tinto River',
                    'synopsis' => 'Spring of red waters due to high mineral levels',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/R%C3%ADo_Tinto',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Rio_Tinto_(river)',
                    ],
                ],
                'country_name' => 'Spain',
                'category_keyword' => 'Water',
            ],
            [
                'es' => [
                    'name' => 'Monte Neme',
                    'synopsis' => 'Monte rico en wolframio, con lagos tóxicos de agua turquesa',

                ],
                'en' => [
                    'name' => 'Mount Neme',
                    'synopsis' => 'Mountain rich in tungsten, with toxic lakes of turquoise water',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Monte_Neme',
                    ],
                ],
                'country_name' => 'Spain',
                'category_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'Cueva de los cristales',
                    'synopsis' => 'Los cristales naturales más grandes jamás encontrados, a una profundidad de 300 metros',

                ],
                'en' => [
                    'name' => 'Cave of the crystals',
                    'synopsis' => 'The largest natural crystals ever found, at a depth of 300 meters',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Cueva_de_los_cristales_(Naica)',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Cave_of_the_Crystals',
                    ],
                ],
                'country_name' => 'Mexico',
                'category_keyword' => 'Caves',
            ],
            [
                'es' => [
                    'name' => 'Valle de la muerte',
                    'synopsis' => 'Valle desértico con una de las temperaturas más altas del mundo durante el verano',

                ],
                'en' => [
                    'name' => 'Death Valley',
                    'synopsis' => 'Desertic valley thought to be the hottest place on earth during summer',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Valle_de_la_Muerte',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Death_Valley_National_Park',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Valleys',
            ],
            [
                'es' => [
                    'name' => 'Cuevas Luminosas de Waitomo',
                    'synopsis' => 'Cueva conocida por sus especies de gusanos luminosos',

                ],
                'en' => [
                    'name' => 'Waitomo Glowworm Caves',
                    'synopsis' => "Cave known for its glowworm species",

                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Waitomo_Glowworm_Caves',
                    ],
                ],
                'country_name' => 'New Zealand',
                'category_keyword' => 'Caves',
            ],
            [
                'es' => [
                    'name' => 'Depresión de Danakil',
                    'synopsis' => 'Depresión geológica que da lugar a un paisaje volcánico de aspecto extraterrestre',

                ],
                'en' => [
                    'name' => 'Danakil Depression',
                    'synopsis' => "Geological depression resulting in an otherworldly volcanic landscape",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Depresi%C3%B3n_de_Danakil',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Danakil_Depression',
                    ],
                ],
                'country_name' => 'Ethiopia',
                'category_keyword' => 'Volcanic',
            ],
            [
                'es' => [
                    'name' => 'Pamukkale',
                    'synopsis' => 'Terrazas de minerales de carbonato formadas por el flujo de aguas termales',

                ],
                'en' => [
                    'name' => 'Pamukkale',
                    'synopsis' => "Terraces of carbonate minerals created by the flow of thermal spring waters",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Pamukkale',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Pamukkale',
                    ],
                ],
                'country_name' => 'Turkey',
                'category_keyword' => 'Volcanic',
            ],
            [
                'es' => [
                    'name' => 'Cráter Ijen',
                    'synopsis' => 'Cráter volcánico lleno de agua ácida, con vistas de fuego azul por las noches',

                ],
                'en' => [
                    'name' => 'Ijen Crater',
                    'synopsis' => "Acidic volcanic lake, with views of blue fire at night",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Ijen',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Ijen',
                    ],
                ],
                'country_name' => 'Indonesia',
                'category_keyword' => 'Volcanic',
            ],
            [
                'es' => [
                    'name' => 'Cueva de Son Doong',
                    'synopsis' => 'La cueva natural más grande del mundo',

                ],
                'en' => [
                    'name' => 'Son Doon Cave',
                    'synopsis' => "World's largest natural cave",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Gruta_de_S%C6%A1n_%C4%90o%C3%B2ng',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Hang_S%C6%A1n_%C4%90o%C3%B2ng',
                    ],
                ],
                'country_name' => 'Vietnam',
                'category_keyword' => 'Caves',
            ],
            [
                'es' => [
                    'name' => 'Cañón de Zion',
                    'synopsis' => 'Acantilados de arenisca roja y exuberante vegetación',

                ],
                'en' => [
                    'name' => 'Zion Canyon',
                    'synopsis' => "Red sandstone cliffs and lush vegetation",

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_nacional_Zion',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Zion_National_Park',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'La Torre del Diablo',
                    'synopsis' => 'Formación de roca ígnea de 264 metros de altura',

                ],
                'en' => [
                    'name' => 'Devils Tower',
                    'synopsis' => 'A 264 meters tall igneous rock formation',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Monumento_nacional_de_la_Torre_del_Diablo',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Devils_Tower',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Volcanic',
            ],
            [
                'es' => [
                    'name' => 'Parque forestal de Zhangjiajie',
                    'synopsis' => 'Increibles paisajes de bosque con pilares rocoss gigantescoss',

                ],
                'en' => [
                    'name' => 'Zhangjiajie forest park',
                    'synopsis' => 'Incredible forest vistas full of pillar-like rock formations',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_forestal_nacional_de_Zhangjiajie',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Zhangjiajie_National_Forest_Park',
                    ],
                ],
                'country_name' => 'China',
                'category_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'Parque Nacional de las Secuoyas',
                    'synopsis' => 'Hogar de árboles de secuoya gigantes, incluyendo el árbol más grande del mundo',

                ],
                'en' => [
                    'name' => 'Sequoia National Park',
                    'synopsis' => 'Home of giant sequoia trees, including the largest tree in the world',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_nacional_de_las_Secuoyas',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Sequoia_National_Park',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Vegetation',
            ],
            [
                'es' => [
                    'name' => 'Avenida de los Baobabs',
                    'synopsis' => 'Arboleda de Baobabs, árboles majestuosos endémicos de Madagascar',

                ],
                'en' => [
                    'name' => 'Avenue of the Baobabs',
                    'synopsis' => 'Grove of majestic Baobabs, endemic to Madagascar',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Avenida_de_los_Baobabs',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Avenue_of_the_Baobabs',
                    ],
                ],
                'country_name' => 'Madagascar',
                'category_keyword' => 'Vegetation',
            ],
            [
                'es' => [
                    'name' => 'Acantilados de Moher',
                    'synopsis' => '14Km de acantilados que llegan a alcanzar hasta 214 metros sobre el nivel del oceano atlántico',

                ],
                'en' => [
                    'name' => 'Cliffs of Moher',
                    'synopsis' => '14Km long sea cliffs towering up to 214 meters above the atlantic ocean',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Acantilados_de_Moher',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Cliffs_of_Moher',
                    ],
                ],
                'country_name' => 'Ireland',
                'category_keyword' => 'Coastal',
            ],

        ];
    }
}
