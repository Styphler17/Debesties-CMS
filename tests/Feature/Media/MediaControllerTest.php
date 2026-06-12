<?php

namespace Tests\Feature\Media;

use App\Models\Media;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
        $adminRole = Role::where('slug', 'super_admin')->firstOrFail();
        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([$adminRole->id]);
    }

    public function test_admin_can_access_media_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.media.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_upload_media_via_controller()
    {
        $file = UploadedFile::fake()->image('cover.png', 800, 600);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.media.store'), [
                'files' => [$file],
                'folder' => 'articles',
            ]);

        $response->assertRedirect(route('admin.media.index'));
        $this->assertDatabaseHas('media', ['file_name' => 'cover.png']);
    }

    public function test_admin_can_delete_media_via_controller()
    {
        $file = UploadedFile::fake()->image('cover.png', 800, 600);
        $media = (new \App\Actions\Media\UploadMedia())->handle($file, $this->admin);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.media.destroy', $media->id));

        $response->assertRedirect(route('admin.media.index'));
        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }
}
