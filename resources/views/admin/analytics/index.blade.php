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
    $maxBar = count($chartBars) > 0 ? max($chartBars) : 1;
@endphp

{{-- Date Range Selector --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    <div style="display: flex; gap: 4px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 4px;">
        @foreach($ranges as $key => $label)
            <button onclick="setRange('{{ $key }}', this)"
                    class="range-btn {{ $key === $range ? 'active' : '' }}"
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
@php
    $daysCount = count($chartBars);
    $rangeDays = $range === '7d' ? 7 : ($range === '90d' ? 90 : 30);
    $interval = $range === '90d' ? 3 : 1;
@endphp
<div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; margin-bottom: 20px; box-shadow: var(--cms-sh-card);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <span style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Daily Views — Last {{ $rangeDays }} Days</span>
        <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">Peak: {{ number_format(max($chartBars)) }} views</span>
    </div>
    <div style="display: flex; align-items: flex-end; gap: 5px; height: 160px; padding: 0 4px;">
        @foreach($chartBars as $i => $val)
            @php 
                $h = max(4, round(($val / $maxBar) * 100));
                $startOffset = ($daysCount - 1 - $i) * $interval;
                $dateLabel = $range === '90d'
                    ? now()->subDays($startOffset + 2)->format('j M') . ' - ' . now()->subDays($startOffset)->format('j M')
                    : now()->subDays($startOffset)->format('j M');
            @endphp
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 3px; height: 100%;">
                <div style="width: 100%; margin-top: auto; background: linear-gradient(180deg, var(--cms-gold) 0%, rgba(232,168,0,0.4) 100%); border-radius: 4px 4px 0 0; transition: opacity 150ms; min-height: 4px;"
                     data-height="{{ $h }}%"
                     onmouseover="this.style.opacity='0.75'; showBarTip(event, '{{ number_format($val) }} views', '{{ $dateLabel }}')"
                     onmouseout="this.style.opacity='1'; hideBarTip()"></div>
            </div>
        @endforeach
    </div>
    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 6px; padding: 0 4px;">
        <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">{{ now()->subDays($rangeDays - 1)->format('j M') }}</span>
        <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">{{ now()->subDays($rangeDays / 2)->format('j M') }}</span>
        <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">{{ now()->format('j M') }}</span>
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
                            <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 800;" data-color="{{ $p['rank'] <= 3 ? 'var(--cms-gold)' : 'var(--cms-fg4)' }}">{{ $p['rank'] }}</span>
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
                        <div style="height: 100%; border-radius: 999px;" data-width="{{ $s['pct'] }}%" data-background="{{ $s['color'] }}"></div>
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
        window.location.href = '?range=' + r;
    }
    function showBarTip(e, val, label) {
        const t = document.getElementById('bar-tip');
        t.textContent = `${label}: ${val}`;
        t.style.display = 'block';
        t.style.left = (e.clientX + 10) + 'px';
        t.style.top  = (e.clientY - 28) + 'px';
    }
    function hideBarTip() { document.getElementById('bar-tip').style.display = 'none'; }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-height]').forEach(el => {
            el.style.height = el.getAttribute('data-height');
        });
        document.querySelectorAll('[data-width]').forEach(el => {
            el.style.width = el.getAttribute('data-width');
        });
        document.querySelectorAll('[data-background]').forEach(el => {
            el.style.background = el.getAttribute('data-background');
        });
        document.querySelectorAll('[data-color]').forEach(el => {
            el.style.color = el.getAttribute('data-color');
        });
    });
</script>
@endsection
