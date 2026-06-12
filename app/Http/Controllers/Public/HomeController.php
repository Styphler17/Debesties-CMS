<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPost = Post::published()
            ->with(['category', 'user', 'featuredImage', 'tags'])
            ->latest('published_at')
            ->first();

        $posts = Post::published()
            ->with(['category', 'user', 'featuredImage', 'tags'])
            ->when($featuredPost, function ($query) use ($featuredPost) {
                return $query->where('id', '!=', $featuredPost->id);
            })
            ->latest('published_at')
            ->paginate(6);

        return view('public.home', compact('featuredPost', 'posts'));
    }
}
