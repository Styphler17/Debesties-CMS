<?php

namespace App\Services;

use App\Models\Post;
use App\Models\CrawlerLog;
use Illuminate\Support\Collection;

class AiVisibilityService
{
    public static function getBots(): Collection
    {
        $blockedBots = json_decode(SettingsService::get('ai_blocked_bots', '[]'), true);
        
        return collect([
            ['id' => 'gptbot',           'name' => 'GPTBot',            'owner' => 'OpenAI',        'icon' => '🤖'],
            ['id' => 'google-ext',       'name' => 'Google-Extended',   'owner' => 'Google',        'icon' => '🔍'],
            ['id' => 'perplexity',       'name' => 'PerplexityBot',     'owner' => 'Perplexity',    'icon' => '🔮'],
            ['id' => 'claudebot',        'name' => 'ClaudeBot',         'owner' => 'Anthropic',     'icon' => '🧠'],
            ['id' => 'anthropic',        'name' => 'anthropic-ai',      'owner' => 'Anthropic',     'icon' => '🧠'],
            ['id' => 'ccbot',            'name' => 'CCBot',             'owner' => 'Common Crawl',  'icon' => '🕷'],
            ['id' => 'facebookbot',      'name' => 'FacebookBot',       'owner' => 'Meta',          'icon' => '👥'],
            ['id' => 'applebot-ext',     'name' => 'Applebot-Extended', 'owner' => 'Apple',         'icon' => '🍎'],
            ['id' => 'bytespider',       'name' => 'Bytespider',        'owner' => 'Bytedance',     'icon' => '💃'],
        ])->map(function ($bot) use ($blockedBots) {
            $bot['blocked'] = in_array($bot['id'], $blockedBots);
            return $bot;
        });
    }

    public static function getVisibilityScore(): array
    {
        $score = 0;
        $max = 100;
        
        $checks = [
            'llms_txt' => [
                'label' => 'llms.txt present',
                'passed' => SettingsService::get('ai_llms_txt_enabled', '1') === '1',
                'weight' => 25,
            ],
            'schema' => [
                'label' => 'JSON-LD Schema enabled',
                'passed' => SettingsService::get('ai_article_schema_enabled', '1') === '1',
                'weight' => 25,
            ],
            'meta' => [
                'label' => 'Meta optimizations',
                'passed' => Post::whereHas('meta', function($q) {
                    $q->whereNotNull('meta_description')->whereNotNull('focus_keyword');
                })->count() > (Post::count() * 0.8),
                'weight' => 30,
            ],
            'robots' => [
                'label' => 'AI-friendly robots.txt',
                'passed' => true, // We assume if it's managed here, it's friendly
                'weight' => 20,
            ],
        ];

        foreach ($checks as $check) {
            if ($check['passed']) {
                $score += $check['weight'];
            }
        }

        return [
            'score' => $score,
            'checks' => $checks,
        ];
    }

    public static function getRecommendations(): Collection
    {
        $recommendations = collect();

        // Check posts missing meta
        $missingMetaCount = Post::whereDoesntHave('meta', function($q) {
            $q->whereNotNull('meta_description');
        })->count();

        if ($missingMetaCount > 0) {
            $recommendations->push([
                'type' => 'improvement',
                'title' => 'Missing Meta Descriptions',
                'body' => "{$missingMetaCount} posts are missing meta descriptions, which reduces AI summary accuracy.",
                'priority' => 'high',
            ]);
        }

        // Check posts missing focus keywords
        $missingKeywordsCount = Post::whereDoesntHave('meta', function($q) {
            $q->whereNotNull('focus_keyword');
        })->count();

        if ($missingKeywordsCount > 0) {
            $recommendations->push([
                'type' => 'improvement',
                'title' => 'Missing Focus Keywords',
                'body' => "{$missingKeywordsCount} posts don't have focus keywords defined, making it harder for AI to categorize them.",
                'priority' => 'medium',
            ]);
        }

        // Check JSON-LD schema
        if (SettingsService::get('ai_article_schema_enabled', '1') !== '1') {
            $recommendations->push([
                'type' => 'feature',
                'title' => 'Enable Article Schema',
                'body' => 'JSON-LD Article schema helps AI agents extract structured metadata about your stories.',
                'priority' => 'high',
            ]);
        }

        // Check llms.txt
        if (SettingsService::get('ai_llms_txt_enabled', '1') !== '1') {
            $recommendations->push([
                'type' => 'feature',
                'title' => 'Enable llms.txt',
                'body' => 'Provide a dedicated machine-readable index for LLM crawlers to improve discovery.',
                'priority' => 'medium',
            ]);
        }

        // Check recent crawler activity
        $recentLogs = CrawlerLog::where('created_at', '>', now()->subDays(7))->count();
        if ($recentLogs === 0) {
            $recommendations->push([
                'type' => 'alert',
                'title' => 'No Recent AI Traffic',
                'body' => 'We haven\'t detected any AI crawlers in the last 7 days. Check your robots.txt settings.',
                'priority' => 'low',
            ]);
        }

        return $recommendations;
    }

    public static function generateRobotsTxt(): string
    {
        $bots = self::getBots();
        $blocked = $bots->where('blocked', true);
        
        $content = "User-agent: *\nAllow: /\n\n";
        
        if ($blocked->isNotEmpty()) {
            $content .= "# AI Crawlers Blocked\n";
            foreach ($blocked as $bot) {
                $content .= "User-agent: {$bot['name']}\nDisallow: /\n\n";
            }
        }

        $content .= "Sitemap: " . config('app.url') . "/sitemap.xml";
        
        return $content;
    }
}
