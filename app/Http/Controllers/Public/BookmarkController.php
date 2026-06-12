<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store($post)
    {
        if (!$post instanceof Post) {
            $post = Post::findOrFail($post);
        }

        Auth::user()->bookmarks()->firstOrCreate([
            'post_id' => $post->id,
        ]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Article bookmarked.']);
        }

        return back()->with('success', 'Article bookmarked.');
    }

    public function destroy($post)
    {
        if ($post instanceof Post) {
            $post = $post->id;
        }

        Auth::user()->bookmarks()->where('post_id', $post)->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Bookmark removed.']);
        }

        return back()->with('success', 'Bookmark removed.');
    }
}
