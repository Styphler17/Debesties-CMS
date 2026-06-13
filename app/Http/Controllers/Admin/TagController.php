<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SEO\GenerateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Http\Requests\Admin\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Tag::class);

        $tags = Tag::withCount('posts')
            ->orderBy('name')
            ->paginate(50);

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        $this->authorize('create', Tag::class);

        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $this->authorize('create', Tag::class);

        $slug = (new GenerateSlug)->handle($request->name, 'tags');

        Tag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    public function show(Tag $tag)
    {
        $this->authorize('view', $tag);

        return view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);

        return view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $slug = $tag->slug;
        if ($request->name !== $tag->name) {
            $slug = (new GenerateSlug)->handle($request->name, 'tags');
        }

        $tag->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        $tag->posts()->detach();
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag deleted.');
    }
}
