<?php

namespace Tests\Feature\Jobs;

use App\Jobs\PublishScheduledPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PublishScheduledPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_publishes_a_scheduled_post(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'        => 'Scheduled Post',
            'slug'         => 'scheduled-post',
            'body'         => '<p>Body</p>',
            'user_id'      => $user->id,
            'status'       => 'scheduled',
            'scheduled_for' => now()->subMinute(),
        ]);

        // Run the job directly (bypassing the queue)
        (new PublishScheduledPost($post))->handle();

        $post->refresh();
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_job_skips_if_status_is_not_scheduled(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'   => 'Draft Post',
            'slug'    => 'draft-post',
            'body'    => '<p>Body</p>',
            'user_id' => $user->id,
            'status'  => 'draft',
        ]);

        (new PublishScheduledPost($post))->handle();

        $post->refresh();
        $this->assertSame('draft', $post->status);
        $this->assertNull($post->published_at);
    }
}
