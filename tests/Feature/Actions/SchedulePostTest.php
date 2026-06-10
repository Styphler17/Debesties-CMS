<?php

namespace Tests\Feature\Actions;

use App\Actions\Posts\SchedulePost;
use App\Jobs\PublishScheduledPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SchedulePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_schedule_sets_status_scheduled_and_scheduled_for(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'   => 'Future Post',
            'slug'    => 'future-post',
            'body'    => '<p>Body</p>',
            'user_id' => $user->id,
            'status'  => 'draft',
        ]);

        $scheduledAt = now()->addDays(3)->toDateTimeString();

        (new SchedulePost())->handle($post, $scheduledAt);

        $post->refresh();
        $this->assertSame('scheduled', $post->status);
        $this->assertNotNull($post->scheduled_for);
    }

    public function test_schedule_dispatches_publish_scheduled_post_job(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $post = Post::create([
            'title'   => 'Future Post',
            'slug'    => 'future-post',
            'body'    => '<p>Body</p>',
            'user_id' => $user->id,
            'status'  => 'draft',
        ]);

        (new SchedulePost())->handle($post, now()->addDays(1)->toDateTimeString());

        Queue::assertPushed(PublishScheduledPost::class, function ($job) use ($post) {
            return $job->post->id === $post->id;
        });
    }
}
