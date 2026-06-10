@extends('admin.layouts.app')

@section('title', 'Analytics — Debesties Studio')
@section('page_title', 'Analytics')

@section('content')
<style>
    .range-btn {
        height: 32px;
        padding: 0 16px;
        font-family: var(--cms-font-ui);
        font-size: 13px;
        font-weight: 600;
        border: none;
        border-radius: var(--cms-r-md);
        cursor: pointer;
        transition: all 150ms;
        background: transparent;
        color: var(--cms-fg3);
    }
    .range-btn.active {
        background: var(--cms-gold);
        color: #1A1410;
    }
    .range-btn:hover:not(.active) {
        background: var(--cms-border-soft);
        color: var(--cms-fg1);
    }
    .stat-trend {
        font-family: var(--cms-font-ui);
        font-size: 12px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
    }
    .stat-trend.up {
        background: rgba(46,204,113,0.12);
        color: var(--cms-green);
    }
    .stat-trend.down {
        background: rgba(200,55,43,0.1);
        color: var(--cms-red);
    }
</style>
@php
    $ranges = ['7d' => '7 Days', '30d' => '30 Days', '90d' => '90 Days'];
    $stats = [
        ['label'=>'Total Views',        'value'=>'124,839', 'delta'=>'+18.4%', 'up'=>true,  'icon'=>'eye'],
        ['label'=>'Unique Visitors',    'value'=>'38,201',  'delta'=>'+11.2%', 'up'=>true,  'icon'=>'users'],
        ['label'=>'Avg. Time on Page',  'value'=>'3m 42s',  'delta'=>'+0:23',  'up'=>true,  'icon'=>'clock'],
        ['label'=>'Bounce Rate',        'value'=>'52.1%',   'delta'=>'-3.8%',  'up'=>true,  'icon'=>'trending-down'],
    ];
    $topPosts = [
        ['rank'=>1,'title'=>'The Elite Club: 4 Artists Who Dominated the TGMAs','views'=>'18,420','time'=>'5m 12s','category'=>'Awards History','trend'=>[40,55,48,72,65,80,88]],
        ['rank'=>2,'title'=>'Black Sherif: From Konongo to International Fame','views'=>'12,905','time'=>'4m 38s','category'=>'Profiles','trend'=>[30,40,35,55,45,60,62]],
        ['rank'=>3,'title'=>'TGMA 2024 Full Winners Announced','views'=>'10,312','time'=>'2m 55s','category'=>'News','trend'=>[80,75,60,45,30,22,18]],
        ['rank'=>4,'title'=>'Ghana Music: The Highlife Renaissance','views'=>'8,044','time'=>'6m 10s','category'=>'Analysis','trend'=>[10,20,28,35,42,52,58]],
        ['rank'=>5,'title'=>'King Promise: A Year in Review','views'=>'6,890','time'=>'3m 28s','category'=>'Profiles','trend'=>[22,25,30,32,38,40,45]],
    ];
    $sources = [
        ['label'=>'Organic Search','pct'=>54,'color'=>'var(--cms-gold)'],
        ['label'=>'Direct',        'pct'=>21,'color'=>'var(--cms-blue)'],
        ['label'=>'Social Media',  'pct'=>16,'color'=>'#9B59B6'],
        ['label'=>'Referral',      'pct'=>9, 'color'=>'var(--cms-green)'],
    ];
    $countries = [
        ['country'=>'Ghana','visits'=>'48,392','pct'=>38.8],
        ['country'=>'Nigeria','visits'=>'22,104','pct'=>17.7],
        ['country'=>'United Kingdom','visits'=>'14,830','pct'=>11.9],
        ['country'=>'United States','visits'=>'12,210','pct'=>9.8],
        ['country'=>'Canada','visits'=>'7,015','pct'=>5.6],
        ['country'=>'South Africa','visits'=>'5,390','pct'=>4.3],
        ['country'=>'Germany','visits'=>'3,240','pct'=>2.6],
        ['country'=>'France','visits'=>'2,880','pct'=>2.3],
    ];
    // Bar chart data (views per day, last 30 days, sample)
    $chartBars = [28,45,32,60,55,71,82,68,75,90,78,65,88,72,95,83,69,77,91,86,78,62,55,70,88,92,74,80,96,102];
    $maxBar = max($chartBars);
@endphp

