<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'es' => [
                    'keyword' => 'Desconocido',
                    'name' => 'Desconocido',
                    'description' => 'Desconocido',
                ],
                'en' => [
                    'keyword' => 'Unknown',
                    'name' => 'Unknown',
                    'description' => 'Unknown',
                ],
                'img_name' => 'question'
            ],
            [
                'es' => [
                    'keyword' => 'Agua',
                    'name' => 'Cuerpos de agua',
                    'description' => 'Cuerpos de agua naturales como océanos, mares, lagos, ríos, etc',
                ],
                'en' => [
                    'keyword' => 'Water',
                    'name' => 'Bodies of water',
                    'description' => 'Natural bodies of water such as oceans, seas, lakes, rivers, etc',
                ],
                'img_name' => 'droplet'
            ],
            [
                'es' => [
                    'keyword' => 'Montañas',
                    'name' => 'Elevaciones de terreno',
                    'description' => 'Elevaciones naturales del terreno como montañas, colinas, sierras, etc',
                ],
                'en' => [
                    'keyword' => 'Mountains',
                    'name' => 'Land elevations',
                    'description' => 'Natural land elevations such as mountains, hills, ranges, etc',
                ],
                'img_name' => 'mountain'
            ],
            [
                'es' => [
                    'keyword' => 'Valles',
                    'name' => 'Depresiones de terreno',
                    'description' => 'Áreas de terreno más bajas que sus alrededores, como valles, llanuras, cañones, etc',
                ],
                'en' => [
                    'keyword' => 'Valleys',
                    'name' => 'Land depressions',
                    'description' => 'Lower areas of land compared to their surroundings, such as valleys, plains, canyons, etc',
                ],
                'img_name' => 'sun'
            ],
            [
                'es' => [
                    'keyword' => 'Oceánicos',
                    'name' => 'Accidentes costeros y océanicos',
                    'description' => 'Características geográficas situadas en la costa y en océanos, como bahías, cabos, ensenadas, etc',
                ],
                'en' => [
                    'keyword' => 'Oceanic',
                    'name' => 'Oceanic and coastal features',
                    'description' => 'Geographical features located along the coast and oceans, such as bays, capes, inlets, etc',
                ],
                'img_name' => 'umbrella-beach'
            ],
            [
                'es' => [
                    'keyword' => 'Glaciares',
                    'name' => 'Accidentes glaciales',
                    'description' => 'Características geográficas que involucran glaciares y paisajes nevados',
                ],
                'en' => [
                    'keyword' => 'Glaciers',
                    'name' => 'Glacial features',
                    'description' => 'Geographical features that involve glaciers and snowy landscapes',
                ],
                'img_name' => 'dice-d6'
            ],
            [
                'es' => [
                    'keyword' => 'Volcánicos',
                    'name' => 'Formaciones volcánicas',
                    'description' => 'Características geográficas formadas por procesos volcánicos, como volcanes, cráteres, calderas, etc',
                ],
                'en' => [
                    'keyword' => 'Volcanic',
                    'name' => 'Volcanic formations',
                    'description' => 'Geographical features formed by volcanic processes, such as volcanoes, craters, calderas, etc',
                ],
                'img_name' => 'volcano'
            ],
            [
                'es' => [
                    'keyword' => 'Cuevas',
                    'name' => 'Formaciones karsticas',
                    'description' => 'Características geológicas formadas por la disolución de rocas solubles, como cuevas, dolinas, estalactitas, etc',
                ],
                'en' => [
                    'keyword' => 'Caves',
                    'name' => 'Karstic kormations',
                    'description' => 'Geological features formed by the dissolution of soluble rocks, such as caves, sinkholes, stalactites, etc',
                ],
                'img_name' => 'icicles'
            ],
            [
                'es' => [
                    'keyword' => 'Naturaleza',
                    'name' => 'Santuario de flora y fauna',
                    'description' => 'Tipos únicos de vegetación y especies animales',
                ],
                'en' => [
                    'keyword' => 'Nature',
                    'name' => 'Sanctuary of flora and fauna',
                    'description' => 'Unique types of vegetation and animal especies',
                ],
                'img_name' => 'seedling'
            ],
            [
                'es' => [
                    'keyword' => 'Otros',
                    'name' => 'Sin clasificar',
                    'description' => 'Lugares que coinciden con múltiples categorías o que no han sido clasificados todavia',
                ],
                'en' => [
                    'keyword' => 'Other',
                    'name' => 'Unclassified Category',
                    'description' => 'Places that match the description of multiple categories or that have not been classified yet',
                ],
                'img_name' => 'circle-plus'
            ],


        ];

        // create the categories using translations
        foreach ($categories as $cat_entry) {

            $cat_data = [
                'es' => $cat_entry['es'],
                'en' => $cat_entry['en'],
                'img_name' => $cat_entry['img_name']
            ];

            $new_cat = Category::create($cat_data);
        }
    }
}
