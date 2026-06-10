<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Seed roles (e.g. Administrator, Editor, Author, Contributor)
        Role::create(['name' => 'Administrator', 'slug' => 'administrator']);
        Role::create(['name' => 'Editor', 'slug' => 'editor']);
        Role::create(['name' => 'Author', 'slug' => 'author']);
    }
}
