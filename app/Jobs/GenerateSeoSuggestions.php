<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\PostMeta;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateSeoSuggestions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly Post $post) {}

    public function handle(): void
    {
        $post = $this->post->load('tags');

        $metaDescription = Str::limit(
            $post->excerpt ?: strip_tags($post->body),
            160,
            ''
        );

        $focusKeyword = $post->tags->pluck('name')->join(', ');

        PostMeta::updateOrCreate(
            ['post_id' => $post->id],
            [
                'meta_description' => $metaDescription,
                'focus_keyword' => $focusKeyword,
            ]
        );
    }
}
