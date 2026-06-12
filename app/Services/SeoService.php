<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostInternalLink;

class SeoService
{
    public static function buildMeta(Post $post): array
    {
        $meta = $post->meta;

        $title = $meta && $meta->meta_title ? $meta->meta_title : $post->title . ' | Debesties';
        $description = $meta && $meta->meta_description ? $meta->meta_description : ($post->excerpt ?: substr(strip_tags($post->body), 0, 160));
        $keywords = $meta && $meta->meta_keywords ? $meta->meta_keywords : '';
        $canonical = $meta && $meta->canonical_url ? $meta->canonical_url : route('posts.show', $post->slug);
        
        $ogImage = $post->featuredImage ? $post->featuredImage->file_url : asset('docs/brand-files/logo-png.png');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'image' => $ogImage,
            'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : null,
            'dateModified' => $post->updated_at ? $post->updated_at->toIso8601String() : null,
            'author' => [
                '@type' => 'Person',
                'name' => $post->user ? $post->user->name : 'Debesties Editor',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Debesties',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('docs/brand-files/logo-png.png'),
                ]
            ],
            'description' => substr(strip_tags($description), 0, 160),
        ];

        return [
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keywords' => $keywords,
            'canonical_url' => $canonical,
            'og_title' => $meta && $meta->og_title ? $meta->og_title : $title,
            'og_description' => $meta && $meta->og_description ? $meta->og_description : $description,
            'og_image' => $ogImage,
            'schema' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        ];
    }

    public static function calculateScore(Post $post): int
    {
        $meta = $post->meta;
        $score = 100;

        $seoTitle = $meta ? $meta->seo_title : null;
        $metaDesc = $meta ? $meta->meta_description : null;
        $focusKeyword = $meta ? $meta->focus_keyword : null;

        if (empty($seoTitle)) {
            $score -= 30;
        } else {
            $len = mb_strlen($seoTitle);
            if ($len < 40 || $len > 60) {
                $score -= 10;
            }
        }

        if (empty($metaDesc)) {
            $score -= 30;
        } else {
            $len = mb_strlen($metaDesc);
            if ($len < 120 || $len > 160) {
                $score -= 10;
            }
        }

        if (empty($focusKeyword)) {
            $score -= 20;
        }

        return max(0, min(100, $score));
    }

    public static function suggestInternalLinks(Post $post): array
    {
        $suggestions = [];

        if (empty($post->body)) {
            return $suggestions;
        }

        // Get other published posts
        $otherPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->with('meta')
            ->get();

        foreach ($otherPosts as $otherPost) {
            // Check if there is already a link from $post to $otherPost by checking target_url
            $urlPath1 = route('posts.show', $otherPost->slug, false);
            $urlPath2 = route('posts.show', $otherPost->slug, true);
            
            $exists = PostInternalLink::where('post_id', $post->id)
                ->where(function ($query) use ($urlPath1, $urlPath2, $otherPost) {
                    $query->where('target_url', $urlPath1)
                          ->orWhere('target_url', $urlPath2)
                          ->orWhere('target_url', 'like', '%' . $otherPost->slug . '%');
                })
                ->exists();

            if ($exists) {
                continue;
            }

            $keyword = $otherPost->meta->focus_keyword ?? null;
            $title = $otherPost->title;

            $mentioned = false;

            if (!empty($keyword)) {
                if (stripos($post->body, $keyword) !== false) {
                    $mentioned = true;
                }
            }

            if (!$mentioned && !empty($title)) {
                if (stripos($post->body, $title) !== false) {
                    $mentioned = true;
                }
            }

            if ($mentioned) {
                $suggestions[] = [
                    'target_post_id' => $otherPost->id,
                    'title' => $otherPost->title,
                    'keyword' => $keyword
                ];
            }
        }

        return $suggestions;
    }
}
