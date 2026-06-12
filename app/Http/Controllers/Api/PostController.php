<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::published()->with(['user:id,name,avatar,slug', 'category:id,name,slug', 'tags:id,name,slug']);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        if ($request->filled('author')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('slug', $request->author);
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate($request->get('limit', 10));

        return response()->json($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post = Post::published()
            ->with([
                'user:id,name,avatar,bio,slug',
                'category:id,name,slug',
                'tags:id,name,slug',
                'comments' => function ($q) {
                    $q->where('status', 'approved')->orderBy('created_at', 'desc');
                },
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('view_count');

        return response()->json($post);
    }
}
