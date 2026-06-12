<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    private function createAdminUser(): User
    {
        $role = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin']);
        $user = User::factory()->create(['password' => bcrypt('password')]);
        $user->roles()->attach($role);

        return $user;
    }

    private function createSubscriberUser(): User
    {
        $role = Role::create(['name' => 'Subscriber', 'slug' => 'subscriber']);
        $user = User::factory()->create(['password' => bcrypt('password')]);
        $user->roles()->attach($role);

        return $user;
    }

    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Sign In');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $user = $this->createAdminUser();

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_login_fails_with_wrong_password(): void
    {
        $user = $this->createAdminUser();

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_subscriber_cannot_access_admin_panel(): void
    {
        $user = $this->createSubscriberUser();

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Should be blocked at login — subscriber flag check
        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_unauthenticated_user_redirected_from_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_logout(): void
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);

        $response = $this->post('/admin/logout');

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_authenticated_admin_redirected_away_from_login(): void
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);

        $response = $this->get('/admin/login');
        $response->assertRedirect(route('admin.dashboard'));
    }
}
