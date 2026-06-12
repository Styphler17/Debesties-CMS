<?php

namespace App\Actions\Posts;

use App\Actions\SEO\GenerateSlug;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\User;

class CreatePost
{
    public function handle(array $data, User $user): Post
    {
        $slug = (new GenerateSlug)->handle($data['title'], 'posts');

        $post = Post::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'slug' => $slug,
            'subtitle' => $data['subtitle'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $data['body'],
            'status' => $data['status'] ?? 'draft',
            'category_id' => $data['category_id'] ?? null,
            'featured_image_id' => $data['featured_image_id'] ?? null,
        ]);

        PostMeta::create(['post_id' => $post->id]);

        if (! empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }
}
