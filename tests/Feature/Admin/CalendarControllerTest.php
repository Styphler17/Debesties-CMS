<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_calendar_and_see_posts(): void
    {
        // Setup admin user
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $user = User::factory()->create();
        $user->roles()->attach($adminRole);

        // Create a post
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Post Title',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('admin.calendar.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Post Title');
    }

    public function test_guest_cannot_access_calendar(): void
    {
        $response = $this->get(route('admin.calendar.index'));
        $response->assertRedirect(route('admin.login'));
    }
}
