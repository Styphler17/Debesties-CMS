<?php

namespace App\Observers;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaObserver
{
    public function created(Media $media): void
    {
        //
    }

    public function updated(Media $media): void
    {
        //
    }

    public function deleted(Media $media): void
    {
        $fileName = basename($media->file_path);

        Storage::disk('public')->delete($media->file_path);
        Storage::disk('public')->delete("uploads/thumb/{$fileName}");
        Storage::disk('public')->delete("uploads/medium/{$fileName}");
        Storage::disk('public')->delete("uploads/large/{$fileName}");
    }
}
