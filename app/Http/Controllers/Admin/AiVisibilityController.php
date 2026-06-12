<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrawlerLog;
use App\Services\AiVisibilityService;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class AiVisibilityController extends Controller
{
    public function index()
    {
        $bots = AiVisibilityService::getBots();
        $logs = CrawlerLog::latest()->limit(50)->get();
        $visibilityScore = AiVisibilityService::getVisibilityScore();
        $recommendations = AiVisibilityService::getRecommendations();
        $robotsTxt = AiVisibilityService::generateRobotsTxt();

        return view('admin.ai-visibility.index', compact(
            'bots', 
            'logs', 
            'visibilityScore', 
            'recommendations', 
            'robotsTxt'
        ));
    }

    public function update(Request $request)
    {
        if ($request->has('bot_id')) {
            $botId = $request->bot_id;
            $blockedBots = json_decode(SettingsService::get('ai_blocked_bots', '[]'), true);
            
            if (in_array($botId, $blockedBots)) {
                $blockedBots = array_diff($blockedBots, [$botId]);
            } else {
                $blockedBots[] = $botId;
            }
            
            SettingsService::set('ai_blocked_bots', json_encode(array_values($blockedBots)));
            
            return response()->json(['success' => true]);
        }

        if ($request->has('feature_id')) {
            $featureId = $request->feature_id;
            $settingKey = "ai_{$featureId}_enabled";
            $currentValue = SettingsService::get($settingKey, '1');
            $newValue = $currentValue === '1' ? '0' : '1';
            
            SettingsService::set($settingKey, $newValue);
            
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function clearLogs()
    {
        CrawlerLog::truncate();
        return redirect()->back()->with('success', 'Crawler logs cleared.');
    }
}
