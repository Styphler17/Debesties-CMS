<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public static function url(Media $media, string $variant = 'original'): string
    {
        if ($variant === 'original') {
            return Storage::disk('public')->url($media->file_path);
        }

        $fileName = basename($media->file_path);
        return Storage::disk('public')->url("uploads/{$variant}/{$fileName}");
    }
}
