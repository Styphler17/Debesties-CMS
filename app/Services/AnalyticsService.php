<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Collection;

class AnalyticsService
{
    public static function topPosts(int $limit = 5): Collection
    {
        return Post::orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
