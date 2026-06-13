<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $editor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([Role::where('slug', 'super_admin')->first()->id]);

        $role = Role::create(['name' => 'Content Staff', 'slug' => 'content_staff']);
        $role->permissions()->sync([
            Permission::where('slug', 'posts.create')->firstOrFail()->id,
        ]);

        $this->editor = User::factory()->create();
        $this->editor->roles()->sync([$role->id]);
    }

    public function test_admin_can_save_settings(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.settings.store'), [
                'site_name' => 'Custom Blog Name',
                'timezone' => 'Europe/Brussels',
            ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertEquals('Custom Blog Name', SettingsService::get('site_name'));
        $this->assertEquals('Europe/Brussels', SettingsService::get('timezone'));
    }

    public function test_admin_role_without_settings_manage_cannot_access_settings(): void
    {
        $response = $this->actingAs($this->editor)->get(route('admin.settings.index'));

        $response->assertForbidden();
    }

    public function test_admin_role_without_settings_manage_cannot_save_settings(): void
    {
        $response = $this->actingAs($this->editor)
            ->post(route('admin.settings.store'), [
                'site_name' => 'Compromised Site Name',
            ]);

        $response->assertForbidden();
        $this->assertNotEquals('Compromised Site Name', SettingsService::get('site_name'));
    }
}
