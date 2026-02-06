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
    }
}
