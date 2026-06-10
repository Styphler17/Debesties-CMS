<?php

namespace Tests\Feature\Posts;

use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TagCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role        = Role::create(['name' => 'Super Admin', 'slug' => 'super_admin']);
        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($role);
    }

    public function test_admin_can_create_tag_with_auto_slug(): void
    {
        $this->actingAs($this->admin)->post(route('admin.tags.store'), [
            'name' => 'Ghana Music',
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'Ghana Music',
            'slug' => 'ghana-music',
        ]);
    }

    public function test_admin_can_update_tag_and_slug_regenerates(): void
    {
        $tag = Tag::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $this->actingAs($this->admin)->put(route('admin.tags.update', $tag), [
            'name' => 'New Name',
        ]);

        $this->assertDatabaseHas('tags', [
            'id'   => $tag->id,
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);
    }

    public function test_admin_can_delete_tag_and_pivot_rows_removed(): void
    {
        Queue::fake();

        $tag  = Tag::create(['name' => 'To Delete', 'slug' => 'to-delete']);
        $post = Post::create([
            'title'   => 'Tagged Post',
            'slug'    => 'tagged-post',
            'body'    => '<p>Body</p>',
            'user_id' => $this->admin->id,
            'status'  => 'draft',
        ]);
        $post->tags()->attach($tag->id);

        $this->assertDatabaseHas('post_tags', ['tag_id' => $tag->id, 'post_id' => $post->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.tags.destroy', $tag));

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
        $this->assertDatabaseMissing('post_tags', ['tag_id' => $tag->id]);
    }
}
