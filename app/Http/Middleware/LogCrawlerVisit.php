<?php

namespace App\Http\Middleware;

use App\Models\CrawlerLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogCrawlerVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $userAgent = $request->header('User-Agent');
        if (!$userAgent) {
            return $response;
        }

        $botName = $this->detectBot($userAgent);

        if ($botName) {
            CrawlerLog::create([
                'bot_name'    => $botName,
                'user_agent'  => $userAgent,
                'ip_address'  => $request->ip(),
                'path'        => $request->path(),
                'status_code' => (string) $response->getStatusCode(),
            ]);
        }

        return $response;
    }

    private function detectBot(string $userAgent): ?string
    {
        $bots = [
            'GPTBot'           => 'OpenAI',
            'Google-Extended'  => 'Google',
            'PerplexityBot'    => 'Perplexity',
            'ClaudeBot'        => 'Anthropic',
            'anthropic-ai'     => 'Anthropic',
            'CCBot'            => 'Common Crawl',
            'FacebookBot'      => 'Meta',
            'Applebot-Extended'=> 'Apple',
            'Bytespider'       => 'Bytedance',
        ];

        foreach ($bots as $bot => $owner) {
            if (stripos($userAgent, $bot) !== false) {
                return $bot;
            }
        }

        return null;
    }
}
