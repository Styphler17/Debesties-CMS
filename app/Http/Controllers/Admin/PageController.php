<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SEO\GenerateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query()->with('user');

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', strtolower($request->status));
        }

        $pages = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $slug = (new GenerateSlug)->handle($request->input('title'), 'pages');

        Page::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'slug' => $slug,
            'body' => $request->input('body'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        return response()->json($page);
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        if ($page->title !== $request->input('title')) {
            $page->slug = (new GenerateSlug)->handle($request->input('title'), 'pages');
        }

        $page->title = $request->input('title');
        $page->body = $request->input('body');
        $page->status = $request->input('status');
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
