<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Menu::class);

        $menus = Menu::with('items')->get();
        $categories = Category::all();
        $pages = Page::published()->get();
        $posts = Post::published()->get();

        return view('admin.menus.index', compact('menus', 'categories', 'pages', 'posts'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Menu::class);

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
        if (! $menu instanceof Menu) {
            $menu = Menu::findOrFail($menu);
        }

        $this->authorize('update', $menu);

        $request->validate([
            'location' => 'nullable|string',
            'items' => 'required|json',
        ]);

        $oldLocation = $menu->location;

        if ($request->filled('location')) {
            $menu->update(['location' => $request->location]);
        }

        $items = json_decode($request->items, true);

        // Simple approach: delete existing items and recreate
        $menu->items()->delete();

        foreach ($items as $index => $item) {
            MenuItem::create([
                'menu_id' => $menu->id,
                'title' => $item['title'],
                'url' => $item['url'],
                'order' => $index,
                'parent_id' => null, // Simplified flat tree representation with indentation layout support
                'target' => $item['indent'] ?? 0, // Map indentation level into target column
            ]);
        }

        // Bust cache for both old location and new location
        Cache::forget("menu:location:{$oldLocation}");
        Cache::forget("menu:location:{$menu->location}");

        return response()->json(['success' => true]);
    }
}
