<?php

namespace Tests\Feature\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($role);
    }

    public function test_admin_can_create_category_with_auto_slug(): void
    {
        $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Music Awards',
            'sort_order' => 1,
            'is_visible' => true,
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Music Awards',
            'slug' => 'music-awards',
        ]);
    }

    public function test_cannot_delete_category_that_has_posts(): void
    {
        Queue::fake();

        $category = Category::create(['name' => 'Busy Cat', 'slug' => 'busy-cat']);

        Post::create([
            'title' => 'A Post',
            'slug' => 'a-post',
            'body' => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.categories.destroy', $category));

        $response->assertSessionHasErrors('category');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_deleting_category_reassigns_children_to_grandparent(): void
    {
        $grandparent = Category::create(['name' => 'Top Level', 'slug' => 'top-level']);
        $parent = Category::create(['name' => 'Middle', 'slug' => 'middle', 'parent_id' => $grandparent->id]);
        $child = Category::create(['name' => 'Leaf', 'slug' => 'leaf', 'parent_id' => $parent->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.categories.destroy', $parent));

        $child->refresh();
        $this->assertSame($grandparent->id, $child->parent_id);
        $this->assertSoftDeleted('categories', ['id' => $parent->id]);
    }
}
