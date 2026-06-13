<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagAuthorizationTest extends TestCase
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

    public function test_admin_role_without_tags_manage_cannot_create_tag(): void
    {
        $response = $this->actingAs($this->editor)
            ->post(route('admin.tags.store'), [
                'name' => 'Restricted Tag',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('tags', ['slug' => 'restricted-tag']);
    }

    public function test_admin_role_without_tags_manage_cannot_update_tag(): void
    {
        $tag = Tag::create(['name' => 'Original Tag', 'slug' => 'original-tag']);

        $response = $this->actingAs($this->editor)
            ->put(route('admin.tags.update', $tag), [
                'name' => 'Compromised Tag',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'Original Tag',
        ]);
    }

    public function test_admin_role_without_tags_manage_cannot_delete_tag(): void
    {
        $tag = Tag::create(['name' => 'Original Tag', 'slug' => 'original-tag']);

        $response = $this->actingAs($this->editor)
            ->delete(route('admin.tags.destroy', $tag));

        $response->assertForbidden();
        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }
}
