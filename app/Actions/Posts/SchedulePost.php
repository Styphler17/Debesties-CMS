<?php

namespace App\Actions\Posts;

use App\Jobs\PublishScheduledPost;
use App\Models\Post;
use Illuminate\Support\Carbon;

class SchedulePost
{
    public function handle(Post $post, string $scheduledAt): void
    {
        $scheduledFor = Carbon::parse($scheduledAt);

        $post->status = 'scheduled';
        $post->scheduled_for = $scheduledFor;
        $post->save();

        PublishScheduledPost::dispatch($post)->delay($scheduledFor);
    }
}
