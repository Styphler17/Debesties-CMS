<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private string $password = 'secret123';

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make($this->password),
            'api_token' => null,
        ]);
    }

    public function test_user_can_login_via_api()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'token']);

        $this->user->refresh();
        $this->assertNotNull($this->user->api_token);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_logout_via_api()
    {
        $this->user->api_token = 'test-token-123';
        $this->user->save();

        $response = $this->withHeader('Authorization', 'Bearer test-token-123')
            ->postJson('/api/logout');

        $response->assertStatus(200);
        $this->user->refresh();
        $this->assertNull($this->user->api_token);
    }

    public function test_cannot_access_profile_without_valid_token()
    {
        $response = $this->getJson('/api/me');
        $response->assertStatus(401);
    }

    public function test_user_can_retrieve_profile_via_api()
    {
        $this->user->api_token = 'test-token-123';
        $this->user->save();

        $response = $this->withHeader('Authorization', 'Bearer test-token-123')
            ->getJson('/api/me');

        $response->assertStatus(200);
        $response->assertJsonPath('email', $this->user->email);
    }

    public function test_user_can_update_profile_via_api()
    {
        $this->user->api_token = 'test-token-123';
        $this->user->save();

        $response = $this->withHeader('Authorization', 'Bearer test-token-123')
            ->putJson('/api/me', [
                'name' => 'Updated User Name',
                'bio' => 'New user bio',
                'newsletter' => false,
            ]);

        $response->assertStatus(200);
        $this->user->refresh();
        $this->assertEquals('Updated User Name', $this->user->name);
        $this->assertEquals('New user bio', $this->user->bio);
        $this->assertFalse($this->user->newsletter);
    }

    public function test_user_can_toggle_bookmark_via_api()
    {
        $this->user->api_token = 'test-token-123';
        $this->user->save();

        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        // Toggle on
        $response = $this->withHeader('Authorization', 'Bearer test-token-123')
            ->postJson('/api/bookmarks', [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('bookmarked', true);
        $this->assertTrue($this->user->bookmarks()->where('post_id', $post->id)->exists());

        // Toggle off
        $response = $this->withHeader('Authorization', 'Bearer test-token-123')
            ->postJson('/api/bookmarks', [
                'post_id' => $post->id,
            ]);

        $response->assertStatus(200);
        $response->assertJsonPath('bookmarked', false);
        $this->assertFalse($this->user->bookmarks()->where('post_id', $post->id)->exists());
    }

    public function test_user_can_get_bookmarks_list_via_api()
    {
        $this->user->api_token = 'test-token-123';
        $this->user->save();

        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'status' => 'published',
        ]);

        $this->user->bookmarks()->create(['post_id' => $post->id]);

        $response = $this->withHeader('Authorization', 'Bearer test-token-123')
            ->getJson('/api/bookmarks');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_user_can_submit_comment_via_api()
    {
        $this->user->api_token = 'test-token-123';
        $this->user->save();

        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $category->id,
            'status' => 'published',
            'slug' => 'api-comment-post',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer test-token-123')
            ->postJson('/api/posts/api-comment-post/comments', [
                'body' => 'This is a test comment from API',
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $this->user->id,
            'comment' => 'This is a test comment from API',
        ]);
    }
}
