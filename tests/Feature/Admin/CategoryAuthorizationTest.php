<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $editor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $role = Role::create(['name' => 'Content Staff', 'slug' => 'content_staff']);
        $role->permissions()->sync([
            Permission::where('slug', 'posts.create')->firstOrFail()->id,
        ]);

        $this->editor = User::factory()->create();
        $this->editor->roles()->sync([$role->id]);
    }

    public function test_admin_role_without_categories_manage_cannot_create_category(): void
    {
        $response = $this->actingAs($this->editor)
            ->post(route('admin.categories.store'), [
                'name' => 'Restricted Category',
                'description' => 'Should not be created.',
                'sort_order' => 0,
                'is_visible' => true,
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('categories', ['slug' => 'restricted-category']);
    }

    public function test_admin_role_without_categories_manage_cannot_update_category(): void
    {
        $category = Category::create([
            'name' => 'Original Category',
            'slug' => 'original-category',
        ]);

        $response = $this->actingAs($this->editor)
            ->put(route('admin.categories.update', $category), [
                'name' => 'Compromised Category',
                'description' => 'Should not update.',
                'sort_order' => 0,
                'is_visible' => true,
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Original Category',
        ]);
    }

    public function test_admin_role_without_categories_manage_cannot_delete_category(): void
    {
        $category = Category::create([
            'name' => 'Original Category',
            'slug' => 'original-category',
        ]);

        $response = $this->actingAs($this->editor)
            ->delete(route('admin.categories.destroy', $category));

        $response->assertForbidden();
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
