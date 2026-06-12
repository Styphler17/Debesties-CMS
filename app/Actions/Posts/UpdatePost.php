<?php

namespace App\Actions\Posts;

use App\Actions\SEO\GenerateSlug;
use App\Models\Post;

class UpdatePost
{
    public function handle(Post $post, array $data): Post
    {
        $slug = $post->slug;

        if (isset($data['title']) && $data['title'] !== $post->title) {
            $slug = (new GenerateSlug)->handle($data['title'], 'posts');
        }

        $post->update([
            'title' => $data['title'] ?? $post->title,
            'slug' => $slug,
            'subtitle' => $data['subtitle'] ?? $post->subtitle,
            'excerpt' => $data['excerpt'] ?? $post->excerpt,
            'body' => $data['body'] ?? $post->body,
            'status' => $data['status'] ?? $post->status,
            'category_id' => $data['category_id'] ?? $post->category_id,
            'featured_image_id' => $data['featured_image_id'] ?? $post->featured_image_id,
        ]);

        $post->tags()->sync($data['tags'] ?? []);

        return $post;
    }
}
