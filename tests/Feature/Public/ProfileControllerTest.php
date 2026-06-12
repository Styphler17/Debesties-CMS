<?php

namespace Tests\Feature\Public;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_guest_cannot_view_profile()
    {
        // For guest test, we NEED middleware to be active to see the redirect
        $response = $this->get(route('profile.show'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.show'));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee('Account Settings');
    }

    public function test_user_can_update_profile()
    {
        // Disable middleware to bypass CSRF
        $this->withoutMiddleware();

        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $response = $this->actingAs($user)->post(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'bio' => 'Updated bio',
            'newsletter' => 1,
        ]);

        $response->assertRedirect(route('profile.show'));

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('new@example.com', $user->email);
        $this->assertEquals('Updated bio', $user->bio);
        $this->assertTrue($user->newsletter);
    }

    public function test_user_can_update_password()
    {
        $this->withoutMiddleware();

        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->post(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('profile.show'));

        $user->refresh();
        $this->assertTrue(Hash::check('new-password', $user->password));
    }
}
