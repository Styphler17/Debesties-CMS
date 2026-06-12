<?php

namespace Tests\Feature\Admin;

use App\Models\CrawlerLog;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $subscriber;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([Role::where('slug', 'super_admin')->first()->id]);

        $this->subscriber = User::factory()->create();
        $this->subscriber->roles()->sync([Role::where('slug', 'subscriber')->first()->id]);
    }

    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get(route('admin.analytics.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_subscriber_is_blocked_from_analytics()
    {
        $response = $this->actingAs($this->subscriber)->get(route('admin.analytics.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_analytics_dashboard()
    {
        // Create posts with views
        Post::factory()->create([
            'title' => 'Top Visited Premium Topic',
            'view_count' => 1000,
        ]);

        Post::factory()->create([
            'title' => 'Second Best Topic',
            'view_count' => 500,
        ]);

        // Create crawler log
        CrawlerLog::create([
            'bot_name' => 'OpenAI',
            'user_agent' => 'GPTBot',
            'ip_address' => '127.0.0.1',
            'path' => 'posts/some-slug',
            'status_code' => '200',
            'created_at' => now()->subDays(2),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.analytics.index'));

        $response->assertStatus(200);
        $response->assertSee('Top Visited Premium Topic');
        $response->assertSee('Second Best Topic');

        // Total Views should be post views (1500) + crawler count (1) = 1501.
        // Formatted as: 1,501
        $response->assertSee('1,501');
    }

    public function test_admin_can_filter_analytics_by_range()
    {
        Post::factory()->create([
            'title' => 'Any Topic',
            'view_count' => 300,
        ]);

        // Access 7d range
        $response7d = $this->actingAs($this->admin)->get(route('admin.analytics.index', ['range' => '7d']));
        $response7d->assertStatus(200);
        $response7d->assertSee('Daily Views — Last 7 Days');

        // Access 90d range
        $response90d = $this->actingAs($this->admin)->get(route('admin.analytics.index', ['range' => '90d']));
        $response90d->assertStatus(200);
        $response90d->assertSee('Daily Views — Last 90 Days');
    }
}
