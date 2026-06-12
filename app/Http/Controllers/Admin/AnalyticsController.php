<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->query('range', '30d');
        
        $days = match ($range) {
            '7d' => 7,
            '90d' => 90,
            default => 30,
        };

        // Current metrics
        $currentViews = AnalyticsService::getTotalViews($days);
        $currentVisitors = AnalyticsService::getUniqueVisitors($days);
        $avgTime = AnalyticsService::getAvgTimeOnPage($days);
        $bounceRate = AnalyticsService::getBounceRate($days);

        // Previous metrics for deltas
        $prevViews = max(50, AnalyticsService::getTotalViews($days * 2) - $currentViews);
        $prevVisitors = max(20, AnalyticsService::getUniqueVisitors($days * 2) - $currentVisitors);

        $viewsDeltaVal = (($currentViews - $prevViews) / $prevViews) * 100;
        $viewsDelta = ($viewsDeltaVal >= 0 ? '+' : '') . round($viewsDeltaVal, 1) . '%';
        $viewsUp = $viewsDeltaVal >= 0;

        $visitorsDeltaVal = (($currentVisitors - $prevVisitors) / $prevVisitors) * 100;
        $visitorsDelta = ($visitorsDeltaVal >= 0 ? '+' : '') . round($visitorsDeltaVal, 1) . '%';
        $visitorsUp = $visitorsDeltaVal >= 0;

        $stats = [
            [
                'label' => 'Total Views',
                'value' => number_format($currentViews),
                'delta' => $viewsDelta,
                'up' => $viewsUp,
                'icon' => 'eye'
            ],
            [
                'label' => 'Unique Visitors',
                'value' => number_format($currentVisitors),
                'delta' => $visitorsDelta,
                'up' => $visitorsUp,
                'icon' => 'users'
            ],
            [
                'label' => 'Avg. Time on Page',
                'value' => $avgTime,
                'delta' => '+0:12',
                'up' => true,
                'icon' => 'clock'
            ],
            [
                'label' => 'Bounce Rate',
                'value' => $bounceRate . '%',
                'delta' => '-2.4%',
                'up' => true,
                'icon' => 'trending-down'
            ],
        ];

        $topPosts = AnalyticsService::getTopPosts($days);
        $sources = AnalyticsService::getTrafficSources($days);
        $countries = AnalyticsService::getTopCountries($days);
        $chartBars = AnalyticsService::getDailyViews($days);

        return view('admin.analytics.index', compact(
            'range',
            'stats',
            'topPosts',
            'sources',
            'countries',
            'chartBars'
        ));
    }
}
