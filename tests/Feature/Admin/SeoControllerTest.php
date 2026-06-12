<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\PostMeta;
use App\Models\PostInternalLink;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoControllerTest extends TestCase
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
        $response = $this->get(route('admin.seo.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_subscriber_is_blocked_from_seo_tools()
    {
        $response = $this->actingAs($this->subscriber)->get(route('admin.seo.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_seo_dashboard()
    {
        // Create posts
        $post1 = Post::factory()->create(['title' => 'Post One Without Meta']);
        
        $post2 = Post::factory()->create(['title' => 'Post Two With Complete Meta']);
        PostMeta::create([
            'post_id' => $post2->id,
            'seo_title' => 'Perfect Custom SEO Title for Post Two and Beyond', // length: 50
            'meta_description' => 'This is a long enough and detailed meta description to satisfy the length audit checking mechanism completely.', // length: 110 (fails len 120-160 -> -10)
            'focus_keyword' => 'perfect SEO title'
        ]);

        $post3 = Post::factory()->create(['title' => 'Post Three Target Link']);

        // Create internal link from post 2 to post 3
        PostInternalLink::create([
            'post_id' => $post2->id,
            'anchor_text' => 'Post Three Target Link',
            'target_url' => route('posts.show', $post3->slug)
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.seo.index'));

        $response->assertStatus(200);
        $response->assertSee('Post One Without Meta');
        $response->assertSee('Post Two With Complete Meta');
        
        // Post 1 has no meta -> score should be 20 (100 - 30 - 30 - 20)
        $response->assertSee('20');
        
        // Post 2 has title (len 50 -> OK), description (len 110 -> fails 120-160 -> -10), focus keyword -> score should be 90
        $response->assertSee('90');
    }
}
