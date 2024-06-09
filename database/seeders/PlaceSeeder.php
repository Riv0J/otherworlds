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

class PlaceSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //1. get a source to create places from
        $places_data = PlaceSeeder::getPlacesData();

        //2. get the ids for unknown country and unknown category
        $unknown_country_id = CountryTranslation::where('name', 'Unknown')->value('country_id');
        $unknown_category_id = CategoryTranslation::where('keyword', 'Unknown')->value('category_id');

        //3. create all the places in $places_data
        foreach ($places_data as $place_entry) {

            $place_data = [
                'views_count' => rand(1, 1000000),
                'favorites_count' => rand(1, 1500),
                'latitude' => $place_entry['latitude'] ?? 0,
                'longitude' => $place_entry['longitude'] ?? 0,
                'gallery_url' => $place_entry['gallery_url'] ?? null,
                'country_id' => CountryTranslation::where('name', $place_entry['country_name'])->value('country_id') ?? $unknown_country_id,
                'category_id' => CategoryTranslation::where('keyword', $place_entry['category_keyword'])->value('category_id') ?? $unknown_category_id,
                'es' => $place_entry['es'],
                'en' => $place_entry['en'],
            ];

            // generate slug for each of the place's locale
            foreach (config('translatable.locales') as $locale) {
                if(isset($place_data[$locale])){
                    $place_data[$locale]['slug'] = OHelper::sluggify($place_data[$locale]['name']);
                }
            }

            // generate public slug, main language directory is english
            $place_data['public_slug'] = OHelper::sluggify($place_data['en']['name']);

            // create the place
            $new_place = Place::create($place_data);

            // create the place's sources, if any
            $sources_data = $place_entry['sources'] ?? [];
            foreach ($sources_data as $source_data) {
                $source_data['place_id'] = $new_place->id;
                Source::create($source_data);
            }

            // create an img directory for this place in english name if it doesnt exist
            $path = public_path('places/'.$place_data['public_slug']);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        }
    }

    // TODO test saving the database as json
    public static function savePlacesSeederJSON($places_data){
        $places_path = database_path('seeders/places_seeder.json');

        // encode json
        $places_json = json_encode($places_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // save json
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
                'category_keyword' => 'Valleys'
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
                'category_keyword' => 'Oceanic',
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
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Laguna_de_Torrevieja'
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
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Pared_del_Roraima'
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
                'category_keyword' => 'Nature',
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
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Minerals_of_Naica'
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
                'category_keyword' => 'Nature',
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
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Dallol'
            ],
            [
                'es' => [
                    'name' => 'Pamukkale',
                    'synopsis' => 'Terrazas de carbonato formadas por el flujo de aguas termales',

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
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Son_Doong_Cave'
            ],
            [
                'es' => [
                    'name' => 'Cañón de Zion',
                    'synopsis' => 'Acantilados de arenisca roja y exuberante vegetación',

                ],
                'en' => [
                    'name' => 'Zion Canyon',
                    'synopsis' => "Red sandstone cliffs and lush Nature",

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
                'category_keyword' => 'Valleys',
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
                    'name' => 'Bosque de Zhangjiajie',
                    'synopsis' => 'Increíbles paisajes boscosos con pilares de roca gigantescos',

                ],
                'en' => [
                    'name' => 'Zhangjiajie forest',
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
                'category_keyword' => 'Nature',
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
                'category_keyword' => 'Nature',
            ],
            [
                'es' => [
                    'name' => 'Acantilados de Moher',
                    'synopsis' => '14Km de acantilados que llegan a alcanzar hasta 214 metros sobre el nivel del océano atlántico',

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
                'category_keyword' => 'Oceanic',
            ],
            [
                'es' => [
                    'name' => 'Monte Everest',
                    'synopsis' => 'La montaña más grande del mundo sobre el nivel del mar',

                ],
                'en' => [
                    'name' => 'Mount Everest',
                    'synopsis' => 'Earth highest mountain above sea level',

                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Monte_Everest',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Mount_Everest',
                    ],
                ],
                'country_name' => 'Nepal',
                'category_keyword' => 'Mountains',
            ],
            [
                'es' => [
                    'name' => 'Gran Agujero Azul',
                    'synopsis' => 'Agujero marino con una profundidad de 120 metros en las aguas de Belize',
                ],
                'en' => [
                    'name' => 'Great Blue Hole',
                    'synopsis' => 'A giant, 120 meters deep marine sinkhole off the coast of Belize',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Gran_Agujero_Azul',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Great_Blue_Hole',
                    ],
                ],
                'country_name' => 'Belize',
                'category_keyword' => 'Oceanic',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Great_Blue_Hole_(Belize)'
            ],
            [
                'es' => [
                    'name' => 'Gran Barrera de Coral',
                    'synopsis' => 'El mayor arrecife de coral del mundo',
                ],
                'en' => [
                    'name' => 'Great Barrier Reef',
                    'synopsis' => 'World\'s largest coral reef system',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Gran_Barrera_de_Coral',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Great_Barrier_Reef',
                    ],
                ],
                'country_name' => 'Australia',
                'category_keyword' => 'Oceanic',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Agincourt_Reef'
            ],
            [
                'es' => [
                    'name' => 'Fiordo de Geiranger',
                    'synopsis' => 'Fiordo de 15km de longitud, rama del gran fiordo Storfjorden',
                ],
                'en' => [
                    'name' => 'Geirangerfjord',
                    'synopsis' => 'A 15km-long branch fjord of the great Storfjorden in Norway',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Fiordo_de_Geiranger',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Geirangerfjord',
                    ],
                ],
                'country_name' => 'Norway',
                'category_keyword' => 'Water',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Geirangerfjorden'
            ],
            [
                'es' => [
                    'name' => 'Monte Etna',
                    'synopsis' => 'El volcán más alto de Europa, y uno de los más activos del mundo',
                ],
                'en' => [
                    'name' => 'Mount Etna',
                    'synopsis' => 'The highest active volcano in Europe, and one of the most active in the world',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Etna',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Mount_Etna',
                    ],
                ],
                'country_name' => 'Italy',
                'category_keyword' => 'Volcanic',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Mount_Etna'
            ],
            [
                'es' => [
                    'name' => 'Mauna Loa',
                    'synopsis' => 'El volcan activo más grande de la tierra, debido a su amplio volumen',
                ],
                'en' => [
                    'name' => 'Mauna Loa',
                    'synopsis' => 'Biggest active volcano on earth, due to it\'s large volume',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Mauna_Loa',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Mauna_Loa',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Volcanic',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Remote_views_of_Mauna_Loa'
            ],
            [
                'es' => [
                    'name' => 'Torres del Paine',
                    'synopsis' => 'Vistas increíbles de la cordillera Paine y sus glaciares',
                ],
                'en' => [
                    'name' => 'Towers of Paine',
                    'synopsis' => 'Three distinct granite peaks in the Paine mountain range',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_nacional_Torres_del_Paine',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Torres_del_Paine_National_Park',
                    ],
                ],
                'country_name' => 'Chile',
                'category_keyword' => 'Mountains',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Cordillera_del_Paine'
            ],
            [
                'es' => [
                    'name' => 'Los Glaciares',
                    'synopsis' => 'Una de las capas de hielo mayores, aparte de los polos',
                ],
                'en' => [
                    'name' => 'Los Glaciares',
                    'synopsis' => 'One of the largest ice caps outside of earth\'s poles',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_nacional_Los_Glaciares',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Los_Glaciares_National_Park',
                    ],
                ],
                'country_name' => 'Argentina',
                'category_keyword' => 'Glaciers',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Los_Glaciares_National_Park'
            ],
            [
                'es' => [
                    'name' => 'Cataratas Victoria',
                    'synopsis' => 'La caída en picada de agua más grande de la tierra',
                ],
                'en' => [
                    'name' => 'Victoria Falls',
                    'synopsis' => 'The world\'s largest sheet of falling water',
                ],
                'sources' => [
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Cataratas_Victoria',
                    ],
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Victoria_Falls',
                    ],
                ],
                'country_name' => 'Zimbabwe',
                'category_keyword' => 'Water',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Aerial_photographs_of_Victoria_Falls'
            ],
            [
                'es' => [
                    'name' => 'Rocas de Hopewell',
                    'synopsis' => 'Formaciones de roca apiladas causadas por erosión de las mareas',
                ],
                'en' => [
                    'name' => 'Hopewell Rocks',
                    'synopsis' => 'Sea stack rock formations caused by tidal erosion',
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Hopewell_Rocks',
                    ],
                ],
                'country_name' => 'Canada',
                'category_keyword' => 'Oceanic',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Hopewell_Rocks'
            ],
            [
                'es' => [
                    'name' => 'Bahía de los glaciares',
                    'synopsis' => 'Uno de los mejores paisajes del mundo para observar la creación de icebergs',
                ],
                'en' => [
                    'name' => 'Glacier Bay',
                    'synopsis' => 'One of the best landscapes in the world to observe the creation of icebergs',
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Glacier_Bay_National_Park_and_Preserve',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_nacional_y_reserva_de_la_Bah%C3%ADa_de_los_Glaciares',
                    ],
                ],
                'country_name' => 'United States',
                'category_keyword' => 'Glaciers',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Glaciers_of_Glacier_Bay_National_Park'
            ],
            [
                'es' => [
                    'name' => 'Montañas Rwenzori',
                    'synopsis' => 'Fauna variada, aves endémicas y flora inusual',
                ],
                'en' => [
                    'name' => 'Rwenzori Mountains',
                    'synopsis' => 'Variety of fauna, endemic birds and unusual flora',
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Rwenzori_Mountains_National_Park',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Monta%C3%B1as_Rwenzori',
                    ],
                ],
                'country_name' => 'Uganda',
                'category_keyword' => 'Nature',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Rwenzori-Virunga_montane_moorlands'
            ],
            [
                'es' => [
                    'name' => 'Montañas Bungle Bungle',
                    'synopsis' => 'Formaciones de arenisca con forma de colmenas, en el Parque Nacional Purnululu',
                ],
                'en' => [
                    'name' => 'Bungle Bungle Range',
                    'synopsis' => 'Beehive-like sandstone rock formations, in the Purnululu National Park',
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Purnululu_National_Park',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Parque_nacional_Purnululu',
                    ],
                ],
                'country_name' => 'Australia',
                'category_keyword' => 'Mountains',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Bungle_Bungle_Range'
            ],
            [
                'es' => [
                    'name' => 'Cordillera del Cáucaso',
                    'synopsis' => 'Cordillera transcontinental que tiene el pico del Monte Elbrus, la montaña más alta de Europa',
                ],
                'en' => [
                    'name' => 'Caucasus Mountains',
                    'synopsis' => 'Transcontinental montain range, contains the highest peak in Europe, Mount Elbrus',
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Caucasus_Mountains',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Cordillera_del_C%C3%A1ucaso',
                    ],
                ],
                'country_name' => 'Georgia',
                'category_keyword' => 'Mountains',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Caucasus'
            ],
            [
                'es' => [
                    'name' => 'Isla de Wrangel',
                    'synopsis' => 'Importante ecosistema y biodiversidad de la fauna ártica, especialmente osos polares y aves migratorias',
                ],
                'en' => [
                    'name' => 'Wrangel Island',
                    'synopsis' => 'Important ecosystem and biodiversity of arctic wildlife, especially polar bears and migratory birds',
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Wrangel_Island',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Isla_de_Wrangel',
                    ],
                ],
                'country_name' => 'Russia',
                'category_keyword' => 'Nature',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Coasts_of_Wrangel_Island'
            ],
            [
                'es' => [
                    'name' => 'Desierto de Lut',
                    'synopsis' => 'Conocido como "Dasht-e Lut", que significa Desierto del Vacío en persa, es uno de los lugares más secos y calurosos del mundo',
                ],
                'en' => [
                    'name' => 'Lut Desert',
                    'synopsis' => "Known as \"Dasht-e Lut\", Emptiness Plain in Persian,  one of the world's driest and hottest places",
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Dasht-e_Lut',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Desierto_de_Lut',
                    ],
                ],
                'country_name' => 'Iran',
                'category_keyword' => 'Valleys',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Dasht-e_Lut'
            ],
            [
                'es' => [
                    'name' => 'Manglar de Sundarbans',
                    'synopsis' => 'El bosque de manglar más grande de la Tierra, formado en el delta del río Ganges',
                ],
                'en' => [
                    'name' => 'The Sundarbans',
                    'synopsis' => "The largest mangrove forest in the world, formed in the delta of the Ganges river",
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Sundarbans',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Sundarbans',
                    ],
                ],
                'country_name' => 'Bangladesh',
                'category_keyword' => 'Nature',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Sundarbans_West_Wildlife_Sanctuary'
            ],
            [
                'es' => [
                    'name' => 'Delta del Okavango',
                    'synopsis' => 'Asombroso ejemplo de biodiversidad africana en la desembocadura del río Okavango, especialmente durante las temporadas de lluvias',
                ],
                'en' => [
                    'name' => 'Okavango Delta',
                    'synopsis' => "Amazing example of african biodiversity at the Okavango river delta, especially during rainy seasons",
                ],
                'sources' => [
                    [
                        'locale' => 'en',
                        'url' => 'https://en.wikipedia.org/wiki/Okavango_Delta',
                    ],
                    [
                        'locale' => 'es',
                        'url' => 'https://es.wikipedia.org/wiki/Delta_del_Okavango',
                    ],
                ],
                'country_name' => 'Botswana',
                'category_keyword' => 'Nature',
                'gallery_url' => 'https://commons.wikimedia.org/wiki/Category:Mammals_of_the_Okavango_Delta'
            ],

        ];


    }
}

//potential:
