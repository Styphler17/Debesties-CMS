<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
