<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;
use App\Models\Place;
use App\Models\Country;
class UserSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $owner_role_id = (Role::where('name', 'owner')->first())->id;
        $admin_role_id = (Role::where('name', 'admin')->first())->id;
        $guest_role_id = (Role::where('name', 'guest')->first())->id;
        $user_role_id = (Role::where('name', 'user')->first())->id;

        $owner = User::create([
            'name' => 'rivito',
            'email' => 'rivitoy@gmail.com',
            'password' => Hash::make('rivitoy'),
            'role_id' => $owner_role_id,
            'country_id' => 1,
            'img' => 'premade/1.gif'
        ]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role_id' => $admin_role_id,
            'country_id' => 1,
            'img' => 'premade/2.gif'
        ]);
        $admin2 = User::create([
            'name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin2'),
            'role_id' => $admin_role_id,
            'country_id' => 1,
            'img' => 'premade/3.gif'
        ]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'role_id' => $user_role_id,
            'country_id' => Country::random()->id,
            'img' => 'premade/2.gif'
        ]);

        $guest = User::create([
            'name' => 'guest',
            'email' => 'guest@gmail.com',
            'password' => Hash::make('guest'),
            'role_id' => $guest_role_id,
            'country_id' => Country::random()->id,
            'img' => 'premade/2.gif'
        ]);


        //create 50 random users
        User::factory()->count(50)->create();

        //create random favorites
        foreach(User::all() as $user){

            for ($i=0; $i < rand(1,10); $i++) {
                $random_place = Place::random();

                // prevent a duplicate favorite
                if($random_place->is_favorite($user) == false){
                    $user->favorites()->attach($random_place->id);
                }

            }
        }
    }
}
