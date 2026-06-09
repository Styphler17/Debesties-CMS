@extends('admin.layouts.app')

@section('title', 'Admin Dashboard — Debesties Studio')
@section('page_title', 'Dashboard')

@section('content')
@php
    // Inline sparkline generator helper
    if (!function_exists('renderSparkline')) {
        function renderSparkline($data, $color = '#E8A800', $width = 72, $height = 26) {
            $max = max($data);
            $min = min($data);
            $range = ($max - $min) ?: 1;
            $pts = [];
            $count = count($data);
            foreach($data as $i => $d) {
                $x = ($i / ($count - 1)) * $width;
                $y = $height - (($d - $min) / $range) * ($height - 4) - 2;
                $pts[] = sprintf('%.1f,%.1f', $x, $y);
            }
            $path = 'M' . implode(' L', $pts);
            $area = $path . " L{$width},{$height} L0,{$height} Z";
            $gradId = 'sg_' . rand(1000, 9999);
            
            return '
            <svg width="' . $width . '" height="' . $height . '" style="display: block;">
                <defs>
                    <linearGradient id="' . $gradId . '" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="' . $color . '" stop-opacity="0.22" />
                        <stop offset="100%" stop-color="' . $color . '" stop-opacity="0" />
                    </linearGradient>
                </defs>
                <path d="' . $area . '" fill="url(#' . $gradId . ')" />
                <path d="' . $path . '" fill="none" stroke="' . $color . '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>';
        }
    }

    // Static data representing template defaults
    $stats = [
        ['label' => 'Total Posts', 'value' => '248', 'delta' => '+12', 'deltaDir' => 'up', 'icon' => 'file-text', 'color' => 'var(--cms-gold)'],
        ['label' => 'Published', 'value' => '186', 'delta' => '+8', 'deltaDir' => 'up', 'icon' => 'check', 'color' => 'var(--cms-green)'],
        ['label' => 'Drafts', 'value' => '34', 'delta' => '+3', 'deltaDir' => 'up', 'icon' => 'edit-2', 'color' => 'var(--cms-blue)'],
        ['label' => 'Scheduled', 'value' => '9', 'delta' => null, 'deltaDir' => null, 'icon' => 'clock', 'color' => 'var(--cms-ai-to)'],
        ['label' => 'Total Views', 'value' => '1.24M', 'delta' => '+18%', 'deltaDir' => 'up', 'icon' => 'eye', 'color' => 'var(--cms-gold)'],
        ['label' => 'Avg. SEO Score', 'value' => '78', 'delta' => '+4', 'deltaDir' => 'up', 'icon' => 'gauge', 'color' => 'var(--cms-green)'],
    ];

    $quickActions = [
        ['label' => 'Write new post', 'icon' => 'pen-tool', 'color' => 'var(--cms-gold)', 'url' => route('admin.posts.create'), 'type' => 'quick'],
        ['label' => 'Upload media', 'icon' => 'upload', 'color' => 'var(--cms-blue)', 'url' => route('admin.media.index'), 'type' => 'quick'],
        ['label' => 'Review queue', 'icon' => 'list-checks', 'color' => 'var(--cms-green)', 'url' => route('admin.posts.index'), 'badge' => '2', 'type' => 'quick'],
        ['label' => 'AI Visibility', 'icon' => 'sparkles', 'color' => 'var(--cms-ai-to)', 'url' => route('admin.ai-visibility.index'), 'type' => 'ai'],
    ];

    $topArticles = [
        ['title' => 'The Elite Club: 4 Artists Who Dominated the TGMAs', 'views' => 48200, 'trend' => [12,18,15,22,28,35,48], 'up' => '+34%', 'is_up' => true],
        ['title' => 'Black Sherif’s Second Crown: Legacy Cemented', 'views' => 31400, 'trend' => [20,22,19,25,28,30,31], 'up' => '+12%', 'is_up' => true],
        ['title' => 'King Promise’s 2025 Win: A New Chapter for Highlife', 'views' => 22100, 'trend' => [28,26,24,22,20,21,22], 'up' => '−5%', 'is_up' => false],
        ['title' => 'Every Hiplife Winner That Defined an Era', 'views' => 18700, 'trend' => [10,12,14,15,16,18,18], 'up' => '+22%', 'is_up' => true],
        ['title' => 'Diana Hamilton & The Rise of Gospel at the TGMAs', 'views' => 14300, 'trend' => [8,9,11,12,13,14,14], 'up' => '+18%', 'is_up' => true],
    ];

    $decay = [
        ['title' => 'V.I.P: The Group That Started It All', 'drop' => '−42%', 'lastUpdate' => '3 weeks ago', 'reason' => 'Traffic decline + outdated stats'],
        ['title' => 'How TGMA Voting Works (2024 edition)', 'drop' => '−38%', 'lastUpdate' => '8 months ago', 'reason' => 'Superseded by 2026 rules'],
        ['title' => 'Top 10 Ghanaian Songs of 2023', 'drop' => '−29%', 'lastUpdate' => '14 months ago', 'reason' => 'Seasonal relevance lost'],
    ];

    $categories = [
        ['name' => 'Awards History', 'share' => 38, 'views' => '142K', 'color' => 'var(--cms-gold)'],
        ['name' => 'Profiles', 'share' => 27, 'views' => '98K', 'color' => 'var(--cms-green)'],
        ['name' => 'Analysis', 'share' => 19, 'views' => '71K', 'color' => 'var(--cms-blue)'],
        ['name' => 'Explainers', 'share' => 11, 'views' => '40K', 'color' => 'var(--cms-ai-to)'],
        ['name' => 'News', 'share' => 5, 'views' => '19K', 'color' => 'var(--cms-red)'],
    ];

    $activities = [
        ['who' => 'Ama Boateng', 'action' => 'published', 'target' => 'The Elite Club: 4 Artists Who Dominated…', 'time' => '2h ago', 'avatar' => 'AB', 'is_system' => false],
        ['who' => 'Yaw Owusu', 'action' => 'submitted for review', 'target' => 'The 2019 Annulment: What Really Happened?', 'time' => '3h ago', 'avatar' => 'YO', 'is_system' => false],
        ['who' => 'Kwesi Mensah', 'action' => 'updated', 'target' => 'Black Sherif’s Second Crown', 'time' => '5h ago', 'avatar' => 'KM', 'is_system' => false],
        ['who' => 'Esi Arthur', 'action' => 'left a comment on', 'target' => 'How TGMA Voting Actually Works', 'time' => '6h ago', 'avatar' => 'EA', 'is_system' => false],
        ['who' => 'Ama Boateng', 'action' => 'scheduled', 'target' => 'TGMA 2026: Full Winners List', 'time' => '1d ago', 'avatar' => 'AB', 'is_system' => false],
        ['who' => 'System', 'action' => 'flagged decay on', 'target' => 'V.I.P: The Group That Started It All', 'time' => '1d ago', 'avatar' => null, 'is_system' => true],
    ];
