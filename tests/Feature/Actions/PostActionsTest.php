<?php

namespace Tests\Feature\Actions;

use App\Actions\Posts\CreatePost;
use App\Actions\Posts\DeletePost;
use App\Actions\Posts\PublishPost;
use App\Actions\Posts\UpdatePost;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostActionsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;
    private Tag $tag1;
    private Tag $tag2;

    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();

        $this->user     = User::factory()->create();
        $this->category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $this->tag1     = Tag::create(['name' => 'PHP', 'slug' => 'php']);
        $this->tag2     = Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);
    }

    public function test_create_generates_slug_creates_post_meta_and_syncs_tags(): void
    {
        $post = (new CreatePost())->handle([
            'title'       => 'Hello World',
            'body'        => '<p>Content here</p>',
            'category_id' => $this->category->id,
            'tags'        => [$this->tag1->id, $this->tag2->id],
            'status'      => 'draft',
        ], $this->user);

        $this->assertDatabaseHas('posts', [
            'title'   => 'Hello World',
            'slug'    => 'hello-world',
            'user_id' => $this->user->id,
        ]);

        $this->assertDatabaseHas('post_meta', ['post_id' => $post->id]);

        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag1->id]);
        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag2->id]);

        $this->assertInstanceOf(Post::class, $post);
    }

    public function test_create_slug_is_unique_when_collision_exists(): void
    {
        Post::create(['title' => 'Hello World', 'slug' => 'hello-world', 'body' => 'x', 'user_id' => $this->user->id, 'status' => 'draft']);

        $post = (new CreatePost())->handle([
            'title'  => 'Hello World',
            'body'   => '<p>Different post</p>',
            'status' => 'draft',
        ], $this->user);

        $this->assertSame('hello-world-2', $post->slug);
    }

    public function test_update_regenerates_slug_when_title_changes(): void
    {
        $post = Post::create([
            'title'   => 'Original Title',
            'slug'    => 'original-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $updated = (new UpdatePost())->handle($post, [
            'title' => 'Updated Title',
            'body'  => '<p>Body</p>',
        ]);

        $this->assertSame('updated-title', $updated->fresh()->slug);
    }

    public function test_update_does_not_regenerate_slug_when_title_unchanged(): void
    {
        $post = Post::create([
            'title'   => 'Original Title',
            'slug'    => 'original-title',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);

        $updated = (new UpdatePost())->handle($post, [
            'title' => 'Original Title',
            'body'  => '<p>Updated body</p>',
        ]);

        $this->assertSame('original-title', $updated->fresh()->slug);
    }

    public function test_update_resyncs_tags(): void
    {
        $post = Post::create([
            'title'   => 'Tagged Post',
            'slug'    => 'tagged-post',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);
        PostMeta::create(['post_id' => $post->id]);
        $post->tags()->attach([$this->tag1->id]);

        (new UpdatePost())->handle($post, [
            'title' => 'Tagged Post',
            'body'  => '<p>Body</p>',
            'tags'  => [$this->tag2->id],
        ]);

        $this->assertDatabaseMissing('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag1->id]);
        $this->assertDatabaseHas('post_tags', ['post_id' => $post->id, 'tag_id' => $this->tag2->id]);
    }

    public function test_delete_soft_deletes_post(): void
    {
        $post = Post::create([
            'title'   => 'To Delete',
            'slug'    => 'to-delete',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);

        (new DeletePost())->handle($post);

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_publish_sets_status_published_and_published_at(): void
    {
        $post = Post::create([
            'title'   => 'To Publish',
            'slug'    => 'to-publish',
            'body'    => '<p>Body</p>',
            'user_id' => $this->user->id,
            'status'  => 'draft',
        ]);

        (new PublishPost())->handle($post);

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
    }
}