{{-- Date Range Selector --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    <div style="display: flex; gap: 4px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 4px;">
        @foreach($ranges as $key => $label)
            <button onclick="setRange('{{ $key }}', this)"
                    class="range-btn {{ $key === '30d' ? 'active' : '' }}"
                    data-range="{{ $key }}">
                {{ $label }}
            </button>
        @endforeach
    </div>
    <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg4);">
        Powered by internal <code style="font-family: var(--cms-font-mono); background: var(--cms-border-soft); padding: 1px 5px; border-radius: 4px; font-size: 11.5px;">view_count</code> tracking
    </div>
</div>

{{-- Stat Cards --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px;">
    @foreach($stats as $stat)
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 18px; box-shadow: var(--cms-sh-card);">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                <div style="width: 38px; height: 38px; border-radius: var(--cms-r-md); background: var(--cms-gold-soft); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="{{ $stat['icon'] }}" style="width: 18px; height: 18px; color: var(--cms-gold);"></i>
                </div>
                <span class="stat-trend {{ $stat['up'] ? 'up' : 'down' }}">{{ $stat['delta'] }}</span>
            </div>
            <div style="font-family: var(--cms-font-disp); font-size: 26px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 4px;">{{ $stat['value'] }}</div>
            <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3);">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>

{{-- Main Chart --}}
<div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; margin-bottom: 20px; box-shadow: var(--cms-sh-card);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <span style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Daily Views — Last 30 Days</span>
        <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">Peak: {{ max($chartBars) }}K views</span>
    </div>
    <div style="display: flex; align-items: flex-end; gap: 5px; height: 160px; padding: 0 4px;">
        @foreach($chartBars as $i => $val)
            @php $h = max(4, round(($val / $maxBar) * 100)); @endphp
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 3px; height: 100%;">
                <div style="width: 100%; margin-top: auto; height: {{ $h }}%; background: linear-gradient(180deg, var(--cms-gold) 0%, rgba(232,168,0,0.4) 100%); border-radius: 4px 4px 0 0; transition: opacity 150ms; min-height: 4px;"
                     onmouseover="this.style.opacity='0.75'; showBarTip(event, '{{ $val }}K', '{{ $i + 1 }} May')"
                     onmouseout="this.style.opacity='1'; hideBarTip()"></div>
            </div>
        @endforeach
    </div>
    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 6px; padding: 0 4px;">
        <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">1 Jun</span>
        <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">15 Jun</span>
        <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">30 Jun</span>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">

    {{-- Top Posts --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 8px;">
            <i data-lucide="bar-chart-2" style="width: 15px; height: 15px; color: var(--cms-gold);"></i>
            <span style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Top Posts</span>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--cms-border);">
                    <th style="width: 36px; padding: 9px 12px; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.04em; text-align: center;">#</th>
                    <th style="padding: 9px 12px 9px 0; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.04em; text-align: left;">Post</th>
                    <th style="padding: 9px 12px 9px 0; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.04em; text-align: right;">Views</th>
                    <th style="padding: 9px 12px 9px 0; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.04em; text-align: right;">Avg Time</th>
                    <th style="padding: 9px 16px 9px 0; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: var(--cms-fg4); text-transform: uppercase; letter-spacing: 0.04em; text-align: center;">Trend</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topPosts as $p)
                    <tr style="border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                        onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px; text-align: center;">
                            <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 800; color: {{ $p['rank'] <= 3 ? 'var(--cms-gold)' : 'var(--cms-fg4)' }};">{{ $p['rank'] }}</span>
                        </td>
                        <td style="padding: 12px 12px 12px 0; max-width: 0;">
                            <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p['title'] }}</div>
                            <div style="font-family: var(--cms-font-ui); font-size: 11.5px; color: var(--cms-fg4); margin-top: 2px;">{{ $p['category'] }}</div>
                        </td>
                        <td style="padding: 12px 12px 12px 0; text-align: right; white-space: nowrap;">
                            <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg1);">{{ $p['views'] }}</span>
                        </td>
                        <td style="padding: 12px 12px 12px 0; text-align: right; white-space: nowrap;">
                            <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3);">{{ $p['time'] }}</span>
                        </td>
                        <td style="padding: 12px 16px 12px 0;">
                            <svg viewBox="0 0 70 28" width="70" height="28" style="display: block; margin: 0 auto;">
                                @php
                                    $pts = $p['trend'];
                                    $mn = min($pts); $mx = max($pts);
                                    $range = $mx - $mn ?: 1;
                                    $coords = [];
                                    foreach($pts as $xi => $v) {
                                        $px = round($xi / (count($pts)-1) * 68) + 1;
                                        $py = round(26 - (($v - $mn) / $range) * 24);
                                        $coords[] = "$px,$py";
                                    }
                                    $polyline = implode(' ', $coords);
                                @endphp
                                <polyline points="{{ $polyline }}" fill="none" stroke="var(--cms-gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Traffic Sources + Countries --}}
    <div style="display: flex; flex-direction: column; gap: 14px;">
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 16px 18px; box-shadow: var(--cms-sh-card);">
            <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 14px;">Traffic Sources</div>
            @foreach($sources as $s)
                <div style="margin-bottom: 11px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 5px;">
                        <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2);">{{ $s['label'] }}</span>
                        <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg1);">{{ $s['pct'] }}%</span>
                    </div>
                    <div style="width: 100%; height: 6px; background: var(--cms-border); border-radius: 999px; overflow: hidden;">
                        <div style="width: {{ $s['pct'] }}%; height: 100%; background: {{ $s['color'] }}; border-radius: 999px;"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 12px 16px; border-bottom: 1px solid var(--cms-border); font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Top Countries</div>
            @foreach($countries as $c)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 9px 16px; border-bottom: 1px solid var(--cms-border);">
                    <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1);">{{ $c['country'] }}</span>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg3);">{{ $c['visits'] }}</span>
                        <span style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 600; color: var(--cms-fg2); min-width: 36px; text-align: right;">{{ $c['pct'] }}%</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Tooltip --}}
<div id="bar-tip" style="display: none; position: fixed; z-index: 300; background: var(--cms-bg); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 6px 10px; font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg1); box-shadow: var(--cms-sh-card); pointer-events: none; white-space: nowrap;"></div>

<script>
    function setRange(r, btn) {
        document.querySelectorAll('.range-btn').forEach(b => {
            b.classList.toggle('active', b.dataset.range === r);
        });
    }
    function showBarTip(e, val, label) {
        const t = document.getElementById('bar-tip');
        t.textContent = `${label}: ${val}`;
        t.style.display = 'block';
        t.style.left = (e.clientX + 10) + 'px';
        t.style.top  = (e.clientY - 28) + 'px';
    }
    function hideBarTip() { document.getElementById('bar-tip').style.display = 'none'; }
</script>
@endsection
