<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@debesties.local',
            'password' => Hash::make('password'),
        ]);
    }
}
