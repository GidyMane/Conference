<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'full_name' => 'System Administrator',
            'email' => 'enolaomukamani@gmail.com',
            'password' => Hash::make('Jucordan.01!'),
            'role' => 'ADMIN',
        ]);

        User::create([
            'full_name' => 'System Administrator',
            'email' => 'fredah.maina@kalro.org',
            'password' => Hash::make('Password@123'),
            'role' => 'ADMIN',
        ]);

        User::create([
            'full_name' => 'System Administrator',
            'email' => 'nancy.wele@kalro.org',
            'password' => Hash::make('Password@123'),
            'role' => 'ADMIN',
        ]);

        User::create([
            'full_name' => 'System Administrator',
            'email' => 'peter.nduati@kalro.org',
            'password' => Hash::make('Password@123'),
            'role' => 'ADMIN',
        ]);
    }
}
