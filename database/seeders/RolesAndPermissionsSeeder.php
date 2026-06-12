<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'posts.create', 'posts.edit', 'posts.publish', 'posts.delete',
            'categories.manage', 'tags.manage',
            'media.upload', 'media.delete',
            'users.manage', 'roles.manage',
            'comments.moderate', 'settings.manage',
        ];

        $created = collect($permissions)->map(function ($slug) {
            return Permission::firstOrCreate(
                ['slug' => $slug],
                ['name' => $slug]
            );
        });

        // subscriber role — public users, no admin permissions
        Role::firstOrCreate(
            ['slug' => 'subscriber'],
            [
                'name' => 'Subscriber',
                'description' => 'Public registered user. Can view articles, write comments, and manage bookmarks.',
            ]
        );

        // super_admin role — all permissions
        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super_admin'],
            [
                'name' => 'Super Admin',
                'description' => 'Full access to all system features, settings, users, and content.',
            ]
        );
        $superAdmin->permissions()->sync($created->pluck('id'));

        // Create the first super admin user if none exists
        if (! User::whereHas('roles', fn ($q) => $q->where('slug', 'super_admin'))->exists()) {
            $user = User::firstOrCreate(
                ['email' => 'admin@debesties.com'],
                [
                    'name' => 'Admin',
                    'slug' => 'admin',
                    'password' => Hash::make('password'),
                    'status' => 'active',
                ]
            );
            $user->roles()->syncWithoutDetaching([$superAdmin->id]);
        }
    }
}
