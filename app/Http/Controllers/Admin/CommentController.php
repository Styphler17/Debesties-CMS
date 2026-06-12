<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'post']);

        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', strtolower($request->status));
        }

        $comments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.comments.index', compact('comments'));
    }

    public function create()
    {
        return redirect()->route('admin.comments.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.comments.index');
    }

    public function show(string $id)
    {
        $comment = Comment::with(['user', 'post'])->findOrFail($id);
        return response()->json($comment);
    }

    public function edit(string $id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(UpdateCommentRequest $request, string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'comment' => $comment]);
        }

        return redirect()->route('admin.comments.index')->with('success', 'Comment updated successfully.');
    }

    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
        }

        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully.');
    }
}
