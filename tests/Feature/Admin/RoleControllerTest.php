<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed default roles and permissions first
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->adminRole = Role::where('slug', 'super_admin')->first();
        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([$this->adminRole->id]);
    }

    public function test_admin_can_access_roles_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.roles.index'));
        $response->assertStatus(200);
        $response->assertViewHas('roles');
        $response->assertViewHas('permissions');
    }

    public function test_admin_can_create_role(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.roles.store'), [
                'name' => 'Moderator',
                'description' => 'Can moderate comments.',
            ]);

        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseHas('roles', [
            'name' => 'Moderator',
            'slug' => 'moderator',
            'description' => 'Can moderate comments.',
        ]);
    }

    public function test_admin_can_create_role_via_ajax(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.roles.store'), [
                'name' => 'Moderator',
                'description' => 'Can moderate comments.',
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertDatabaseHas('roles', ['name' => 'Moderator']);
    }

    public function test_admin_can_update_role_and_permissions_via_ajax(): void
    {
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor', 'description' => 'Old desc']);
        $permission = Permission::first();

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.roles.update', $role->id), [
                'name' => 'New Editor Name',
                'description' => 'New desc',
                'permissions' => [$permission->id],
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'New Editor Name',
            'description' => 'New desc',
        ]);

        $this->assertTrue($role->fresh()->permissions->contains($permission->id));
    }

    public function test_admin_cannot_delete_system_roles(): void
    {
        $subscriber = Role::where('slug', 'subscriber')->firstOrFail();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.roles.destroy', $subscriber->id));

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $this->assertDatabaseHas('roles', ['id' => $subscriber->id]);
    }

    public function test_admin_cannot_delete_role_with_assigned_users(): void
    {
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->sync([$role->id]);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.roles.destroy', $role->id));

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    public function test_admin_can_delete_empty_custom_role(): void
    {
        $role = Role::create(['name' => 'Moderator', 'slug' => 'moderator']);

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.roles.destroy', $role->id));

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
