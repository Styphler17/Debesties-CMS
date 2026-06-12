<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('items')->get();
        $categories = Category::all();
        $pages = Page::all();
        $posts = Post::published()->get();

        return view('admin.menus.index', compact('menus', 'categories', 'pages', 'posts'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $menu = Menu::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'location' => 'none',
        ]);

        return response()->json([
            'success' => true,
            'menu' => $menu,
        ]);
    }

    public function saveItems(Request $request, $menu)
    {
        if (!$menu instanceof Menu) {
            $menu = Menu::findOrFail($menu);
        }

        $request->validate([
            'location' => 'nullable|string',
            'items' => 'required|json',
        ]);

        if ($request->filled('location')) {
            $menu->update(['location' => $request->location]);
        }

        $items = json_decode($request->items, true);

        // Simple approach: delete existing items and recreate
        // In a more complex scenario, we would use a library for nested sets or update existing items
        $menu->items()->delete();

        foreach ($items as $index => $item) {
            MenuItem::create([
                'menu_id' => $menu->id,
                'title' => $item['title'],
                'url' => $item['url'],
                'order' => $index,
                'parent_id' => null, // We are using target to store indentation for now as per the plan
                'target' => $item['indent'] ?? 0,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
