<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\SettingsService;

class HomeController extends Controller
{
    public function index()
    {
        $layoutJson = SettingsService::get('homepage_layout');
        $layoutData = $layoutJson ? json_decode($layoutJson, true) : null;

        if (is_array($layoutData) && count($layoutData) > 0) {
            $widgets = [];
            foreach ($layoutData as $widget) {
                $type = $widget['type'] ?? '';
                $settings = $widget['settings'] ?? [];
                
                $widgetData = [
                    'type' => $type,
                    'settings' => $settings,
                ];

                if ($type === 'grid') {
                    $limit = isset($settings['limit']) ? intval($settings['limit']) : 6;
                    $catSlug = $settings['category'] ?? 'all';
                    
                    $query = Post::published()
                        ->with(['category', 'user', 'featuredImage', 'tags'])
                        ->latest('published_at');
                        
                    if ($catSlug !== 'all') {
                        $query->whereHas('category', function ($q) use ($catSlug) {
                            $q->where('slug', $catSlug);
                        });
                    }
                    
                    $widgetData['posts'] = $query->limit($limit)->get();
                } elseif ($type === 'categories') {
                    $widgetData['categories'] = \App\Models\Category::where('is_visible', true)
                        ->orderBy('sort_order')
                        ->get();
                } elseif ($type === 'strip') {
                    $limit = isset($settings['items']) ? intval($settings['items']) : 5;
                    $widgetData['posts'] = Post::published()
                        ->with(['category'])
                        ->latest('published_at')
                        ->limit($limit)
                        ->get();
                }
                
                $widgets[] = $widgetData;
            }

            return view('public.home', compact('widgets'));
        }

        // Default layout fallback
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
