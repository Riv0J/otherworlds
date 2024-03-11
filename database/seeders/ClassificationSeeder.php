<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Classification;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classifications = [
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
            ],
            [
                'es' => [
                    'keyword' => 'Agua',
                    'name' => 'Cuerpos de Agua',
                    'description' => 'Cuerpos de agua naturales como océanos, mares, lagos, ríos, etc.',
                ],
                'en' => [
                    'keyword' => 'Water',
                    'name' => 'Bodies of Water',
                    'description' => 'Natural bodies of water such as oceans, seas, lakes, rivers, etc.',
                ],
            ],
            [
                'es' => [
                    'keyword' => 'Montañas',
                    'name' => 'Elevaciones de Terreno',
                    'description' => 'Elevaciones naturales del terreno como montañas, colinas, sierras, etc.',
                ],
                'en' => [
                    'keyword' => 'Mountains',
                    'name' => 'Land Elevations',
                    'description' => 'Natural land elevations such as mountains, hills, ranges, etc.',
                ],
            ],
            [
                'es' => [
                    'keyword' => 'Valles',
                    'name' => 'Depresiones de Terreno',
                    'description' => 'Áreas de terreno más bajas que sus alrededores, como valles, llanuras, cañones, etc.',
                ],
                'en' => [
                    'keyword' => 'Valleys',
                    'name' => 'Land Depressions',
                    'description' => 'Lower areas of land compared to their surroundings, such as valleys, plains, canyons, etc.',
                ],
            ],
            [
                'es' => [
                    'keyword' => 'Costeros',
                    'name' => 'Accidentes Costeros',
                    'description' => 'Características geográficas situadas en la costa, como bahías, cabos, ensenadas, etc.',
                ],
                'en' => [
                    'keyword' => 'Coastal',
                    'name' => 'Coastal Features',
                    'description' => 'Geographical features located along the coast, such as bays, capes, inlets, etc.',
                ],
            ],
            [
                'es' => [
                    'keyword' => 'Glaciares',
                    'name' => 'Accidentes Glaciares',
                    'description' => 'Características geográficas formadas por la acción de los glaciares, como glaciares, morrenas, fiordos, etc.',
                ],
                'en' => [
                    'keyword' => 'Glaciers',
                    'name' => 'Glacial Features',
                    'description' => 'Geographical features formed by the action of glaciers, such as glaciers, moraines, fjords, etc.',
                ],
            ],
            [
                'es' => [
                    'keyword' => 'Volcánicos',
                    'name' => 'Formaciones Volcánicas',
                    'description' => 'Características geográficas formadas por procesos volcánicos, como volcanes, cráteres, calderas, etc.',
                ],
                'en' => [
                    'keyword' => 'Volcanic',
                    'name' => 'Volcanic Formations',
                    'description' => 'Geographical features formed by volcanic processes, such as volcanoes, craters, calderas, etc.',
                ],
            ],
            [
                'es' => [
                    'keyword' => 'Cuevas',
                    'name' => 'Formaciones Karsticas',
                    'description' => 'Características geológicas formadas por la disolución de rocas solubles, como cuevas, dolinas, estalactitas, etc.',
                ],
                'en' => [
                    'keyword' => 'Caves',
                    'name' => 'Karstic Formations',
                    'description' => 'Geological features formed by the dissolution of soluble rocks, such as caves, sinkholes, stalactites, etc.',
                ],
            ],
            [
                'es' => [
                    'keyword' => 'Vegetación',
                    'name' => 'Santuario de Flora',
                    'description' => 'Diferentes tipos de vegetación y cobertura terrestre, como bosques, selvas, praderas, etc.',
                ],
                'en' => [
                    'keyword' => 'Vegetation',
                    'name' => 'Sanctuary of Flora',
                    'description' => 'Different types of vegetation and land cover, such as forests, jungles, grasslands, etc.',
                ],
            ],
        ];

        // create the classifications using translations
        foreach ($classifications as $classif_entry) {

            $classif_data = [
                'es' => $classif_entry['es'],
                'en' => $classif_entry['en'],
            ];

            $new_classif = Classification::create($classif_data);
        }
    }
}
