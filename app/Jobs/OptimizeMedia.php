<?php

namespace App\Jobs;

use App\Models\Media;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OptimizeMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly int $mediaId)
    {
    }

    public function handle(): void
    {
        $media = Media::find($this->mediaId);
        if (!$media) return;

        $path = Storage::disk('public')->path($media->file_path);
        if (!file_exists($path)) return;

        // Ensure directories exist
        Storage::disk('public')->makeDirectory('uploads/thumb');
        Storage::disk('public')->makeDirectory('uploads/medium');
        Storage::disk('public')->makeDirectory('uploads/large');

        // Create variants using GD
        $this->resizeImage($path, Storage::disk('public')->path("uploads/thumb/" . basename($media->file_path)), 300, 200, true);
        $this->resizeImage($path, Storage::disk('public')->path("uploads/medium/" . basename($media->file_path)), 800, null, false);
        $this->resizeImage($path, Storage::disk('public')->path("uploads/large/" . basename($media->file_path)), 1200, null, false);
    }

    private function resizeImage(string $src, string $dst, int $targetWidth, ?int $targetHeight, bool $crop): void
    {
        $info = @getimagesize($src);
        if (!$info) return;

        $w = $info[0];
        $h = $info[1];
        $type = $info[2];

        switch ($type) {
            case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($src); break;
            case IMAGETYPE_PNG:  $img = imagecreatefrompng($src); break;
            case IMAGETYPE_GIF:  $img = imagecreatefromgif($src); break;
            case IMAGETYPE_WEBP: $img = imagecreatefromwebp($src); break;
            default: return;
        }

        if (!$img) return;

        if ($crop && $targetHeight) {
            // Cropping to exact aspect ratio
            $ratio = max($targetWidth / $w, $targetHeight / $h);
            $newW = (int)($w * $ratio);
            $newH = (int)($h * $ratio);
            
            $resized = imagecreatetruecolor($targetWidth, $targetHeight);
            
            // Handle transparency
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            
            imagecopyresampled(
                $resized, $img,
                0, 0,
                (int)(($w - $targetWidth / $ratio) / 2), (int)(($h - $targetHeight / $ratio) / 2),
                $targetWidth, $targetHeight,
                (int)($targetWidth / $ratio), (int)($targetHeight / $ratio)
            );
        } else {
            // Proportional resize
            $ratio = $targetWidth / $w;
            $newW = $targetWidth;
            $newH = (int)($h * $ratio);

            $resized = imagecreatetruecolor($newW, $newH);
            
            // Handle transparency
            imagealphablending($resized, false);
            imagesavealpha($resized, true);

            imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);
        }

        switch ($type) {
            case IMAGETYPE_JPEG: imagejpeg($resized, $dst, 85); break;
            case IMAGETYPE_PNG:  imagepng($resized, $dst, 6); break;
            case IMAGETYPE_GIF:  imagegif($resized, $dst); break;
            case IMAGETYPE_WEBP: imagewebp($resized, $dst, 80); break;
        }

        imagedestroy($img);
        imagedestroy($resized);
    }
}
