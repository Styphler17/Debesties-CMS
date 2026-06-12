<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$request->has('q') || strlen($query) < 2) {
            return redirect()->back()->with('error', 'Search query must be at least 2 characters.');
        }

        $posts = Post::published()
            ->with(['category', 'user', 'featuredImage', 'tags'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('body', 'like', '%' . $query . '%');
            })
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        return view('public.search', compact('posts', 'query'));
    }
}
