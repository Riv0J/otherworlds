<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        foreach (\App\Models\Place::all() as $place) {
            $fetch = $place->fetch_wikimedia_gallery('en');
            if($fetch == false){
                $place->fetch_wikimedia_gallery('es');
            }
        }
    }
}
