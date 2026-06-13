<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageBuilderTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Role $adminRole;

    private User $limitedAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->adminRole = Role::where('slug', 'super_admin')->firstOrFail();

        $this->admin = User::factory()->create(['slug' => 'super-admin']);
        $this->admin->roles()->sync([$this->adminRole->id]);

        $role = Role::create(['name' => 'Content Staff', 'slug' => 'content_staff']);
        $role->permissions()->sync([
            Permission::where('slug', 'posts.create')->firstOrFail()->id,
        ]);

        $this->limitedAdmin = User::factory()->create(['slug' => 'limited-admin']);
        $this->limitedAdmin->roles()->sync([$role->id]);
    }

    public function test_guest_cannot_access_homepage_builder(): void
    {
        $response = $this->get(route('admin.homepage-builder.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_access_homepage_builder_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.homepage-builder.index'));
        $response->assertStatus(200);
        $response->assertViewHas('layout');
    }

    public function test_admin_can_save_homepage_layout(): void
    {
        $this->withoutMiddleware();
        $layoutPayload = json_encode([
            [
                'id' => 1,
                'type' => 'hero',
                'name' => 'Hero Banner',
                'settings' => [
                    'headline' => 'Test headline',
                    'subtext' => 'Test subtext',
                ],
            ],
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.homepage-builder.store'), [
                'layout' => $layoutPayload,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Homepage layout configuration saved successfully ✓',
        ]);

        $this->assertEquals($layoutPayload, SettingsService::get('homepage_layout'));
    }

    public function test_admin_role_without_settings_manage_cannot_save_homepage_layout(): void
    {
        $this->withoutMiddleware();
        $layoutPayload = json_encode([
            ['id' => 1, 'type' => 'hero', 'name' => 'Restricted Hero'],
        ]);

        $response = $this->actingAs($this->limitedAdmin)
            ->postJson(route('admin.homepage-builder.store'), [
                'layout' => $layoutPayload,
            ]);

        $response->assertForbidden();
        $this->assertNotEquals($layoutPayload, SettingsService::get('homepage_layout'));
    }

    public function test_public_homepage_renders_custom_layout(): void
    {
        $layoutPayload = json_encode([
            [
                'id' => 1,
                'type' => 'hero',
                'name' => 'Hero Banner',
                'settings' => [
                    'headline' => 'Dynamic Hero headline',
                    'subtext' => 'Dynamic subtext',
                    'theme' => 'gold-black',
                ],
            ],
        ]);

        SettingsService::set('homepage_layout', $layoutPayload);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Dynamic Hero headline');
        $response->assertSee('Dynamic subtext');
    }
}
