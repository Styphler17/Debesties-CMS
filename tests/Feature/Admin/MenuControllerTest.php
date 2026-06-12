<?php

namespace Tests\Feature\Admin;

use App\Models\Menu;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        $this->admin = User::whereHas('roles', fn ($q) => $q->where('slug', 'super_admin'))->first();
        $this->withoutMiddleware();
    }

    public function test_admin_can_view_menus_index()
    {
        Menu::create(['name' => 'Primary Menu', 'slug' => 'primary', 'location' => 'header']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.menus.index'));

        $response->assertStatus(200);
        $response->assertSee('Primary Menu');
    }

    public function test_admin_can_create_menu()
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.menus.store'), [
                'name' => 'Footer Menu',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('menus', ['name' => 'Footer Menu']);
    }

    public function test_admin_can_save_menu_items()
    {
        $this->withoutExceptionHandling();
        $menu = Menu::create(['name' => 'Main Menu', 'slug' => 'main']);

        $items = [
            [
                'title' => 'Home',
                'url' => '/',
                'order' => 0,
                'indent' => 0,
            ],
            [
                'title' => 'Blog',
                'url' => '/blog',
                'order' => 1,
                'indent' => 0,
            ],
            [
                'title' => 'Culture',
                'url' => '/category/culture',
                'order' => 2,
                'indent' => 1,
            ],
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.menus.items.store', $menu), [
                'items' => json_encode($items),
                'location' => 'header',
            ]);

        $response->assertStatus(200);
        $this->assertEquals('header', $menu->fresh()->location);
        $this->assertCount(3, $menu->items);
        $this->assertDatabaseHas('menu_items', [
            'menu_id' => $menu->id,
            'title' => 'Culture',
            'order' => 2,
            'target' => '1',
        ]);
    }
}
