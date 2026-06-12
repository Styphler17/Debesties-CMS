<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
            ->published()
            ->with(['category', 'user', 'featuredImage', 'tags'])
            ->latest('published_at')
            ->paginate(6);

        return view('public.author', compact('user', 'posts'));
    }
}
