<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$permissions = Permission::all();
echo 'Permissions created: '.$permissions->count()."\n";
$permissions->each(fn ($p) => print ('  - '.$p->slug."\n"));

$roles = Role::all();
echo "\nRoles created: ".$roles->count()."\n";
$roles->each(fn ($r) => print ('  - '.$r->slug.' ('.$r->permissions->count()." permissions)\n"));

$admin = User::where('email', 'admin@debesties.com')->first();
echo "\nAdmin user: ".($admin ? $admin->email.' with role: '.$admin->roles->first()->slug : 'NOT FOUND')."\n";
