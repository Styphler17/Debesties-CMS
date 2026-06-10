<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SEO\GenerateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(50);

        $topLevel = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories', 'topLevel'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $slug = (new GenerateSlug())->handle($request->name, 'categories');

        Category::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
            'sort_order'  => $request->sort_order ?? 0,
            'is_visible'  => $request->boolean('is_visible', true),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $slug = $category->slug;

        if ($request->name !== $category->name) {
            $slug = (new GenerateSlug())->handle($request->name, 'categories');
        }

        $category->update([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
            'sort_order'  => $request->sort_order ?? 0,
            'is_visible'  => $request->boolean('is_visible', true),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0) {
            return redirect()
                ->back()
                ->withErrors(['category' => 'Cannot delete a category that has posts assigned to it.']);
        }

        // Reassign children to the category's parent (or null if top-level)
        $category->children()->update(['parent_id' => $category->parent_id]);

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }
}
