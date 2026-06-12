<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->published()
            ->with(['category', 'user', 'featuredImage', 'tags'])
            ->latest('published_at')
            ->paginate(6);

        return view('public.tag', compact('tag', 'posts'));
    }
}
