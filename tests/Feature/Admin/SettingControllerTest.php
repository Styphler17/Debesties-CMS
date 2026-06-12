<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([Role::where('slug', 'super_admin')->first()->id]);
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
}
