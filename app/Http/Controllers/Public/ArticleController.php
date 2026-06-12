<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\SeoService;

class ArticleController extends Controller
{
    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        // Increment view count
        $post->increment('view_count');

        // Fetch comments: approved top-level comments and their approved replies
        $comments = $post->comments()
            ->where('status', 'approved')
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->where('status', 'approved')->latest();
            }, 'user'])
            ->latest()
            ->get();

        // Load other relationships
        $post->load(['category', 'user', 'featuredImage', 'tags', 'meta']);

        // Generate SEO metadata
        $seo = SeoService::buildMeta($post);

        return view('public.article', compact('post', 'comments', 'seo'));
    }
}
