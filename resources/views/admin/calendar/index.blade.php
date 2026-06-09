@extends('admin.layouts.app')

@section('title', 'Editorial Calendar — Debesties Studio')
@section('page_title', 'Editorial Calendar')

@section('content')
@php
    $now = now();
    $year = $now->year;
    $month = $now->month;
    $monthName = $now->format('F Y');
    $firstDay = $now->copy()->startOfMonth()->dayOfWeek; // 0=Sun
    $daysInMonth = $now->daysInMonth;

    $posts = [
        ['id'=>1,'title'=>'TGMA 2024: Full Winners List','status'=>'published','author'=>'Ama B','day'=>2],
        ['id'=>2,'title'=>'Black Sherif Net Worth Deep Dive','status'=>'scheduled','author'=>'Kofi M','day'=>5],
        ['id'=>3,'title'=>'Highlife Legends: Then vs Now','status'=>'draft','author'=>'Adjoa S','day'=>5],
        ['id'=>4,'title'=>'King Promise Album Review','status'=>'scheduled','author'=>'Ama B','day'=>9],
        ['id'=>5,'title'=>'Ghana Music Awards History','status'=>'published','author'=>'Kofi M','day'=>12],
        ['id'=>6,'title'=>'Celebrity Fashion Week Roundup','status'=>'review','author'=>'Adjoa S','day'=>15],
        ['id'=>7,'title'=>'Sarkodie Biography Updated','status'=>'scheduled','author'=>'Ama B','day'=>18],
        ['id'=>8,'title'=>'Top 10 Afrobeats Songs 2024','status'=>'draft','author'=>'Kofi M','day'=>20],
        ['id'=>9,'title'=>'TGMA Best New Artist Analysis','status'=>'approved','author'=>'Adjoa S','day'=>22],
        ['id'=>10,'title'=>'Ghana Sports Year in Review','status'=>'scheduled','author'=>'Ama B','day'=>25],
        ['id'=>11,'title'=>'Highlife Music Festival Preview','status'=>'draft','author'=>'Kofi M','day'=>28],
    ];

    $statusColors = [
        'published' => ['bg'=>'#E7F5EE','color'=>'#1A7A45','dot'=>'#2ECC71'],
        'scheduled' => ['bg'=>'#FFF8E6','color'=>'#8A5A00','dot'=>'#E8A800'],
        'draft'     => ['bg'=>'rgba(74,66,54,0.08)','color'=>'var(--cms-fg3)','dot'=>'#9E9186'],
        'review'    => ['bg'=>'rgba(74,121,255,0.1)','color'=>'#2A52C9','dot'=>'#4A79FF'],
        'approved'  => ['bg'=>'rgba(46,204,113,0.12)','color'=>'#1A7A45','dot'=>'#27AE60'],
    ];

    // Group posts by day
    $byDay = [];
    foreach ($posts as $p) { $byDay[$p['day']][] = $p; }

    $upcoming = array_filter($posts, fn($p) => in_array($p['status'], ['scheduled','approved']) && $p['day'] >= $now->day);
    usort($upcoming, fn($a,$b) => $a['day'] <=> $b['day']);
@endphp