@endphp

<div style="display: flex; flex-direction: column; gap: 20px;">
    
    <!-- Greeting Banner -->
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <div style="background: linear-gradient(115deg, var(--cms-fg1) 0%, #2C2118 55%, var(--cms-gold-deep) 130%); padding: 26px 28px; display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.55); letter-spacing: 0.04em; margin-bottom: 6px;">
                    {{ today()->format('l, F j') }} · Good morning
                </div>
                <div style="font-family: var(--cms-font-disp); font-size: 26px; font-weight: 700; color: #fff; letter-spacing: -0.01em; line-height: 1.15;">
                    Welcome back, Ama 👋
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 13.5px; color: rgba(255,255,255,0.6); margin-top: 6px;">
                    You have <b style="color: var(--cms-gold);">2 posts in review</b> and <b style="color: var(--cms-gold);">3 articles</b> flagged for updates.
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.posts.create') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 7px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; padding: 9px 16px; height: 38px; background: var(--cms-gold); color: #1A1410; border: 1.5px solid transparent; border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;" onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                    <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2;"></i>
                    New Post
                </a>
                <a href="{{ route('admin.calendar.index') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 7px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; padding: 9px 16px; height: 38px; background: transparent; color: #fff; border: 1.5px solid rgba(255, 255, 255, 0.25); border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                    <i data-lucide="calendar" style="width: 16px; height: 16px; stroke-width: 2;"></i>
                    Calendar
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Grid -->
    <div class="cms-stat-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px;">
        @foreach($stats as $s)
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 18px; box-shadow: var(--cms-sh-card); transition: box-shadow 180ms, transform 180ms; cursor: default;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-raised)'" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--cms-sh-card)'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                    <div style="width: 38px; height: 38px; border-radius: var(--cms-r-md); display: flex; align-items: center; justify-content: center; background: {{ $s['color'] }}1A; color: {{ $s['color'] }};">
                        <i data-lucide="{{ $s['icon'] }}" style="width: 19px; height: 19px;"></i>
                    </div>
                    @if($s['delta'] !== null)
                        <span style="display: inline-flex; align-items: center; gap: 3px; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: {{ $s['deltaDir'] === 'down' ? 'var(--cms-red)' : 'var(--cms-green)' }};">
                            <i data-lucide="{{ $s['deltaDir'] === 'down' ? 'trending-down' : 'trending-up' }}" style="width: 14px; height: 14px; stroke-width: 2.2;"></i>
                            {{ $s['delta'] }}
                        </span>
                    @endif
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 27px; font-weight: 700; color: var(--cms-fg1); line-height: 1; letter-spacing: -0.02em;">
                    {{ $s['value'] }}
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3); margin-top: 6px; font-weight: 500;">
                    {{ $s['label'] }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions -->
    <div class="cms-qa-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px;">
        @foreach($quickActions as $qa)
            <a href="{{ $qa['url'] }}" style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 16px; box-shadow: var(--cms-sh-card); text-decoration: none; display: block; transition: box-shadow 180ms, transform 180ms;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-raised)'" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--cms-sh-card)'">
                <div style="display: flex; align-items: center; gap: 13px;">
                    <div style="width: 42px; height: 42px; border-radius: var(--cms-r-md); flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: {{ $qa['type'] === 'ai' ? 'linear-gradient(125deg, var(--cms-ai-from), var(--cms-ai-to))' : $qa['color'] . '1A' }}; color: {{ $qa['type'] === 'ai' ? '#fff' : $qa['color'] }};">
                        <i data-lucide="{{ $qa['icon'] }}" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $qa['label'] }}</div>
                        <div style="font-family: var(--cms-font-ui); font-size: 11.5px; color: var(--cms-fg4); margin-top: 1px;">Quick action</div>
                    </div>
                    @if(isset($qa['badge']))
                        <span style="display: inline-flex; align-items: center; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 600; background: var(--cms-gold-soft); color: var(--cms-gold-deep); padding: 3px 10px; border-radius: 999px;">
                            {{ $qa['badge'] }}
                        </span>
                    @endif
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: var(--cms-fg4);"></i>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Main Two-Column Layout -->
    <div class="cms-dash-cols" style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 20px; align-items: start;">
        
        <!-- LEFT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Top Articles Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--cms-border);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="flame" style="width: 18px; height: 18px; color: var(--cms-gold);"></i>
                        <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Top Articles</span>
                        <span style="font-family: var(--cms-font-ui); font-size: 11.5px; color: var(--cms-fg4); font-weight: 500;">· last 7 days</span>
                    </div>
                    <a href="{{ route('admin.analytics.index') }}" style="text-decoration: none; border: none; background: none; cursor: pointer; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-gold); display: flex; align-items: center; gap: 4px;" onmouseover="this.style.color='var(--cms-gold-deep)'" onmouseout="this.style.color='var(--cms-gold)'">
                        View all <i data-lucide="arrow-right" style="width: 13px; height: 13px; stroke-width: 2.2;"></i>
                    </a>
                </div>
                <div>
                    @foreach($topArticles as $index => $a)
                        <div style="display: flex; align-items: center; gap: 14px; padding: 13px 20px; border-bottom: {{ $index < count($topArticles) - 1 ? '1px solid var(--cms-border)' : 'none' }}; cursor: pointer;"
                             onmouseover="this.style.background='#FBF9F5'"
                             onmouseout="this.style.background='transparent'">
                            <span style="font-family: var(--cms-font-mono); font-size: 13px; font-weight: 700; color: var(--cms-fg4); width: 18px;">
                                {{ $index + 1 }}
                            </span>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $a['title'] }}
                                </div>
                                <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3); marginTop: 2px;">
                                    {{ number_format($a['views'] / 1000, 1) }}K views
                                </div>
                            </div>
                            <div style="flex-shrink: 0; width: 72px;">
                                {!! renderSparkline($a['trend'], $a['is_up'] ? 'var(--cms-green)' : 'var(--cms-red)') !!}
                            </div>
                            <span style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: {{ $a['is_up'] ? 'var(--cms-green)' : 'var(--cms-red)' }}; width: 48px; text-align: right;">
                                {{ $a['up'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Content Needing Updates Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--cms-border);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="alert-triangle" style="width: 17px; height: 17px; color: var(--cms-red);"></i>
                        <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Content Needing Updates</span>
                    </div>
                    <span style="display: inline-flex; align-items: center; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 600; background: var(--cms-red-soft); color: var(--cms-red-deep); padding: 3px 10px; border-radius: 999px;">
                        {{ count($decay) }} flagged
                    </span>
                </div>
                @foreach($decay as $index => $d)
                    <div style="display: flex; align-items: center; gap: 14px; padding: 13px 20px; border-bottom: {{ $index < count($decay) - 1 ? '1px solid var(--cms-border)' : 'none' }};">
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $d['title'] }}
                            </div>
                            <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3); margin-top: 2px;">
                                {{ $d['reason'] }} · updated {{ $d['lastUpdate'] }}
                            </div>
                        </div>
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-red); margin-right: 10px;">
                            {{ $d['drop'] }}
                        </span>
                        <a href="{{ route('admin.posts.index') }}" style="display: inline-flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; padding: 6px 12px; height: 32px; background: #FFFFFF; color: var(--cms-fg1); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='#FFFFFF'">
                            Update
                        </a>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Trending Categories Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <i data-lucide="trending-up" style="width: 17px; height: 17px; color: var(--cms-green);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Trending Categories</span>
                </div>
                <div style="display: flex; flex-direction: column; gap: 13px;">
                    @foreach($categories as $c)
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-fg2);">{{ $c['name'] }}</span>
                                <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3);">{{ $c['views'] }}</span>
                            </div>
                            <!-- Custom Progress bar -->
                            <div style="width: 100%; height: 6px; border-radius: 999px; background: var(--cms-border); overflow: hidden;">
                                <div style="width: {{ $c['share'] }}%; height: 100%; background: {{ $c['color'] }}; border-radius: 999px;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Search Traffic Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px;">
                    <i data-lucide="search" style="width: 17px; height: 17px; color: var(--cms-blue);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Search Traffic</span>
                </div>
                <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 4px;">
                    <span style="font-family: var(--cms-font-ui); font-size: 30px; font-weight: 700; color: var(--cms-fg1); letter-spacing: -0.02em;">21.6K</span>
                    <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-green); display: inline-flex; align-items: center; gap: 2px;">
                        <i data-lucide="trending-up" style="width: 14px; height: 14px; stroke-width: 2.2;"></i>
                        +14%
                    </span>
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3); margin-bottom: 14px;">Organic clicks this week</div>
                <!-- Mini Bar chart -->
                <div style="display: flex; align-items: flex-end; gap: 5px; height: 56px;">
                    @php
                        $bars = [40, 52, 46, 64, 58, 72, 68, 84, 78, 92, 88, 100];
                    @endphp
                    @foreach($bars as $index => $h)
                        <div style="flex: 1; height: {{ $h }}%; background: {{ $index >= 9 ? 'var(--cms-blue)' : 'rgba(47, 107, 216, 0.35)' }}; border-radius: 3px;"></div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
                <div style="padding: 16px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="clock" style="width: 17px; height: 17px; color: var(--cms-fg3);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Recent Activity</span>
                </div>
                <div style="padding: 4px 0;">
                    @foreach($activities as $a)
                        <div style="display: flex; gap: 11px; padding: 10px 20px;">
                            @if($a['is_system'])
                                <div style="width: 28px; height: 28px; border-radius: 999px; background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i data-lucide="alert-triangle" style="width: 14px; height: 14px; color: var(--cms-red);"></i>
                                </div>
                            @else
                                <!-- Initials Avatar -->
                                <div style="width: 28px; height: 28px; border-radius: 999px; background: rgba(74, 66, 54, 0.12); color: var(--cms-fg1); display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; flex-shrink: 0; border: 1px solid rgba(74, 66, 54, 0.2);">
                                    {{ $a['avatar'] }}
                                </div>
                            @endif
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg2); line-height: 1.45;">
                                    <b style="color: var(--cms-fg1); font-weight: 600;">{{ $a['who'] }}</b> {{ $a['action'] }}
                                    <span style="color: var(--cms-fg1); font-weight: 500;">
                                        {{ strlen($a['target']) > 32 ? substr($a['target'], 0, 32) . '…' : $a['target'] }}
                                    </span>
                                </div>
                                <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); margin-top: 1px;">
                                    {{ $a['time'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
