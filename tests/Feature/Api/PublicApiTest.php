<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::create(['name' => 'General', 'slug' => 'general']);
    }

    public function test_can_retrieve_posts_list()
    {
        Post::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_can_retrieve_single_post_by_slug()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'status' => 'published',
            'slug' => 'test-post-slug',
            'view_count' => 0,
        ]);

        $response = $this->getJson('/api/posts/test-post-slug');

        $response->assertStatus(200);
        $response->assertJsonPath('slug', 'test-post-slug');

        $post->refresh();
        $this->assertEquals(1, $post->view_count);
    }

    public function test_can_retrieve_categories_list()
    {
        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
        $response->assertJsonFragment(['slug' => 'general']);
    }

    public function test_can_retrieve_tags_list()
    {
        Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);

        $response = $this->getJson('/api/tags');

        $response->assertStatus(200);
        $response->assertJsonFragment(['slug' => 'laravel']);
    }

    public function test_can_retrieve_public_settings()
    {
        $response = $this->getJson('/api/settings');

        $response->assertStatus(200);
        $response->assertJsonStructure(['site_name', 'site_description']);
    }
}