<div style="display: grid; grid-template-columns: 1fr 240px; gap: 20px; align-items: start;">

    {{-- Calendar --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">

        {{-- Calendar Header --}}
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--cms-border);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <button onclick="navigate(-1)"
                        style="width: 34px; height: 34px; border-radius: var(--cms-r-md); border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg2);"
                        onmouseover="this.style.background='var(--cms-surface-2)'" onmouseout="this.style.background='var(--cms-bg)'">
                    <i data-lucide="chevron-left" style="width: 16px; height: 16px;"></i>
                </button>
                <span style="font-family: var(--cms-font-disp); font-size: 18px; font-weight: 700; color: var(--cms-fg1);">{{ $monthName }}</span>
                <button onclick="navigate(1)"
                        style="width: 34px; height: 34px; border-radius: var(--cms-r-md); border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg2);"
                        onmouseover="this.style.background='var(--cms-surface-2)'" onmouseout="this.style.background='var(--cms-bg)'">
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
                </button>
                <button style="height: 30px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Today</button>
            </div>
            <div style="display: flex; gap: 2px; border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); overflow: hidden;">
                <button onclick="setCalView('month')" id="btn-month"
                        style="height: 32px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; cursor: pointer;">Month</button>
                <button onclick="setCalView('week')" id="btn-week"
                        style="height: 32px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: none; cursor: pointer;">Week</button>
            </div>
        </div>

        {{-- Month View --}}
        <div id="cal-month">
            {{-- Day headers --}}
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); border-bottom: 1px solid var(--cms-border);">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                    <div style="padding: 9px; text-align: center; font-family: var(--cms-font-ui); font-size: 11.5px; font-weight: 700; color: var(--cms-fg4); letter-spacing: 0.04em; text-transform: uppercase;">{{ $day }}</div>
                @endforeach
            </div>

            {{-- Calendar Grid --}}
            <div style="display: grid; grid-template-columns: repeat(7, 1fr);">
                @php
                    $cellNum = 0;
                    $totalCells = ceil(($firstDay + $daysInMonth) / 7) * 7;
                @endphp
                @for($cell = 0; $cell < $totalCells; $cell++)
                    @php
                        $dayNum = $cell - $firstDay + 1;
                        $isValid = $dayNum >= 1 && $dayNum <= $daysInMonth;
                        $isToday = $isValid && $dayNum === $now->day;
                        $isLast = $cell % 7 === 6;
                        $cellPosts = $isValid && isset($byDay[$dayNum]) ? $byDay[$dayNum] : [];
                    @endphp
                    <div style="min-height: 100px; border-right: {{ !$isLast ? '1px solid var(--cms-border)' : 'none' }}; border-bottom: 1px solid var(--cms-border); padding: 8px 6px; background: {{ $isToday ? 'rgba(232,168,0,0.04)' : 'transparent' }}; position: relative; transition: background 100ms; {{ !$isValid ? 'opacity: 0.25;' : '' }}"
                         @if($isValid) onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='{{ $isToday ? 'rgba(232,168,0,0.04)' : 'transparent' }}'" @endif>

                        {{-- Day number --}}
                        @if($isValid)
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 5px;">
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: {{ $isToday ? '800' : '500' }}; color: {{ $isToday ? 'var(--cms-gold)' : 'var(--cms-fg3)' }}; {{ $isToday ? 'background: var(--cms-gold-soft); padding: 1px 7px; border-radius: 999px;' : '' }}">
                                    {{ $dayNum }}
                                </span>
                                @if($isValid)
                                    <a href="{{ route('admin.posts.create', ['scheduled_for' => $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dayNum, 2, '0', STR_PAD_LEFT)]) }}"
                                       style="opacity: 0; transition: opacity 150ms; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; color: var(--cms-fg4); text-decoration: none; border-radius: 4px;"
                                       class="add-post-link" title="New post for this day"
                                       onmouseover="this.style.background='var(--cms-border)'; this.style.color='var(--cms-fg1)'"
                                       onmouseout="this.style.background='transparent'; this.style.color='var(--cms-fg4)'">
                                        <i data-lucide="plus" style="width: 12px; height: 12px; stroke-width: 2.5;"></i>
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- Posts for this day --}}
                        @foreach(array_slice($cellPosts, 0, 3) as $post)
                            @php $sc = $statusColors[$post['status']] ?? $statusColors['draft']; @endphp
                            <div class="post-pill" data-post="{{ $post['id'] }}"
                                 onclick="showPostTooltip(event, {{ $post['id'] }})"
                                 style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-bottom: 3px; background: {{ $sc['bg'] }}; color: {{ $sc['color'] }}; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; display: block;">
                                {{ $post['title'] }}
                            </div>
                        @endforeach
                        @if(count($cellPosts) > 3)
                            <div style="font-family: var(--cms-font-ui); font-size: 10.5px; color: var(--cms-fg4); padding: 1px 6px;">+{{ count($cellPosts) - 3 }} more</div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        {{-- Week View (simplified) --}}
        <div id="cal-week" style="display: none; padding: 20px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg3); text-align: center; padding: 40px;">
            <i data-lucide="calendar" style="width: 32px; height: 32px; color: var(--cms-fg4); margin-bottom: 10px;"></i>
            <div style="color: var(--cms-fg2); font-weight: 600;">Week view coming soon</div>
            <div style="font-size: 13px; margin-top: 4px;">Switch back to Month view to see your editorial schedule.</div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div style="display: flex; flex-direction: column; gap: 14px; position: sticky; top: 88px;">

        {{-- Legend --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 14px 16px; box-shadow: var(--cms-sh-card);">
            <div style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 10px;">Legend</div>
            @foreach($statusColors as $status => $sc)
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 7px;">
                    <div style="width: 8px; height: 8px; border-radius: 999px; background: {{ $sc['dot'] }}; flex-shrink: 0;"></div>
                    <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg2); text-transform: capitalize;">{{ $status }}</span>
                </div>
            @endforeach
        </div>

        {{-- Upcoming Scheduled --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 12px 16px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 7px;">
                <i data-lucide="clock" style="width: 14px; height: 14px; color: var(--cms-gold);"></i>
                <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg1);">Upcoming</span>
            </div>
            @foreach(array_slice(array_values($upcoming), 0, 5) as $post)
                @php $sc = $statusColors[$post['status']] ?? $statusColors['draft']; @endphp
                <a href="{{ route('admin.posts.edit', $post['id']) }}"
                   style="display: flex; align-items: flex-start; gap: 10px; padding: 11px 16px; border-bottom: 1px solid var(--cms-border); text-decoration: none; transition: background 100ms;"
                   onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                    <div style="flex-shrink: 0; width: 28px; height: 28px; border-radius: var(--cms-r-md); background: var(--cms-gold-soft); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 800; color: var(--cms-gold); line-height: 1;">{{ $post['day'] }}</span>
                        <span style="font-family: var(--cms-font-ui); font-size: 8px; color: var(--cms-gold-deep); text-transform: uppercase; letter-spacing: 0.04em;">{{ $now->format('M') }}</span>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $post['title'] }}</div>
                        <div style="display: inline-flex; align-items: center; gap: 4px; margin-top: 3px; background: {{ $sc['bg'] }}; color: {{ $sc['color'] }}; padding: 1px 6px; border-radius: 999px; font-size: 10.5px; font-weight: 600; font-family: var(--cms-font-ui);">
                            {{ ucfirst($post['status']) }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Quick Add --}}
        <a href="{{ route('admin.posts.create') }}"
           style="display: flex; align-items: center; justify-content: center; gap: 8px; height: 42px; background: var(--cms-gold); color: #1A1410; border-radius: var(--cms-r-lg); font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; text-decoration: none;"
           onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
            <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2.5;"></i>
            New Post
        </a>
    </div>
