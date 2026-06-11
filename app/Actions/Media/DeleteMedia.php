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

        $fileName = basename($media->file_path);

        // Delete from storage
        Storage::disk('public')->delete($media->file_path);
        Storage::disk('public')->delete("uploads/thumb/{$fileName}");
        Storage::disk('public')->delete("uploads/medium/{$fileName}");
        Storage::disk('public')->delete("uploads/large/{$fileName}");

        // Delete DB record
        $media->delete();
    }
}
