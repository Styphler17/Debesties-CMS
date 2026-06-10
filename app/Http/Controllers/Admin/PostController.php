<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Posts\CreatePost;
use App\Actions\Posts\DeletePost;
use App\Actions\Posts\PublishPost;
use App\Actions\Posts\SchedulePost;
use App\Actions\Posts\UpdatePost;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'meta'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(25)->withQueryString();

        $counts = [
            'all'       => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft'     => Post::where('status', 'draft')->count(),
            'review'    => Post::where('status', 'review')->count(),
            'scheduled' => Post::where('status', 'scheduled')->count(),
        ];

        $statusMeta = [
            'published' => ['label' => 'Published', 'bg' => 'var(--cms-green-soft)', 'color' => 'var(--cms-green-deep)'],
            'draft'     => ['label' => 'Draft',     'bg' => '#F0EDE8',               'color' => 'var(--cms-fg3)'],
            'review'    => ['label' => 'In Review', 'bg' => '#FFF6DD',               'color' => 'var(--cms-gold-deep)'],
            'scheduled' => ['label' => 'Scheduled', 'bg' => 'var(--cms-blue-soft)',  'color' => 'var(--cms-blue)'],
            'approved'  => ['label' => 'Approved',  'bg' => 'var(--cms-green-soft)', 'color' => 'var(--cms-green-deep)'],
            'archived'  => ['label' => 'Archived',  'bg' => '#F0EDE8',               'color' => 'var(--cms-fg3)'],
            'trash'     => ['label' => 'Trash',     'bg' => 'var(--cms-red-soft)',   'color' => 'var(--cms-red-deep)'],
        ];

        return view('admin.posts.index', compact('posts', 'counts', 'statusMeta'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();
        $users      = User::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'tags', 'users'));
    }

    public function store(StorePostRequest $request)
    {
        $post = (new CreatePost())->handle($request->validated(), auth()->user());

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        $tags       = Tag::orderBy('name')->get();
        $users      = User::orderBy('name')->get();

        $post->load(['tags', 'meta', 'category']);

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'users'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        (new UpdatePost())->handle($post, $request->validated());

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        (new DeletePost())->handle($post);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post moved to trash.');
    }

    public function publish(Post $post)
    {
        (new PublishPost())->handle($post);

        return redirect()
            ->back()
            ->with('success', 'Post published successfully.');
    }

    public function schedule(Request $request, Post $post)
    {
        $request->validate([
            'scheduled_for' => ['required', 'date', 'after:now'],
        ]);

        (new SchedulePost())->handle($post, $request->scheduled_for);

        return redirect()
            ->back()
            ->with('success', 'Post scheduled successfully.');
    }
}
