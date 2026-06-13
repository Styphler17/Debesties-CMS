<?php

namespace Tests\Feature\Admin;

use App\Models\CrawlerLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\SettingsService;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiVisibilityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected $limitedAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->admin = User::whereHas('roles', fn ($q) => $q->where('slug', 'super_admin'))->first();

        $role = Role::create(['name' => 'Content Staff', 'slug' => 'content_staff']);
        $role->permissions()->sync([
            Permission::where('slug', 'posts.create')->firstOrFail()->id,
        ]);

        $this->limitedAdmin = User::factory()->create();
        $this->limitedAdmin->roles()->sync([$role->id]);
    }

    public function test_admin_can_view_ai_visibility_panel()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.ai-visibility.index'));

        $response->assertStatus(200);
        $response->assertSee('AI Crawler Access Control');
        $response->assertSee('Visibility Score');
    }

    public function test_admin_can_toggle_bot_access()
    {
        $this->withoutMiddleware();

        $response = $this->actingAs($this->admin)->postJson(route('admin.ai-visibility.update'), [
            'bot_id' => 'gptbot',
        ]);

        $response->assertStatus(200);
        $this->assertStringContainsString('gptbot', SettingsService::get('ai_blocked_bots'));
    }

    public function test_admin_role_without_settings_manage_cannot_toggle_bot_access()
    {
        $this->withoutMiddleware();

        $response = $this->actingAs($this->limitedAdmin)->postJson(route('admin.ai-visibility.update'), [
            'bot_id' => 'gptbot',
        ]);

        $response->assertForbidden();
        $this->assertStringNotContainsString('gptbot', SettingsService::get('ai_blocked_bots', '[]'));
    }

    public function test_admin_can_toggle_feature()
    {
        $this->withoutMiddleware();

        $response = $this->actingAs($this->admin)->postJson(route('admin.ai-visibility.update'), [
            'feature_id' => 'llms_txt',
        ]);

        $response->assertStatus(200);
        // Default is '1', toggling should make it '0'
        $this->assertEquals('0', SettingsService::get('ai_llms_txt_enabled'));
    }

    public function test_admin_can_clear_logs()
    {
        $this->withoutMiddleware();
        CrawlerLog::create([
            'bot_name' => 'GPTBot',
            'user_agent' => 'GPTBot/1.0',
            'path' => '/',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.ai-visibility.logs.clear'));

        $response->assertStatus(302);
        $this->assertDatabaseEmpty('crawler_logs');
    }

    public function test_admin_role_without_settings_manage_cannot_clear_logs()
    {
        $this->withoutMiddleware();
        CrawlerLog::create([
            'bot_name' => 'GPTBot',
            'user_agent' => 'GPTBot/1.0',
            'path' => '/',
        ]);

        $response = $this->actingAs($this->limitedAdmin)->delete(route('admin.ai-visibility.logs.clear'));

        $response->assertForbidden();
        $this->assertDatabaseCount('crawler_logs', 1);
    }

    public function test_crawler_visit_is_logged()
    {
        $this->get('/', [
            'User-Agent' => 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.0; +https://openai.com/gptbot)',
        ]);

        $this->assertDatabaseHas('crawler_logs', [
            'bot_name' => 'GPTBot',
        ]);
    }

    public function test_robots_txt_is_served()
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('User-agent: *');
    }

    public function test_llms_txt_is_served()
    {
        $response = $this->get('/llms.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('# Debesties CMS');
    }
}
