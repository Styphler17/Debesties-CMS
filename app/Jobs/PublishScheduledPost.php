<?php

namespace App\Jobs;

use App\Actions\Posts\PublishPost;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishScheduledPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly Post $post) {}

    public function handle(): void
    {
        // Re-check status — user may have changed it before the job fired
        $this->post->refresh();

        if ($this->post->status !== 'scheduled') {
            return;
        }

        (new PublishPost)->handle($this->post);
    }
}
