<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostInternalLink;
use App\Services\SeoService;

class SeoController extends Controller
{
    public function index()
    {
        $posts = Post::with('meta')->get();

        $auditPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'meta_title' => $post->meta->seo_title ?? '',
                'meta_desc' => $post->meta->meta_description ?? '',
                'keyword' => $post->meta->focus_keyword ?? '',
                'score' => SeoService::calculateScore($post),
            ];
        })->toArray();

        $internalLinks = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'link_count' => PostInternalLink::where('post_id', $post->id)->count(),
                'suggestions' => count(SeoService::suggestInternalLinks($post)),
            ];
        })->toArray();

        $avgScore = count($auditPosts) > 0
            ? (int) round(array_sum(array_column($auditPosts, 'score')) / count($auditPosts))
            : 0;

        $missingMeta = count(array_filter($auditPosts, fn ($p) => empty($p['meta_title']) || empty($p['meta_desc'])));
        $missingKeyword = count(array_filter($auditPosts, fn ($p) => empty($p['keyword'])));

        return view('admin.seo.index', compact('auditPosts', 'internalLinks', 'avgScore', 'missingMeta', 'missingKeyword'));
    }
}
