<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$permissions = \App\Models\Permission::all();
echo "Permissions created: " . $permissions->count() . "\n";
$permissions->each(fn($p) => echo "  - " . $p->slug . "\n");

$roles = \App\Models\Role::all();
echo "\nRoles created: " . $roles->count() . "\n";
$roles->each(fn($r) => echo "  - " . $r->slug . " (" . $r->permissions->count() . " permissions)\n");

$admin = \App\Models\User::where('email', 'admin@debesties.com')->first();
echo "\nAdmin user: " . ($admin ? $admin->email . " with role: " . $admin->roles->first()->slug : 'NOT FOUND') . "\n";
