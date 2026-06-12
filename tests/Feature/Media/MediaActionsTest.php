<?php

namespace Tests\Feature\Media;

use App\Actions\Media\DeleteMedia;
use App\Actions\Media\UploadMedia;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaActionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_upload_media_creates_original_file_and_media_record()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('photo.jpg', 600, 400);

        $media = (new UploadMedia)->handle($file, $user);

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'file_name' => 'photo.jpg',
            'user_id' => $user->id,
        ]);

        Storage::disk('public')->assertExists($media->file_path);
    }

    public function test_delete_media_removes_files_from_disk_and_database()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('photo.jpg', 600, 400);
        $media = (new UploadMedia)->handle($file, $user);

        $fileName = basename($media->file_path);

        // Touch variant dummy files to simulate job
        Storage::disk('public')->put("uploads/thumb/{$fileName}", 'thumb');
        Storage::disk('public')->put("uploads/medium/{$fileName}", 'medium');
        Storage::disk('public')->put("uploads/large/{$fileName}", 'large');

        (new DeleteMedia)->handle($media);

        $this->assertDatabaseMissing('media', ['id' => $media->id]);
        Storage::disk('public')->assertMissing($media->file_path);
        Storage::disk('public')->assertMissing("uploads/thumb/{$fileName}");
    }

    public function test_delete_media_throws_exception_if_referenced_in_post()
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('photo.jpg', 600, 400);
        $media = (new UploadMedia)->handle($file, $user);

        Post::create([
            'user_id' => $user->id,
            'title' => 'Sample Post',
            'slug' => 'sample-post',
            'body' => 'Content',
            'featured_image_id' => $media->id,
            'status' => 'draft',
        ]);

        $this->expectException(\Exception::class);
        (new DeleteMedia)->handle($media);
    }
}
