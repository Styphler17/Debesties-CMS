<?php

namespace App\Actions\SEO;

use App\Models\Post;
use App\Services\SeoService;

class SuggestInternalLinks
{
    public function handle(int $postId): array
    {
        $post = Post::findOrFail($postId);

        return SeoService::suggestInternalLinks($post);
    }
}
