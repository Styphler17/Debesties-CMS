<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(StoreCommentRequest $request, $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Check if the user has a prior approved comment
        $hasApprovedComment = Comment::where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();

        $comment = new Comment;
        $comment->post_id = $post->id;
        $comment->user_id = $user->id;
        $comment->name = $user->name;
        $comment->email = $user->email;
        $comment->comment = $request->input('body');
        $comment->status = $hasApprovedComment ? 'approved' : 'pending';

        if ($request->filled('parent_id')) {
            $parent = Comment::where('post_id', $post->id)->findOrFail($request->input('parent_id'));
            $comment->parent_id = $parent->parent_id ?? $parent->id;
        }

        $comment->save();

        $message = $comment->status === 'approved'
            ? 'Your comment has been posted!'
            : 'Your comment is awaiting moderation.';

        return response()->json([
            'message' => $message,
            'comment' => $comment,
        ], 201);
    }
}
