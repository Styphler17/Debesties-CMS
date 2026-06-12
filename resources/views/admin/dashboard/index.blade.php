@extends('admin.layouts.app')

@section('title', 'Admin Dashboard — Debesties Studio')
@section('page_title', 'Dashboard')

@section('content')
@php
    // Inline sparkline generator helper
    if (!function_exists('renderSparkline')) {
        function renderSparkline($data, $color = '#E8A800', $width = 72, $height = 26) {
            $max = count($data) > 0 ? max($data) : 1;
            $min = count($data) > 0 ? min($data) : 0;
            $range = ($max - $min) ?: 1;
            $pts = [];
            $count = count($data);
            if ($count < 2) {
                return '<div style="font-size:10px; color:var(--cms-fg4); font-family:var(--cms-font-ui);">No trends</div>';
            }
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

    $stats = [
        ['label' => 'Total Posts', 'value' => $totalPosts, 'icon' => 'file-text', 'color' => 'var(--cms-gold)'],
        ['label' => 'Published', 'value' => $publishedPosts, 'icon' => 'check', 'color' => 'var(--cms-green)'],
        ['label' => 'Drafts', 'value' => $draftPosts, 'icon' => 'edit-2', 'color' => 'var(--cms-blue)'],
        ['label' => 'Scheduled', 'value' => $scheduledPosts, 'icon' => 'clock', 'color' => 'var(--cms-ai-to)'],
        ['label' => 'Total Views', 'value' => number_format($totalViews), 'icon' => 'eye', 'color' => 'var(--cms-gold)'],
        ['label' => 'Pending Comments', 'value' => $pendingComments, 'icon' => 'message-square', 'color' => 'var(--cms-red)'],
    ];

    $quickActions = [
        ['label' => 'Write new post', 'icon' => 'pen-tool', 'color' => 'var(--cms-gold)', 'url' => route('admin.posts.create'), 'type' => 'quick'],
        ['label' => 'Upload media', 'icon' => 'upload', 'color' => 'var(--cms-blue)', 'url' => route('admin.media.index'), 'type' => 'quick'],
        ['label' => 'Review queue', 'icon' => 'list-checks', 'color' => 'var(--cms-green)', 'url' => route('admin.posts.index', ['status' => 'review']), 'badge' => $reviewCount, 'type' => 'quick'],
        ['label' => 'AI Visibility', 'icon' => 'sparkles', 'color' => 'var(--cms-ai-to)', 'url' => route('admin.ai-visibility.index'), 'type' => 'ai'],
    ];
@endphp

<div style="display: flex; flex-direction: column; gap: 20px;">
    
    <!-- Greeting Banner -->
    <div class="cms-card" style="border: none; background: linear-gradient(115deg, var(--cms-fg1) 0%, #2C2118 55%, var(--cms-gold-deep) 130%);">
        <div style="padding: 28px 32px; display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.45); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 8px;">
                    {{ today()->format('l, F j') }} · Good morning
                </div>
                <div style="font-family: var(--cms-font-disp); font-size: 30px; font-weight: 700; color: #fff; letter-spacing: -0.01em; line-height: 1.1;">
                    Welcome back, {{ explode(' ', Auth::user()->name)[0] }} 👋
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 14px; color: rgba(255,255,255,0.6); margin-top: 8px;">
                    You have <b style="color: var(--cms-gold);">{{ $reviewCount }} posts in review</b> and <b style="color: var(--cms-gold);">{{ $pendingComments }} comments</b> awaiting approval.
                </div>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('admin.posts.create') }}" class="btn-primary">
                    <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2.2;"></i>
                    New Post
                </a>
                <a href="{{ route('admin.calendar.index') }}" class="btn-secondary" style="background: rgba(255,255,255,0.08); color: #fff; border-color: rgba(255,255,255,0.15);">
                    <i data-lucide="calendar" style="width: 16px; height: 16px;"></i>
                    Calendar
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Grid -->
    <div class="cms-stat-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 16px;">
        @foreach($stats as $s)
            <div class="cms-card" style="padding: 20px; transition: all 180ms ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-raised)'" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--cms-sh-card)'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: {{ $s['color'] }}14; color: {{ $s['color'] }};">
                        <i data-lucide="{{ $s['icon'] }}" style="width: 20px; height: 20px;"></i>
                    </div>
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 28px; font-weight: 700; color: var(--cms-fg1); line-height: 1; letter-spacing: -0.02em;">
                    {{ $s['value'] }}
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); margin-top: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                    {{ $s['label'] }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions -->
    <div class="cms-qa-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
        @foreach($quickActions as $qa)
            <a href="{{ $qa['url'] }}" class="cms-card" style="padding: 16px; text-decoration: none; display: block; transition: all 180ms ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-raised)'" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--cms-sh-card)'">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: {{ $qa['type'] === 'ai' ? 'linear-gradient(125deg, var(--cms-ai-from), var(--cms-ai-to))' : $qa['color'] . '14' }}; color: {{ $qa['type'] === 'ai' ? '#fff' : $qa['color'] }};">
                        <i data-lucide="{{ $qa['icon'] }}" style="width: 21px; height: 21px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">{{ $qa['label'] }}</div>
                        <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); margin-top: 1px;">Quick access</div>
                    </div>
                    @if(isset($qa['badge']) && $qa['badge'] > 0)
                        <span class="badge badge-warning" style="padding: 2px 8px; font-size: 10px;">
                            {{ $qa['badge'] }}
                        </span>
                    @endif
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: var(--cms-border-st);"></i>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Main Two-Column Layout -->
    <div class="cms-dash-cols" style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 20px; align-items: start;">
        
        <!-- LEFT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Top Articles Card -->
            <div class="cms-card">
                <div class="cms-card-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="flame" style="width: 18px; height: 18px; color: var(--cms-gold);"></i>
                        <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Top Articles</span>
                    </div>
                    <a href="{{ route('admin.analytics.index') }}" style="text-decoration: none; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-gold); display: flex; align-items: center; gap: 4px;" onmouseover="this.style.color='var(--cms-gold-deep)'" onmouseout="this.style.color='var(--cms-gold)'">
                        View all <i data-lucide="arrow-right" style="width: 13px; height: 13px; stroke-width: 2.2;"></i>
                    </a>
                </div>
                <div>
                    @forelse($topArticles as $index => $a)
                        <a href="{{ route('admin.posts.edit', $a) }}" style="display: flex; align-items: center; gap: 16px; padding: 14px 20px; border-bottom: {{ $index < count($topArticles) - 1 ? '1px solid var(--cms-border)' : 'none' }}; cursor: pointer; text-decoration: none;"
                             onmouseover="this.style.background='#FBF9F5'"
                             onmouseout="this.style.background='transparent'">
                            <span style="font-family: var(--cms-font-mono); font-size: 13px; font-weight: 700; color: var(--cms-fg4); width: 18px; text-align: center;">
                                {{ $index + 1 }}
                            </span>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $a->title }}
                                </div>
                                <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3); margin-top: 2px;">
                                    {{ number_format($a->view_count) }} views
                                </div>
                            </div>
                            <div style="flex-shrink: 0; width: 72px;">
                                {!! renderSparkline([$a->view_count*0.85, $a->view_count*0.9, $a->view_count], 'var(--cms-green)') !!}
                            </div>
                        </a>
                    @empty
                        <div style="padding: 48px 20px; text-align: center; color: var(--cms-fg4); font-family: var(--cms-font-ui); font-size: 13.5px;">No top articles yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="cms-card">
                <div class="cms-card-header">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="clock" style="width: 17px; height: 17px; color: var(--cms-fg3);"></i>
                        <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Recent Activity</span>
                    </div>
                </div>
                <div style="padding: 8px 0;">
                    @forelse($activities as $a)
                        <div style="display: flex; gap: 14px; padding: 12px 20px;">
                            @php
                                $initials = collect(explode(' ', $a->user->name ?? 'System'))->map(fn($n) => substr($n, 0, 1))->join('');
                            @endphp
                            <div style="width: 32px; height: 32px; border-radius: 999px; background: var(--cms-bg); color: var(--cms-fg1); display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; flex-shrink: 0; border: 1.5px solid var(--cms-border);">
                                {{ $initials }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2); line-height: 1.5;">
                                    <b style="color: var(--cms-fg1); font-weight: 700;">{{ $a->user->name ?? 'System' }}</b> 
                                    {{ str_replace('.', ' ', $a->action) }}
                                </div>
                                <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); margin-top: 3px;">
                                    {{ $a->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 48px 20px; text-align: center; color: var(--cms-fg4); font-family: var(--cms-font-ui); font-size: 13.5px;">No recent activity.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Trending Categories Card -->
            <div class="cms-card" style="padding: 24px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                    <i data-lucide="trending-up" style="width: 17px; height: 17px; color: var(--cms-green);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Trending Categories</span>
                </div>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @php
                        $colors = ['var(--cms-gold)', 'var(--cms-green)', 'var(--cms-blue)', 'var(--cms-ai-to)', 'var(--cms-red)'];
                    @endphp
                    @forelse($trendingCategories as $index => $c)
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg2);">{{ $c->name }}</span>
                                <span style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 600; color: var(--cms-fg4);">{{ $c->posts_count }} posts</span>
                            </div>
                            <!-- Custom Progress bar -->
                            <div style="width: 100%; height: 6px; border-radius: 999px; background: #EEEAE4; overflow: hidden;">
                                <div style="width: {{ $totalPosts > 0 ? ($c->posts_count / $totalPosts) * 100 : 0 }}%; height: 100%; background: {{ $colors[$index % 5] }}; border-radius: 999px;"></div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 20px 0; text-align: center; color: var(--cms-fg4); font-family: var(--cms-font-ui); font-size: 13px;">No categories.</div>
                    @endforelse
                </div>
            </div>

            <!-- Search Traffic Card (Mocked for now) -->
            <div class="cms-card" style="padding: 24px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <i data-lucide="search" style="width: 17px; height: 17px; color: var(--cms-blue);"></i>
                    <span style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Organic Reach</span>
                </div>
                <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 6px;">
                    <span style="font-family: var(--cms-font-ui); font-size: 32px; font-weight: 700; color: var(--cms-fg1); letter-spacing: -0.02em;">{{ number_format($totalViews / 12) }}</span>
                    <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 800; color: var(--cms-green); display: inline-flex; align-items: center; gap: 2px;">
                        <i data-lucide="trending-up" style="width: 14px; height: 14px; stroke-width: 2.5;"></i>
                        +14.2%
                    </span>
                </div>
                <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3); margin-bottom: 18px; font-weight: 500;">Estimated weekly organic impact</div>
                <!-- Mini Bar chart -->
                <div style="display: flex; align-items: flex-end; gap: 5px; height: 60px;">
                    @php
                        $bars = [40, 52, 46, 64, 58, 72, 68, 84, 78, 92, 88, 100];
                    @endphp
                    @foreach($bars as $index => $h)
                        <div style="flex: 1; height: {{ $h }}%; background: {{ $index >= 9 ? 'var(--cms-blue)' : 'rgba(47, 107, 216, 0.22)' }}; border-radius: 4px;"></div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
