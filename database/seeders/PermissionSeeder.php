<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Seed permissions (e.g. manage-posts, manage-users, manage-settings, publish-posts)
        Permission::create(['name' => 'Manage Posts', 'slug' => 'manage-posts']);
        Permission::create(['name' => 'Manage Users', 'slug' => 'manage-users']);
        Permission::create(['name' => 'Manage Settings', 'slug' => 'manage-settings']);
    }
}
