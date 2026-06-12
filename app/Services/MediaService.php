<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public static function url(Media $media, string $variant = 'original'): string
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        if ($variant === 'original') {
            return $disk->url($media->file_path);
        }

        $fileName = basename($media->file_path);

        return $disk->url("uploads/{$variant}/{$fileName}");
    }
}
