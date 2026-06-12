<?php

namespace Tests\Feature\Public;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        
        $this->post = Post::create([
            'user_id' => $this->user->id,
            'title' => 'Test Post',
            'slug' => 'test-post',
            'body' => 'Post body content',
            'status' => 'published',
        ]);
    }

    public function test_guest_cannot_submit_comment(): void
    {
        $response = $this->post(route('posts.comments.store', $this->post->id), [
            'body' => 'This is a comment by a guest.',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseEmpty('comments');
    }

    public function test_authenticated_user_can_submit_comment_pending_by_default(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => 'First comment by user.',
            ]);

        $response->assertRedirect(route('posts.show', $this->post->slug));
        
        $this->assertDatabaseHas('comments', [
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'comment' => 'First comment by user.',
            'status' => 'pending',
        ]);
    }

    public function test_comment_is_auto_approved_if_prior_approved_comment_exists(): void
    {
        Comment::create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'comment' => 'Approved comment.',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => 'This should be auto-approved.',
            ]);

        $response->assertRedirect(route('posts.show', $this->post->slug));

        $this->assertDatabaseHas('comments', [
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'comment' => 'This should be auto-approved.',
            'status' => 'approved',
        ]);
    }

    public function test_nested_reply_support_up_to_one_level(): void
    {
        $parent = Comment::create([
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'comment' => 'Parent comment.',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => 'Reply level 1.',
                'parent_id' => $parent->id,
            ]);

        $response->assertRedirect(route('posts.show', $this->post->slug));
        
        $reply1 = Comment::where('comment', 'Reply level 1.')->firstOrFail();
        $this->assertEquals($parent->id, $reply1->parent_id);

        $response2 = $this->actingAs($this->user)
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => 'Reply level 2 (should flatten).',
                'parent_id' => $reply1->id,
            ]);

        $response2->assertRedirect(route('posts.show', $this->post->slug));
        
        $reply2 = Comment::where('comment', 'Reply level 2 (should flatten).')->firstOrFail();
        $this->assertEquals($parent->id, $reply2->parent_id);
    }
}
