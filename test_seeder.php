<?php

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';

$app->make(Kernel::class)->bootstrap();

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

echo "===== VERIFICATION RESULTS =====\n\n";

$permissions = Permission::all();
echo '✓ Permissions created: '.$permissions->count()." (expected: 12)\n";
echo "  Permission slugs:\n";
$permissions->each(fn ($p) => print ('    - '.$p->slug."\n"));

$roles = Role::all();
echo "\n✓ Roles created: ".$roles->count()." (expected: 2)\n";
$roles->each(fn ($r) => print ('    - '.$r->slug.' (permissions: '.$r->permissions->count().")\n"));

$superAdmin = Role::where('slug', 'super_admin')->first();
echo "\n✓ Super Admin role has ".($superAdmin ? $superAdmin->permissions->count() : 0)." permissions (expected: 12)\n";

$admin = User::where('email', 'admin@debesties.com')->first();
echo "\n✓ Admin user created: ".($admin ? 'YES - '.$admin->email : 'NO')."\n";
if ($admin) {
    echo '  - Name: '.$admin->name."\n";
    echo '  - Slug: '.$admin->slug."\n";
    echo '  - Status: '.$admin->status."\n";
    echo '  - Role: '.($admin->roles->first() ? $admin->roles->first()->slug : 'NONE')."\n";
}

echo "\n===== SUMMARY =====\n";
$success = $permissions->count() === 12 &&
           $roles->count() === 2 &&
           $superAdmin &&
           $superAdmin->permissions->count() === 12 &&
           $admin &&
           $admin->roles->first()?->slug === 'super_admin';
echo $success ? "✓ All checks passed!\n" : "✗ Some checks failed!\n";
