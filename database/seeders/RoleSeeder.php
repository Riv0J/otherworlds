<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        // create roles
        Role::create([
            'name' => 'owner',
            'icon' => 'fa-crown'
        ]);

        Role::create([
            'name' => 'admin',
            'icon' => 'fa-user-astronaut'
        ]);

        Role::create([
            'name' => 'guest',
            'icon' => 'fa-user-tie'
        ]);

        Role::create([
            'name' => 'user',
            'icon' => 'fa-user'
        ]);
    }
}
