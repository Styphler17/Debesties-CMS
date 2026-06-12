<?php

namespace App\Actions\Media;

use App\Models\Media;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Storage;

class DeleteMedia
{
    public function handle(Media $media): void
    {
        // Guard if referenced
        if (Post::where('featured_image_id', $media->id)->exists()) {
            throw new Exception("Cannot delete media: It is currently set as the featured image of a post.");
        }

        // Delete DB record (this automatically triggers the MediaObserver to delete files)
        $media->delete();
    }
}
