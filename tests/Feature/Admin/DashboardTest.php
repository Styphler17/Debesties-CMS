<?php

namespace Tests\Feature\Admin;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->admin = User::whereHas('roles', fn ($q) => $q->where('slug', 'super_admin'))->first();
    }

    public function test_admin_can_view_dashboard_with_real_data()
    {
        // Setup data
        $category = Category::factory()->create(['name' => 'Tech News']);

        $post = Post::factory()->create([
            'title' => 'Dashboard Test Post',
            'status' => 'published',
            'view_count' => 1234,
            'category_id' => $category->id,
        ]);

        Comment::factory()->create([
            'post_id' => $post->id,
            'status' => 'pending',
        ]);

        ActivityLog::create([
            'user_id' => $this->admin->id,
            'action' => 'post.created',
            'details' => ['title' => 'Dashboard Test Post'],
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Test Post');
        $response->assertSee('1,234'); // Total views
        $response->assertSee('Tech News');
        $response->assertSee('post created'); // Activity action
    }
}
