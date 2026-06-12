<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = Cache::remember('sitemap_xml', now()->addHour(), function () {
            $urls = [];

            // 1. Homepage
            $urls[] = [
                'loc' => route('home'),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ];

            // 2. Published Posts
            $posts = Post::published()->get();
            foreach ($posts as $post) {
                $urls[] = [
                    'loc' => route('posts.show', $post->slug),
                    'lastmod' => ($post->updated_at ?? $post->created_at ?? now())->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }

            // 3. Visible Categories
            $categories = Category::where('is_visible', true)->get();
            foreach ($categories as $category) {
                $urls[] = [
                    'loc' => route('categories.show', $category->slug),
                    'lastmod' => ($category->updated_at ?? $category->created_at ?? now())->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ];
            }

            // 4. Tags
            $tags = Tag::whereHas('posts', function ($query) {
                $query->published();
            })->get();
            foreach ($tags as $tag) {
                $urls[] = [
                    'loc' => route('tags.show', $tag->slug),
                    'lastmod' => ($tag->updated_at ?? $tag->created_at ?? now())->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.4',
                ];
            }

            // Build XML
            $xmlLines = [];
            $xmlLines[] = '<?xml version="1.0" encoding="UTF-8"?>';
            $xmlLines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($urls as $url) {
                $xmlLines[] = '  <url>';
                $xmlLines[] = '    <loc>' . htmlspecialchars($url['loc']) . '</loc>';
                $xmlLines[] = '    <lastmod>' . $url['lastmod'] . '</lastmod>';
                $xmlLines[] = '    <changefreq>' . $url['changefreq'] . '</changefreq>';
                $xmlLines[] = '    <priority>' . $url['priority'] . '</priority>';
                $xmlLines[] = '  </url>';
            }

            $xmlLines[] = '</urlset>';

            return implode("\n", $xmlLines);
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = \App\Services\AiVisibilityService::generateRobotsTxt();
        return response($content, 200)->header('Content-Type', 'text/plain');
    }

    public function llms()
    {
        if (\App\Services\SettingsService::get('ai_llms_txt_enabled', '1') !== '1') {
            abort(404);
        }

        $txt = Cache::remember('llms_txt', now()->addHour(), function () {
            $content = "# Debesties CMS\n\n";
            $content .= "A premium digital publishing and creative blog platform.\n\n";
            $content .= "## Essential Links\n\n";
            $content .= "- [Homepage](" . route('home') . ")\n";
            $content .= "- [Sitemap](" . route('sitemap') . ")\n\n";
            
            $content .= "## Recent Articles\n\n";
            $posts = Post::published()->latest()->limit(50)->get();
            foreach ($posts as $post) {
                $content .= "- [" . $post->title . "](" . route('posts.show', $post->slug) . ")\n";
            }
            
            return $content;
        });

        return response($txt, 200)->header('Content-Type', 'text/plain');
    }
}
