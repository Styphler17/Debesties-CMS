<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SEO\GenerateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use App\Services\PageLayoutCompiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Page::class);

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
        $this->authorize('create', Page::class);

        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $this->authorize('create', Page::class);

        $slug = (new GenerateSlug)->handle($request->input('title'), 'pages');

        $data = [
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'slug' => $slug,
            'body' => $request->input('body'),
            'status' => $request->input('status'),
        ];

        // If a layout JSON is provided, compile it into body HTML
        if ($request->filled('layout')) {
            $layoutJson = $request->input('layout');
            $layoutArray = json_decode($layoutJson, true);

            if (is_array($layoutArray)) {
                $data['layout'] = $layoutArray;
                $data['body'] = (new PageLayoutCompiler)->compile($layoutArray);
            }
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        $this->authorize('view', $page);

        return response()->json($page);
    }

    public function edit(Page $page)
    {
        $this->authorize('update', $page);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $this->authorize('update', $page);

        if ($page->title !== $request->input('title')) {
            $page->slug = (new GenerateSlug)->handle($request->input('title'), 'pages');
        }

        $page->title = $request->input('title');
        $page->status = $request->input('status');

        // If a layout JSON is provided, compile it into body HTML
        if ($request->filled('layout')) {
            $layoutJson = $request->input('layout');
            $layoutArray = json_decode($layoutJson, true);

            if (is_array($layoutArray)) {
                $page->layout = $layoutArray;
                $page->body = (new PageLayoutCompiler)->compile($layoutArray);
            }
        } else {
            // Traditional editor: use body directly, clear layout
            $page->body = $request->input('body');
            $page->layout = null;
        }

        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);

        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
