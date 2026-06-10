<?php

namespace App\Observers;

use App\Jobs\GenerateSeoSuggestions;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostObserver
{
    public function created(Post $post): void
    {
        GenerateSeoSuggestions::dispatch($post);
    }

    public function updated(Post $post): void
    {
        GenerateSeoSuggestions::dispatch($post);
    }

    public function deleted(Post $post): void
    {
        //
    }

    public function restored(Post $post): void
    {
        //
    }

    public function forceDeleted(Post $post): void
    {
        DB::table('post_meta')->where('post_id', $post->id)->delete();
        DB::table('post_tags')->where('post_id', $post->id)->delete();
        DB::table('post_related')
            ->where(function ($query) use ($post) {
                $query->where('post_id', $post->id)
                      ->orWhere('related_post_id', $post->id);
            })
            ->delete();
        DB::table('post_internal_links')->where('post_id', $post->id)->delete();
        DB::table('post_faqs')->where('post_id', $post->id)->delete();
        DB::table('post_sources')->where('post_id', $post->id)->delete();
    }
}
