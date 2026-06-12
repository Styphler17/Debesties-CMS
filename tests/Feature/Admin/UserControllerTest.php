<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Role $adminRole;

    private Role $subscriberRole;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        // Seed default roles and permissions first
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->adminRole = Role::where('slug', 'super_admin')->firstOrFail();
        $this->subscriberRole = Role::where('slug', 'subscriber')->firstOrFail();

        $this->admin = User::factory()->create();
        $this->admin->roles()->sync([$this->adminRole->id]);
    }

    public function test_admin_can_access_users_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertViewHas('users');
        $response->assertViewHas('roles');
    }

    public function test_admin_can_create_user_with_hashed_password_and_default_role(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'secret123',
                'status' => 'active',
                'newsletter' => '1',
                'bio' => 'A writer',
            ]);

        $response->assertRedirect(route('admin.users.index'));

        $user = User::where('email', 'john@example.com')->firstOrFail();

        $this->assertTrue(Hash::check('secret123', $user->password));
        $this->assertEquals('john-doe', $user->slug);

        // Assert default subscriber role attached via UserObserver
        $this->assertTrue($user->roles->contains($this->subscriberRole->id));
    }

    public function test_admin_can_create_user_with_avatar_and_roles(): void
    {
        $editorRole = Role::create(['name' => 'Editor', 'slug' => 'editor']);
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'name' => 'Jane Editor',
                'email' => 'jane@example.com',
                'password' => 'secret123',
                'status' => 'active',
                'roles' => [$editorRole->id],
                'avatar' => $avatar,
            ]);

        $response->assertRedirect(route('admin.users.index'));

        $user = User::where('email', 'jane@example.com')->firstOrFail();

        $this->assertNotNull($user->avatar);
        $this->assertTrue($user->roles->contains($editorRole->id));
        $this->assertFalse($user->roles->contains($this->subscriberRole->id)); // Overridden
    }

    public function test_admin_can_update_user(): void
    {
        $user = User::factory()->create();
        $user->roles()->sync([$this->subscriberRole->id]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.users.update', $user->id), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'status' => 'suspended',
                'newsletter' => '0',
                'roles' => [$this->adminRole->id],
            ]);

        $response->assertRedirect(route('admin.users.index'));

        $user = $user->fresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertEquals('suspended', $user->status);
        $this->assertFalse($user->newsletter);
        $this->assertTrue($user->roles->contains($this->adminRole->id));
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $response = $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $this->admin->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'You cannot delete your own account.');

        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'deleted_at' => null]);
    }

    public function test_admin_can_delete_other_user_reassigning_posts_and_soft_deleting(): void
    {
        $user = User::factory()->create();

        // Author some posts
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'User Post',
            'slug' => 'user-post',
            'body' => 'Body content',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $user->id));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'User deleted successfully.');

        // Assert user soft deleted
        $this->assertSoftDeleted('users', ['id' => $user->id]);

        // Assert posts reassigned to the deleting admin
        $this->assertEquals($this->admin->id, $post->fresh()->user_id);
    }
}
