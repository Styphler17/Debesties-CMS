<?php

namespace App\Actions\Posts;

use App\Models\Post;

class DeletePost
{
    public function handle(Post $post): void
    {
        $post->delete();
    }
}
