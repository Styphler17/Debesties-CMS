@extends('admin.layouts.app')

@section('title', 'Admin Dashboard — Debesties Studio')
@section('page_title', 'Dashboard')
@section('content')

<style>
    .dashboard-stat-icon {
        width: 38px;
        height: 38px;
        border-radius: var(--cms-r-md);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dashboard-qa-icon {
        width: 42px;
        height: 42px;
        border-radius: var(--cms-r-md);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dashboard-qa-icon--ai {
        background: linear-gradient(125deg, var(--cms-ai-from), var(--cms-ai-to));
        color: #fff;
    }
    .dashboard-article-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 20px;
        cursor: pointer;
        text-decoration: none;
    }
    .dashboard-article-link--border {
        border-bottom: 1px solid var(--cms-border);
    }
    .dashboard-category-progress {
        height: 100%;
        border-radius: 999px;
    }
    .dashboard-bar {
        flex: 1;
        border-radius: 3px;
    }
</style>

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
                return '<div style="font-size: 10px; color: var(--cms-fg4); font-family: var(--cms-font-ui), sans-serif;">No data</div>';
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

    $decay = [
        ['title' => 'Sample Article: Traffic Decline', 'drop' => '−12%', 'last_update' => '1 week ago', 'reason' => 'Lower CTR'],
    ];
@endphp

<div style="display: flex; flex-direction: column; gap: 20px;">
    
    <!-- Greeting Banner -->
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        @php
            $banner_grad = "background: linear-gradient(115deg, var(--cms-fg1) 0%, #2C2118 55%, var(--cms-gold-deep) 130%); padding: 26px 28px; display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;";
            $date_style = "font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.55); letter-spacing: 0.04em; margin-bottom: 6px;";
            $welcome_style = "font-family: var(--cms-font-disp), serif; font-size: 26px; font-weight: 700; color: #fff; letter-spacing: -0.01em; line-height: 1.15;";
            $status_summary_style = "font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: rgba(255,255,255,0.6); margin-top: 6px;";
            $btn_gold = "display: inline-flex; align-items: center; justify-content: center; gap: 7px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; padding: 9px 16px; height: 38px; background: var(--cms-gold); color: #1A1410; border: 1.5px solid transparent; border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;";
            $btn_outline = "display: inline-flex; align-items: center; justify-content: center; gap: 7px; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; padding: 9px 16px; height: 38px; background: transparent; color: #fff; border: 1.5px solid rgba(255, 255, 255, 0.25); border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none;";
        @endphp
        <div @style([$banner_grad])>
            <div>
                <div @style([$date_style])>
                    {{ today()->format('l, F j') }} · Good morning
                </div>
                <div @style([$welcome_style])>
                    Welcome back, {{ explode(' ', $user->name)[0] }} 👋
                </div>
                <div @style([$status_summary_style])>
                    You have <b style="color: var(--cms-gold);">{{ $reviewCount }} posts in review</b> and <b style="color: var(--cms-gold);">{{ $pendingComments }} comments</b> awaiting approval.
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.posts.create') }}" @style([$btn_gold]) onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                    <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2;"></i>
                    New Post
                </a>
                <a href="{{ route('admin.calendar.index') }}" @style([$btn_outline]) onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                    <i data-lucide="calendar" style="width: 16px; height: 16px; stroke-width: 2;"></i>
                    Calendar
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Grid -->
    @php $grid_6 = "display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px;"; @endphp
    <div class="cms-stat-grid" @style([$grid_6])>
        @foreach($stats as $s)
            @php
                $stat_card = "background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 18px; box-shadow: var(--cms-sh-card); transition: box-shadow 180ms, transform 180ms; cursor: default;";
                $val_style = "font-family: var(--cms-font-ui), sans-serif; font-size: 27px; font-weight: 700; color: var(--cms-fg1); line-height: 1; letter-spacing: -0.02em;";
                $lbl_style = "font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-fg3); margin-top: 6px; font-weight: 500;";
                $icon_style = "background: {$s['color']}1A; color: {$s['color']};";
            @endphp
            <div @style([$stat_card]) onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-raised)'" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--cms-sh-card)'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                    <div class="dashboard-stat-icon" @style([$icon_style])>
                        <i data-lucide="{{ $s['icon'] }}" style="width: 19px; height: 19px;"></i>
                    </div>
                </div>
                <div @style([$val_style])>
                    {{ $s['value'] }}
                </div>
                <div @style([$lbl_style])>
                    {{ $s['label'] }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions -->
    @php $grid_4 = "display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px;"; @endphp
    <div class="cms-qa-grid" @style([$grid_4])>
        @foreach($quickActions as $qa)
            @php 
                $qa_icon_bg = ($qa['type'] !== 'ai') ? "background: {$qa['color']}1A; color: {$qa['color']};" : "";
                $qa_card = "background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 16px; box-shadow: var(--cms-sh-card); text-decoration: none; display: block; transition: box-shadow 180ms, transform 180ms;";
                $qa_lbl = "font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);";
                $qa_sub = "font-family: var(--cms-font-ui), sans-serif; font-size: 11.5px; color: var(--cms-fg4); margin-top: 1px;";
            @endphp
            <a href="{{ $qa['url'] }}" @style([$qa_card]) onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='var(--cms-sh-raised)'" onmouseout="this.style.transform='none'; this.style.boxShadow='var(--cms-sh-card)'">
                <div style="display: flex; align-items: center; gap: 13px;">
                    <div @class(['dashboard-qa-icon', 'dashboard-qa-icon--ai' => $qa['type'] === 'ai']) @style([$qa_icon_bg])>
                        <i data-lucide="{{ $qa['icon'] }}" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div @style([$qa_lbl])>{{ $qa['label'] }}</div>
                        <div @style([$qa_sub])>Quick action</div>
                    </div>
                    @if(isset($qa['badge']) && $qa['badge'] > 0)
                        <span @style([
                            'display: inline-flex',
                            'align-items: center',
                            'font-family: var(--cms-font-ui), sans-serif',
                            'font-size: 11.5px',
                            'font-weight: 600',
                            'background: var(--cms-gold-soft)',
                            'color: var(--cms-gold-deep)',
                            'padding: 3px 10px',
                            'border-radius: 999px',
                        ])>
                            {{ $qa['badge'] }}
                        </span>
                    @endif
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: var(--cms-fg4);"></i>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Main Two-Column Layout -->
    @php $grid_dash = "display: grid; grid-template-columns: 1.6fr 1fr; gap: 20px; align-items: start;"; @endphp
    <div class="cms-dash-cols" @style([$grid_dash])>
        
        <!-- LEFT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Top Articles Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--cms-border);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="flame" style="width: 18px; height: 18px; color: var(--cms-gold);"></i>
                        <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 15px', 'font-weight: 700', 'color: var(--cms-fg1)'])>Top Articles</span>
                    </div>
                    <a href="{{ route('admin.analytics.index') }}" 
                       @style([
                            'text-decoration: none',
                            'border: none',
                            'background: none',
                            'cursor: pointer',
                            'font-family: var(--cms-font-ui), sans-serif',
                            'font-size: 12.5px',
                            'font-weight: 600',
                            'color: var(--cms-gold)',
                            'display: flex',
                            'align-items: center',
                            'gap: 4px',
                       ]) 
                       onmouseover="this.style.color='var(--cms-gold-deep)'" onmouseout="this.style.color='var(--cms-gold)'">
                        View all <i data-lucide="arrow-right" style="width: 13px; height: 13px; stroke-width: 2.2;"></i>
                    </a>
                </div>
                <div>
                    @forelse($topArticles as $index => $a)
                        @php
                            $row_border = $index < count($topArticles) - 1 ? "border-bottom: 1px solid var(--cms-border);" : "border-bottom: none;";
                            $row_style = "display: flex; align-items: center; gap: 14px; padding: 13px 20px; cursor: pointer; text-decoration: none; $row_border";
                            $num_style = "font-family: var(--cms-font-mono), monospace; font-size: 13px; font-weight: 700; color: var(--cms-fg4); width: 18px;";
                            $title_style = "font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;";
                            $views_style = "font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg3); margin-top: 2px;";
                        @endphp
                        <a href="{{ route('admin.posts.edit', $a) }}" @style([$row_style]) onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                            <span @style([$num_style])>
                                {{ $index + 1 }}
                            </span>
                            <div style="flex: 1; min-width: 0;">
                                <div @style([$title_style])>
                                    {{ $a->title }}
                                </div>
                                <div @style([$views_style])>
                                    {{ number_format($a->view_count) }} views
                                </div>
                            </div>
                            <div style="flex-shrink: 0; width: 72px;">
                                {!! renderSparkline([$a->view_count*0.8, $a->view_count*0.9, $a->view_count], 'var(--cms-green)') !!}
                            </div>
                        </a>
                    @empty
                        <div style="padding: 40px; text-align: center; color: var(--cms-fg4); font-size: 13.5px;">No top articles yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
                <div style="padding: 16px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="clock" style="width: 17px; height: 17px; color: var(--cms-fg3);"></i>
                    <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 15px', 'font-weight: 700', 'color: var(--cms-fg1)'])>Recent Activity</span>
                </div>
                <div style="padding: 4px 0;">
                    @forelse($activities as $a)
                        <div style="display: flex; gap: 11px; padding: 10px 20px;">
                            @php
                                $initials = collect(explode(' ', $a->user->name ?? 'System'))->map(fn($n) => substr($n, 0, 1))->join('');
                                $avatar_style = "width: 28px; height: 28px; border-radius: 999px; background: rgba(74, 66, 54, 0.12); color: var(--cms-fg1); display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; flex-shrink: 0; border: 1px solid rgba(74, 66, 54, 0.2);";
                            @endphp
                            <div @style([$avatar_style])>
                                {{ $initials }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-fg2); line-height: 1.45;">
                                    <b style="color: var(--cms-fg1); font-weight: 600;">{{ $a->user->name ?? 'System' }}</b> 
                                    {{ str_replace('.', ' ', $a->action) }}
                                </div>
                                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; color: var(--cms-fg4); margin-top: 1px;">
                                    {{ $a->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 40px; text-align: center; color: var(--cms-fg4); font-size: 13.5px;">No recent activity.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Trending Categories Card -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <i data-lucide="trending-up" style="width: 17px; height: 17px; color: var(--cms-green);"></i>
                    <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 15px', 'font-weight: 700', 'color: var(--cms-fg1)'])>Trending Categories</span>
                </div>
                <div style="display: flex; flex-direction: column; gap: 13px;">
                    @php
                        $colors = ['var(--cms-gold)', 'var(--cms-green)', 'var(--cms-blue)', 'var(--cms-ai-to)', 'var(--cms-red)'];
                    @endphp
                    @forelse($trendingCategories as $index => $c)
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 12.5px', 'font-weight: 600', 'color: var(--cms-fg2)'])>{{ $c->name }}</span>
                                <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 12px', 'color: var(--cms-fg3)'])>{{ $c->posts_count }} posts</span>
                            </div>
                            <!-- Custom Progress bar -->
                            <div style="width: 100%; height: 6px; border-radius: 999px; background: var(--cms-border); overflow: hidden;">
                                @php
                                    $progress_width = $totalPosts > 0 ? ($c->posts_count / $totalPosts) * 100 : 0;
                                    $progress_color = $colors[$index % 5];
                                    $progress_style = "width: $progress_width%; background: $progress_color;";
                                @endphp
                                <div class="dashboard-category-progress" @style([$progress_style])></div>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 20px; text-align: center; color: var(--cms-fg4); font-size: 13px;">No categories.</div>
                    @endforelse
                </div>
            </div>

            <!-- Search Traffic Card (Mocked for now as we don't have search analytics) -->
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; box-shadow: var(--cms-sh-card);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px;">
                    <i data-lucide="search" style="width: 17px; height: 17px; color: var(--cms-blue);"></i>
                    <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 15px', 'font-weight: 700', 'color: var(--cms-fg1)'])>Organic Reach</span>
                </div>
                <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 4px;">
                    <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 30px', 'font-weight: 700', 'color: var(--cms-fg1)', 'letter-spacing: -0.02em'])>{{ number_format($totalViews / 10) }}</span>
                    <span @style(['font-family: var(--cms-font-ui), sans-serif', 'font-size: 13px', 'font-weight: 700', 'color: var(--cms-green)', 'display: inline-flex', 'align-items: center', 'gap: 2px'])>
                        <i data-lucide="trending-up" style="width: 14px; height: 14px; stroke-width: 2.2;"></i>
                        +14%
                    </span>
                </div>
                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg3); margin-bottom: 14px;">Estimated organic impact</div>
                <!-- Mini Bar chart -->
                <div style="display: flex; align-items: flex-end; gap: 5px; height: 56px;">
                    @php
                        $bars = [40, 52, 46, 64, 58, 72, 68, 84, 78, 92, 88, 100];
                    @endphp
                    @foreach($bars as $index => $h)
                        @php 
                            $bar_color = ($index >= 9) ? 'var(--cms-blue)' : 'rgba(47, 107, 216, 0.35)'; 
                            $bar_style = "height: $h%; background: $bar_color;";
                        @endphp
                        <div class="dashboard-bar" @style([$bar_style])></div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

