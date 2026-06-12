<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Post;

class CalendarController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->select('id', 'title', 'status', 'published_at', 'scheduled_for', 'user_id', 'created_at')
            ->get()
            ->map(function ($post) {
                $date = $post->published_at ?? $post->scheduled_for ?? $post->created_at;
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'status' => $post->status,
                    'author' => $post->user->name ?? 'Editor',
                    'day' => (int)$date->format('j'),
                    'month' => (int)$date->format('n'),
                    'year' => (int)$date->format('Y'),
                ];
            });

        return view('admin.calendar.index', compact('posts'));
    }
}
