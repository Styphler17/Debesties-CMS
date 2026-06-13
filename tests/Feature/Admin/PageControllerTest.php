<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Role $adminRole;

    private User $limitedAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->adminRole = Role::where('slug', 'super_admin')->firstOrFail();

        $this->admin = User::factory()->create(['slug' => 'super-admin']);
        $this->admin->roles()->sync([$this->adminRole->id]);

        $role = Role::create(['name' => 'Limited Admin', 'slug' => 'limited_admin']);
        $role->permissions()->sync([
            Permission::where('slug', 'categories.manage')->firstOrFail()->id,
        ]);

        $this->limitedAdmin = User::factory()->create(['slug' => 'limited-admin']);
        $this->limitedAdmin->roles()->sync([$role->id]);
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

    public function test_admin_can_create_page_with_layout(): void
    {
        $layout = [
            [
                'id' => 1,
                'background' => 'cream',
                'padding' => 'medium',
                'columns' => [
                    [
                        'id' => 2,
                        'widgets' => [
                            [
                                'id' => 3,
                                'type' => 'heading',
                                'settings' => ['text' => 'Welcome', 'level' => 'h2', 'alignment' => 'center'],
                            ],
                            [
                                'id' => 4,
                                'type' => 'text',
                                'settings' => ['content' => '<p>Hello world</p>', 'alignment' => 'left'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.pages.store'), [
                'title' => 'Builder Page',
                'layout' => json_encode($layout),
                'status' => 'published',
            ]);

        $response->assertRedirect(route('admin.pages.index'));

        $page = Page::where('title', 'Builder Page')->first();
        $this->assertNotNull($page);
        $this->assertNotNull($page->layout);
        $this->assertNotEmpty($page->body);
        $this->assertStringContainsString('Welcome', $page->body);
        $this->assertStringContainsString('Hello world', $page->body);
    }

    public function test_admin_role_without_posts_create_cannot_create_page(): void
    {
        $response = $this->actingAs($this->limitedAdmin)
            ->post(route('admin.pages.store'), [
                'title' => 'Restricted Page',
                'body' => 'Should not be created.',
                'status' => 'published',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('pages', ['slug' => 'restricted-page']);
    }

    public function test_admin_role_without_posts_edit_cannot_update_page(): void
    {
        $page = Page::create([
            'user_id' => $this->admin->id,
            'title' => 'Original Page',
            'slug' => 'original-page',
            'body' => 'Original body.',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->limitedAdmin)
            ->put(route('admin.pages.update', $page->id), [
                'title' => 'Compromised Page',
                'body' => 'Changed body.',
                'status' => 'published',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Original Page',
        ]);
    }

    public function test_admin_role_without_posts_delete_cannot_delete_page(): void
    {
        $page = Page::create([
            'user_id' => $this->admin->id,
            'title' => 'Original Page',
            'slug' => 'original-page',
            'body' => 'Original body.',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->limitedAdmin)
            ->delete(route('admin.pages.destroy', $page->id));

        $response->assertForbidden();
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    public function test_admin_can_update_page_with_layout(): void
    {
        $page = Page::create([
            'user_id' => $this->admin->id,
            'title' => 'Existing Page',
            'slug' => 'existing-page',
            'body' => 'Old content.',
            'status' => 'draft',
        ]);

        $layout = [
            [
                'id' => 1,
                'background' => 'white',
                'padding' => 'medium',
                'columns' => [
                    [
                        'id' => 2,
                        'widgets' => [
                            [
                                'id' => 3,
                                'type' => 'heading',
                                'settings' => ['text' => 'Updated Heading', 'level' => 'h2', 'alignment' => 'left'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.pages.update', $page->id), [
                'title' => 'Existing Page',
                'layout' => json_encode($layout),
                'status' => 'published',
            ]);

        $response->assertRedirect(route('admin.pages.index'));

        $page = $page->fresh();
        $this->assertNotNull($page->layout);
        $this->assertStringContainsString('Updated Heading', $page->body);
        $this->assertEquals('published', $page->status);
    }
}
