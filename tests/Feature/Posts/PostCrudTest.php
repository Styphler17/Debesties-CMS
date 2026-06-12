<?php

namespace Tests\Feature\Posts;

use App\Jobs\PublishScheduledPost;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
        $role        = Role::where('slug', 'super_admin')->firstOrFail();
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($role);

        $this->category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
    }

    public function test_admin_can_view_posts_list(): void
    {
        Queue::fake();

        $this->actingAs($this->admin)
            ->get(route('admin.posts.index'))
            ->assertStatus(200);
    }

    public function test_admin_can_create_a_post(): void
    {
        Queue::fake();

        $tag = Tag::create(['name' => 'PHP', 'slug' => 'php']);

        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), [
            'title'       => 'Test Post Title',
            'body'        => '<p>Post body content</p>',
            'category_id' => $this->category->id,
            'tags'        => [$tag->id],
            'status'      => 'draft',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title'  => 'Test Post Title',
            'slug'   => 'test-post-title',
            'status' => 'draft',
        ]);

        $post = Post::where('title', 'Test Post Title')->first();
        $this->assertDatabaseHas('post_meta', ['post_id' => $post->id]);
        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $tag->id]);
    }

    public function test_admin_can_update_post_and_slug_changes_on_title_change(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'Original Title',
            'slug'    => 'original-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $this->actingAs($this->admin)->put(route('admin.posts.update', $post), [
            'title'       => 'Updated Title',
            'body'        => '<p>Updated body</p>',
            'category_id' => $this->category->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Updated Title',
            'slug'  => 'updated-title',
        ]);
    }

    public function test_slug_not_regenerated_when_title_unchanged(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'Same Title',
            'slug'    => 'same-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $this->actingAs($this->admin)->put(route('admin.posts.update', $post), [
            'title'       => 'Same Title',
            'body'        => '<p>Different body</p>',
            'category_id' => $this->category->id,
        ]);

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'slug' => 'same-title']);
    }

    public function test_admin_can_soft_delete_post(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'To Be Deleted',
            'slug'    => 'to-be-deleted',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.posts.destroy', $post));

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_admin_can_publish_post(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'To Be Published',
            'slug'    => 'to-be-published',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.posts.publish', $post));

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_admin_can_schedule_post(): void
    {
        Queue::fake();

        $post = Post::create([
            'title'   => 'To Be Scheduled',
            'slug'    => 'to-be-scheduled',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);

        $scheduledFor = now()->addDays(2)->format('Y-m-d H:i:s');

        $this->actingAs($this->admin)->post(route('admin.posts.schedule', $post), [
            'scheduled_for' => $scheduledFor,
        ]);

        $post->refresh();
        $this->assertSame('scheduled', $post->status);
        $this->assertNotNull($post->scheduled_for);

        Queue::assertPushed(PublishScheduledPost::class, function ($job) use ($post) {
            return $job->post->id === $post->id;
        });
    }

    public function test_unauthenticated_user_redirected_to_admin_login(): void
    {
        $this->get(route('admin.posts.index'))
            ->assertRedirect(route('admin.login'));
    }
}
