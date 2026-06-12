<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the user's bookmarked posts.
     */
    public function index()
    {
        $posts = auth()->user()
            ->bookmarkedPosts()
            ->published()
            ->with(['user:id,name,avatar,slug', 'category:id,name,slug'])
            ->paginate(10);

        return response()->json($posts);
    }

    /**
     * Toggle bookmark for the specified post.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        $user = auth()->user();
        $postId = $request->post_id;

        $exists = $user->bookmarks()->where('post_id', $postId)->exists();

        if ($exists) {
            $user->bookmarks()->where('post_id', $postId)->delete();

            return response()->json([
                'bookmarked' => false,
                'message' => 'Bookmark removed.',
            ]);
        }

        $user->bookmarks()->create([
            'post_id' => $postId,
        ]);

        return response()->json([
            'bookmarked' => true,
            'message' => 'Bookmark added.',
        ]);
    }
}
