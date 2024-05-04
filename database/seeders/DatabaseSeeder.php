<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){

        // execute the independent seeders
        $this->call([
            CategorySeeder::class,
            RoleSeeder::class,
            CountrySeeder::class,
            PlaceSeeder::class,
            UserSeeder::class,
            SourceSeeder::class,
            MediaSeeder::class,
        ]);



    }
}
