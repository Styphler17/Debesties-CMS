<?php

namespace Tests\Feature\Auth;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_permission_returns_true_when_permission_assigned(): void
    {
        $permission = Permission::create(['name' => 'posts.create', 'slug' => 'posts.create']);
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor']);
        $role->permissions()->attach($permission);

        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->assertTrue($user->hasPermission('posts.create'));
    }

    public function test_user_has_permission_returns_false_when_not_assigned(): void
    {
        $user = User::factory()->create();
        $this->assertFalse($user->hasPermission('posts.delete'));
    }

    public function test_user_roles_relation_returns_assigned_roles(): void
    {
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->assertCount(1, $user->roles);
        $this->assertEquals('editor', $user->roles->first()->slug);
    }
}
