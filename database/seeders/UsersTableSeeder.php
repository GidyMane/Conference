<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'enolaomukamani@gmail.com'],
            [
                'full_name' => 'System Administrator',
                'password' => Hash::make('Jucordan.01!'),
                'role' => 'ADMIN',
            ]
        );

        User::updateOrCreate(
            ['email' => 'fredah.maina@kalro.org'],
            [
                'full_name' => 'System Administrator',
                'password' => Hash::make('Password@123'),
                'role' => 'ADMIN',
            ]
        );

        User::updateOrCreate(
            ['email' => 'nancy.wele@kalro.org'],
            [
                'full_name' => 'System Administrator',
                'password' => Hash::make('Password@123'),
                'role' => 'ADMIN',
            ]
        );

        User::updateOrCreate(
            ['email' => 'peter.nduati@kalro.org'],
            [
                'full_name' => 'System Administrator',
                'password' => Hash::make('Password@123'),
                'role' => 'ADMIN',
            ]
        );

        User::updateOrCreate(
            ['email' => 'stephen.nzioka@kalro.org'],
            [
                'full_name' => 'System Administrator',
                'password' => Hash::make('Password@123'),
                'role' => 'ADMIN',
            ]
        );
    }
}