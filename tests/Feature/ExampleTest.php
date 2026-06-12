<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_dashboard_redirects_unauthenticated(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }

    public function test_article_route_returns_a_successful_response(): void
    {
        $user = User::factory()->create(['slug' => 'test-user']);
        Post::create([
            'user_id' => $user->id,
            'title' => 'My Awesome Post',
            'slug' => 'my-awesome-post',
            'body' => 'my-awesome-post content',
            'status' => 'published',
        ]);

        $response = $this->get('/my-awesome-post');

        $response->assertStatus(200);
        $response->assertSee('my-awesome-post');
    }
}
