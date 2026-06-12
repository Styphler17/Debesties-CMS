<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        if (! $category->is_visible) {
            abort(404);
        }

        $posts = $category->posts()
            ->published()
            ->with(['category', 'user', 'featuredImage', 'tags'])
            ->latest('published_at')
            ->paginate(6);

        return view('public.category', compact('category', 'posts'));
    }
}
