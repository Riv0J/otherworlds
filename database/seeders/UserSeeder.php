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
        $admin_role_id = (Role::where('name', 'admin')->first())->id;
        $user_role_id = (Role::where('name', 'user')->first())->id;

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role_id' => $admin_role_id,
            'country_id' => 1,
        ]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'role_id' => $user_role_id,
            'country_id' => Country::random()->id,
        ]);

        //create 20 random users
        User::factory()->count(20)->create();

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
