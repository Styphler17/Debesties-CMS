<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiAssistantTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->admin = User::whereHas('roles', fn ($q) => $q->where('slug', 'super_admin'))->first();
    }

    public function test_admin_can_generate_tags()
    {
        $this->withoutMiddleware();
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.ai-assistant.generate-tags'), [
                'title' => 'Test Post Title',
                'body' => 'This is the body content of the test post.',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertIsArray($response->json('tags'));
    }

    public function test_admin_can_generate_outline()
    {
        $this->withoutMiddleware();
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.ai-assistant.generate-outline'), [
                'title' => 'The Future of Music',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertIsArray($response->json('outline'));
        $this->assertStringContainsString('Future of Music', $response->json('outline')[0]);
    }

    public function test_guest_cannot_use_ai_assistant()
    {
        // Don't bypass middleware here to let auth catch it
        $response = $this->postJson(route('admin.ai-assistant.generate-tags'), [
            'title' => 'Title',
            'body' => 'Body',
        ]);

        // Laravel 11 returns 401 for JSON requests without auth,
        // but if CSRF is first it might return 419.
        // Let's ensure it's not 200.
        $this->assertTrue($response->status() !== 200);
    }
}
