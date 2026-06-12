<?php

namespace Tests\Feature\Public;

use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->withoutMiddleware();
    }

    public function test_user_can_bookmark_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post(route('bookmarks.store', $post));

        $response->assertStatus(302);
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
    }

    public function test_user_can_remove_bookmark()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $user->bookmarks()->create(['post_id' => $post->id]);

        $response = $this->actingAs($user)->delete(route('bookmarks.destroy', $post));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
    }

    public function test_ajax_bookmark()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->postJson(route('bookmarks.store', $post));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }
}
