<?php

namespace App\Services;

use App\Models\Post;

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
}
