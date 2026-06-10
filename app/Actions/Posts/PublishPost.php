<?php

namespace App\Actions\Posts;

use App\Models\Post;
use Illuminate\Support\Carbon;

class PublishPost
{
    public function handle(Post $post): void
    {
        $post->status       = 'published';
        $post->published_at = Carbon::now();
        $post->save();
    }
}
