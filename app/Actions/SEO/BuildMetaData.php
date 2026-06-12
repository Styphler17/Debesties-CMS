<?php

namespace App\Actions\SEO;

use App\Models\Post;
use App\Services\SeoService;

class BuildMetaData
{
    public function handle(int $postId): array
    {
        $post = Post::findOrFail($postId);
        return SeoService::buildMeta($post);
    }
}
