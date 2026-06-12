<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Stats
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();
        $scheduledPosts = Post::where('status', 'scheduled')->count();
        $totalViews = Post::sum('view_count');
        $reviewCount = Post::where('status', 'review')->count();
        $pendingComments = Comment::where('status', 'pending')->count();

        // 2. Top Articles (last 7 days - or just overall top for now)
        $topArticles = Post::published()
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        // 3. Categories share
        $trendingCategories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(5)
            ->get();

        // 4. Recent Activity
        $activities = ActivityLog::with('user')
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard.index', compact(
            'user',
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'scheduledPosts',
            'totalViews',
            'reviewCount',
            'pendingComments',
            'topArticles',
            'trendingCategories',
            'activities'
        ));
    }
}
