<?php

namespace App\Actions\Media;

use App\Jobs\OptimizeMedia;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadMedia
{
    public function handle(UploadedFile $file, User $user, ?string $folder = 'articles'): Media
    {
        $uuid = Str::uuid()->toString();
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $fileName = "{$uuid}.{$ext}";
        $filePath = "uploads/originals/{$fileName}";

        // Save original to storage disk
        Storage::disk('public')->putFileAs('uploads/originals', $file, $fileName);

        // Get dimensions if it is an image
        $width = null;
        $height = null;
        $dims = @getimagesize($file->getRealPath());
        if ($dims) {
            $width = $dims[0];
            $height = $dims[1];
        }

        $media = Media::create([
            'user_id' => $user->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_url' => Storage::disk('public')->url($filePath),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'alt_text' => null,
            'caption' => null,
            'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'folder' => $folder,
            'width' => $width,
            'height' => $height,
        ]);

        OptimizeMedia::dispatch($media->id);

        return $media;
    }
}
