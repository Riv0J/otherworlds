<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role_id = (Role::where('name', 'admin')->first())->id;
        $user_role_id = (Role::where('name', 'user')->first())->id;

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin',
            'password' => Hash::make('admin'),
            'role_id' => $admin_role_id,
        ]);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'role_id' => $user_role_id,
        ]);
    }
}
