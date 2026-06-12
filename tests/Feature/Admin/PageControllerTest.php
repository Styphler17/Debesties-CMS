<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->adminRole = Role::where('slug', 'super_admin')->firstOrFail();

        $this->admin = User::factory()->create(['slug' => 'super-admin']);
        $this->admin->roles()->sync([$this->adminRole->id]);
    }

    public function test_admin_can_access_pages_index(): void
    {
        Page::create([
            'user_id' => $this->admin->id,
            'title' => 'Test Page Title',
            'slug' => 'test-page-title',
            'body' => 'Test Page Body Content',
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.pages.index'));
        $response->assertStatus(200);
        $response->assertViewHas('pages');
    }

    public function test_admin_can_search_pages(): void
    {
        Page::create([
            'user_id' => $this->admin->id,
            'title' => 'UniquePageSearchTitle',
            'slug' => 'uniquepagesearchtitle',
            'body' => 'Body Content',
            'status' => 'published',
        ]);

        Page::create([
            'user_id' => $this->admin->id,
            'title' => 'Another Regular Title',
            'slug' => 'another-regular-title',
            'body' => 'Body Content',
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.pages.index', ['q' => 'UniquePageSearchTitle']));
        $response->assertStatus(200);
        $pages = $response->viewData('pages');
        $this->assertCount(1, $pages);
        $this->assertEquals('UniquePageSearchTitle', $pages->first()->title);
    }

    public function test_admin_can_create_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.pages.store'), [
                'title' => 'About Us',
                'body' => 'This is the about us page body content.',
                'status' => 'published',
            ]);

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', [
            'title' => 'About Us',
            'slug' => 'about-us',
            'status' => 'published',
        ]);
    }

    public function test_create_page_validation_fails_for_missing_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.pages.store'), [
                'title' => '',
                'body' => '',
                'status' => 'invalid-status',
            ]);

        $response->assertSessionHasErrors(['title', 'body', 'status']);
    }

    public function test_admin_can_update_page(): void
    {
        $page = Page::create([
            'user_id' => $this->admin->id,
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'body' => 'Privacy Policy content.',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.pages.update', $page->id), [
                'title' => 'Updated Privacy Policy',
                'body' => 'Updated content of policy.',
                'status' => 'published',
            ]);

        $response->assertRedirect(route('admin.pages.index'));

        $page = $page->fresh();
        $this->assertEquals('Updated Privacy Policy', $page->title);
        $this->assertEquals('updated-privacy-policy', $page->slug);
        $this->assertEquals('published', $page->status);
    }

    public function test_admin_can_delete_page(): void
    {
        $page = Page::create([
            'user_id' => $this->admin->id,
            'title' => 'Delete Me',
            'slug' => 'delete-me',
            'body' => 'Body.',
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.pages.destroy', $page->id));

        $response->assertRedirect(route('admin.pages.index'));
        $this->assertSoftDeleted('pages', ['id' => $page->id]);
    }
}