</div>

{{-- Post tooltip --}}
<div id="post-tooltip" style="display: none; position: fixed; z-index: 300; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 14px 16px; width: 240px; box-shadow: var(--cms-sh-pop); animation: dsPop 160ms ease;">
    <div id="tt-title" style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 6px;"></div>
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
        <span id="tt-status" style="font-size: 11.5px; font-weight: 600; font-family: var(--cms-font-ui); padding: 1px 8px; border-radius: 999px;"></span>
        <span id="tt-author" style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg3);"></span>
    </div>
    <div style="display: flex; gap: 8px;">
        <a id="tt-edit" href="#" style="flex: 1; height: 30px; display: flex; align-items: center; justify-content: center; background: var(--cms-gold); color: #1A1410; border-radius: var(--cms-r-md); font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; text-decoration: none;">Edit Post</a>
        <button onclick="closeTooltip()" style="width: 30px; height: 30px; border-radius: var(--cms-r-md); border: 1.5px solid var(--cms-border); background: var(--cms-bg); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3);">
            <i data-lucide="x" style="width: 12px; height: 12px;"></i>
        </button>
    </div>
</div>

<style>
    .add-post-link { opacity: 0 !important; }
    div:hover > div > .add-post-link { opacity: 1 !important; }
</style>

<script>
    const postsData = @json($posts);
    const statusMeta = @json($statusColors);

    function setCalView(v) {
        document.getElementById('cal-month').style.display = v === 'month' ? 'block' : 'none';
        document.getElementById('cal-week').style.display  = v === 'week'  ? 'block' : 'none';
        document.getElementById('btn-month').style.background = v === 'month' ? 'var(--cms-gold)' : 'var(--cms-surface)';
        document.getElementById('btn-month').style.color = v === 'month' ? '#1A1410' : 'var(--cms-fg2)';
        document.getElementById('btn-week').style.background = v === 'week' ? 'var(--cms-gold)' : 'var(--cms-surface)';
        document.getElementById('btn-week').style.color = v === 'week' ? '#1A1410' : 'var(--cms-fg2)';
    }

    function navigate(dir) { console.log('Navigate calendar', dir > 0 ? 'forward' : 'back'); }

    function showPostTooltip(e, id) {
        e.stopPropagation();
        const p = postsData.find(x => x.id === id);
        if (!p) return;
        const sc = statusMeta[p.status] || statusMeta.draft;
        const tt = document.getElementById('post-tooltip');
        document.getElementById('tt-title').textContent = p.title;
        const statusEl = document.getElementById('tt-status');
        statusEl.textContent = p.status.charAt(0).toUpperCase() + p.status.slice(1);
        statusEl.style.background = sc.bg;
        statusEl.style.color = sc.color;
        document.getElementById('tt-author').textContent = 'by ' + p.author;
        document.getElementById('tt-edit').href = '/admin/posts/' + p.id + '/edit';
        const rect = e.target.getBoundingClientRect();
        tt.style.left = Math.min(rect.right + 8, window.innerWidth - 260) + 'px';
        tt.style.top  = Math.min(rect.top, window.innerHeight - 180) + 'px';
        tt.style.display = 'block';
        lucide.createIcons();
    }

    function closeTooltip() { document.getElementById('post-tooltip').style.display = 'none'; }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#post-tooltip') && !e.target.closest('.post-pill')) closeTooltip();
    });
</script>
@endsection
