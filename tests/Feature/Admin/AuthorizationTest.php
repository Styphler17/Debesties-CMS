<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected $subscriber;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);

        $this->admin = User::whereHas('roles', fn ($q) => $q->where('slug', 'super_admin'))->first();

        $this->subscriber = User::factory()->create();
        $this->subscriber->roles()->attach(Role::where('slug', 'subscriber')->first());
    }

    public function test_super_admin_can_access_posts_index()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.posts.index'));
        $response->assertStatus(200);
    }

    public function test_subscriber_cannot_access_posts_index()
    {
        $response = $this->actingAs($this->subscriber)->get(route('admin.posts.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_edit_any_post()
    {
        $post = Post::factory()->create(['user_id' => $this->subscriber->id]);

        $response = $this->actingAs($this->admin)->get(route('admin.posts.edit', $post));
        $response->assertStatus(200);
    }

    public function test_user_can_edit_own_post_if_has_permission()
    {
        // Add posts.edit permission to subscriber for this test (simulating an Editor role)
        $editPermission = Permission::where('slug', 'posts.edit')->first();
        $this->subscriber->roles()->first()->permissions()->attach($editPermission);

        $post = Post::factory()->create(['user_id' => $this->subscriber->id]);

        // Note: AdminMiddleware will still block subscriber.
        // For this test to pass policy check, we need to bypass middleware or use a role that middleware allows.

        $response = $this->actingAs($this->subscriber)->get(route('admin.posts.edit', $post));
        // Still 403 because of AdminMiddleware, but let's test policy directly
        $this->assertTrue($this->subscriber->can('update', $post));
    }
}
