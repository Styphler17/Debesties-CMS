<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_permission_reflects_role_permission_changes(): void
    {
        $permission = Permission::create([
            'name' => 'settings.manage',
            'slug' => 'settings.manage',
        ]);

        $role = Role::create([
            'name' => 'Limited Admin',
            'slug' => 'limited_admin',
        ]);

        $user = User::factory()->create();
        $user->roles()->sync([$role->id]);

        $this->assertFalse($user->hasPermission('settings.manage'));

        $role->permissions()->sync([$permission->id]);

        $this->assertTrue($user->hasPermission('settings.manage'));
    }
}
