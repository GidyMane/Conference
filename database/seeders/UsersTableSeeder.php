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
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
        ]);

        User::create([
            'full_name' => 'Reviewer One',
            'email' => 'reviewer@example.com',
            'password' => Hash::make('password'),
            'role' => 'REVIEWER',
        ]);
    }
}
