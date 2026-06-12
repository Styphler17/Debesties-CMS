@extends('admin.layouts.app')

@section('title', 'SEO Tools — Debesties Studio')
@section('page_title', 'SEO Tools')

@section('content')


<style>
.seo-tab {
    height: 42px;
    padding: 0 20px;
    font-family: var(--cms-font-ui);
    font-size: 13.5px;
    font-weight: 600;
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    color: var(--cms-fg3);
    cursor: pointer;
    transition: all 150ms;
    margin-bottom: -1px;
}
.seo-tab--active {
    border-bottom-color: var(--cms-gold);
    color: var(--cms-gold);
}
.audit-filter {
    height: 30px;
    padding: 0 12px;
    font-family: var(--cms-font-ui);
    font-size: 12.5px;
    font-weight: 600;
    border-radius: 999px;
    border: 1.5px solid var(--cms-border);
    background: var(--cms-surface);
    color: var(--cms-fg3);
    cursor: pointer;
}
.audit-filter--active {
    border-color: var(--cms-gold);
    background: var(--cms-gold-soft);
    color: var(--cms-gold-deep);
}
.issue-card {
    background: var(--cms-surface);
    border: 1px solid var(--cms-border);
    border-radius: var(--cms-r-lg);
    padding: 18px;
    box-shadow: var(--cms-sh-card);
    cursor: pointer;
    transition: all 150ms;
}
.issue-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--cms-r-md);
    background: var(--icon-bg);
    display: flex;
    align-items: center;
    justify-content: center;
}
.issue-icon i {
    width: 17px;
    height: 17px;
    color: var(--icon-color);
}
.issue-count {
    font-family: var(--cms-font-disp);
    font-size: 32px;
    font-weight: 700;
}
.issue-count--bad  { color: var(--icon-color); }
.issue-count--good { color: var(--cms-green); }
.th-base {
    text-align: left;
    font-family: var(--cms-font-ui);
    font-size: 11.5px;
    font-weight: 700;
    color: var(--cms-fg3);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.th-normal { padding: 10px 0 10px 16px; }
.th-last   { padding: 10px 16px; }
.score--high { color: var(--cms-green); }
.score--mid  { color: var(--cms-gold); }
.score--low  { color: var(--cms-red); }
.score-bar { height: 100%; border-radius: 999px; }
.score-bar--high { background: var(--cms-green); }
.score-bar--mid  { background: var(--cms-gold); }
.score-bar--low  { background: var(--cms-red); }
.link-count--zero   { color: var(--cms-red); }
.link-count--normal { color: var(--cms-fg1); }
</style>

{{-- Tab Nav --}}
<div style="display: flex; gap: 0; border-bottom: 1px solid var(--cms-border); margin-bottom: 20px;">
    @foreach(['overview'=>'Overview','audit'=>'Post Meta Audit','links'=>'Internal Links'] as $tab => $label)
        <button class="seo-tab {{ $tab === 'overview' ? 'seo-tab--active' : '' }}"
                data-tab="{{ $tab }}" onclick="setTab('{{ $tab }}')">
            {{ $label }}
        </button>
    @endforeach
</div>

{{-- Tab: Overview --}}
<div id="tab-overview">
    <div style="display: grid; grid-template-columns: 200px 1fr; gap: 20px; align-items: start;">

        {{-- Health Score Gauge --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 24px 20px; text-align: center; box-shadow: var(--cms-sh-card);">
            <svg viewBox="0 0 120 80" width="120" height="80" style="display: block; margin: 0 auto 10px;">
                {{-- Track --}}
                <path d="M15 70 A55 55 0 0 1 105 70" fill="none" stroke="var(--cms-border)" stroke-width="10" stroke-linecap="round"/>
                {{-- Fill --}}
                @php
                    $circumference = 3.14159 * 55;
                    $filled = round($circumference * ($avgScore / 100));
                    $gaugeColor = $avgScore >= 80 ? 'var(--cms-green)' : ($avgScore >= 60 ? 'var(--cms-gold)' : 'var(--cms-red)');
                @endphp
                <path d="M15 70 A55 55 0 0 1 105 70" fill="none"
                      stroke="{{ $gaugeColor }}"
                      stroke-width="10" stroke-linecap="round"
                      stroke-dasharray="{{ $filled }} {{ $circumference }}"
                      style="transition: stroke-dasharray 1s ease;"/>
                <text x="60" y="68" text-anchor="middle" font-size="22" font-weight="800" fill="var(--cms-fg1)" font-family="Outfit,sans-serif">{{ $avgScore }}</text>
            </svg>
            <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; color: var(--cms-fg1);">SEO Health Score</div>
            <div style="font-family: var(--cms-font-ui); font-size: 11.5px; color: var(--cms-fg4); margin-top: 3px;">avg. across {{ count($auditPosts) }} posts</div>
        </div>

        {{-- Issue Cards --}}
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px;">
            @php
                $issues = [
                    ['icon'=>'file-x','label'=>'Missing Meta Title','count'=>count(array_filter($auditPosts, fn($p)=>empty($p['meta_title']))),'color'=>'var(--cms-red)','bg'=>'var(--cms-red-soft)'],
                    ['icon'=>'align-left','label'=>'Missing Meta Desc','count'=>count(array_filter($auditPosts, fn($p)=>empty($p['meta_desc']))),'color'=>'var(--cms-red)','bg'=>'var(--cms-red-soft)'],
                    ['icon'=>'key','label'=>'No Focus Keyword','count'=>$missingKeyword,'color'=>'var(--cms-gold-deep)','bg'=>'var(--cms-gold-soft)'],
                    ['icon'=>'alert-triangle','label'=>'Low SEO Score (<60)','count'=>count(array_filter($auditPosts, fn($p)=>$p['score']<60)),'color'=>'var(--cms-gold-deep)','bg'=>'var(--cms-gold-soft)'],
                ];
            @endphp
            @foreach($issues as $issue)
                <div class="issue-card"
                     style="--icon-bg: {{ $issue['bg'] }}; --icon-color: {{ $issue['color'] }};"
                     onclick="setTab('audit')"
                     onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='var(--cms-sh-pop)'"
                     onmouseout="this.style.transform=''; this.style.boxShadow='var(--cms-sh-card)'">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                        <div class="issue-icon">
                            <i data-lucide="{{ $issue['icon'] }}"></i>
                        </div>
                        <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg2);">{{ $issue['label'] }}</span>
                    </div>
                    <div class="issue-count {{ $issue['count'] > 0 ? 'issue-count--bad' : 'issue-count--good' }}">{{ $issue['count'] }}</div>
                    <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4); margin-top: 2px;">{{ $issue['count'] > 0 ? 'need attention' : 'all good' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Tab: Post Meta Audit --}}
<div id="tab-audit" style="display: none;">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px; flex-wrap: wrap;">
        <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3);">Filter:</span>
        @foreach(['all' => 'All', 'missing_meta' => 'Missing meta', 'low_score' => 'Low score'] as $value => $label)
            <button onclick="filterAudit('{{ $value }}', this)"
                    class="audit-filter {{ $label === 'All' ? 'audit-filter--active' : '' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--cms-border);">
                    @foreach(['Post Title','Meta Title','Meta Desc','Keyword','Score',''] as $h)
                        <th class="th-base {{ $loop->last ? 'th-last' : 'th-normal' }}">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($auditPosts as $p)
                    @php
                        $scoreLevel = $p['score'] >= 80 ? 'high' : ($p['score'] >= 60 ? 'mid' : 'low');
                        $hasMissing = empty($p['meta_title']) || empty($p['meta_desc']);
                    @endphp
                    <tr class="audit-row"
                        data-missing="{{ $hasMissing ? '1' : '0' }}"
                        data-score="{{ $p['score'] }}"
                        style="border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                        onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 0 12px 16px; max-width: 180px;">
                            <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-fg1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p['title'] }}</div>
                        </td>
                        <td style="padding: 12px 16px 12px 0; max-width: 160px;">
                            @if($p['meta_title'])
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg2); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p['meta_title'] }}</span>
                            @else
                                <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-red); display: flex; align-items: center; gap: 4px;"><i data-lucide="alert-circle" style="width:12px;height:12px;"></i> Missing</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px 12px 0; max-width: 160px;">
                            @if($p['meta_desc'])
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg2); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $p['meta_desc'] }}</span>
                            @else
                                <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-red); display: flex; align-items: center; gap: 4px;"><i data-lucide="alert-circle" style="width:12px;height:12px;"></i> Missing</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px 12px 0;">
                            @if($p['keyword'])
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg2);">{{ $p['keyword'] }}</span>
                            @else
                                <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">—</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px 12px 0; white-space: nowrap;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span class="score--{{ $scoreLevel }}" style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; min-width: 26px;">{{ $p['score'] }}</span>
                                <div style="width: 50px; height: 5px; background: var(--cms-border); border-radius: 999px; overflow: hidden;">
                                    <div class="score-bar score-bar--{{ $scoreLevel }}" data-score-width="{{ $p['score'] }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px 16px;">
                            <a href="{{ route('admin.posts.edit', $p['id']) }}"
                               style="height: 30px; padding: 0 12px; display: inline-flex; align-items: center; gap: 5px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-blue); background: rgba(74,121,255,0.08); border-radius: var(--cms-r-md); text-decoration: none;"
                               onmouseover="this.style.background='rgba(74,121,255,0.15)'" onmouseout="this.style.background='rgba(74,121,255,0.08)'">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Tab: Internal Links --}}
<div id="tab-links" style="display: none;">
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
        <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border);">
            <span style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Internal Link Coverage</span>
            <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4); margin-left: 8px;">via SuggestInternalLinks action</span>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--cms-border);">
                    @foreach(['Post','Existing Links','Suggestions',''] as $h)
                        <th class="th-base {{ $loop->last ? 'th-last' : 'th-normal' }}">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($internalLinks as $lp)
                    <tr style="border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                        onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 13px 0 13px 16px;">
                            <span style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $lp['title'] }}</span>
                        </td>
                        <td style="padding: 13px 16px 13px 0;">
                            <span class="link-count {{ $lp['link_count'] === 0 ? 'link-count--zero' : 'link-count--normal' }}"
                                  style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600;">{{ $lp['link_count'] }}</span>
                            <span style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);"> links</span>
                        </td>
                        <td style="padding: 13px 16px 13px 0;">
                            @if($lp['suggestions'] > 0)
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-gold); background: var(--cms-gold-soft); padding: 2px 8px; border-radius: 999px;">{{ $lp['suggestions'] }} suggested</span>
                            @else
                                <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">—</span>
                            @endif
                        </td>
                        <td style="padding: 13px 16px;">
                            <a href="{{ route('admin.posts.edit', $lp['id']) }}"
                               style="height: 30px; padding: 0 12px; display: inline-flex; align-items: center; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 600; color: var(--cms-blue); background: rgba(74,121,255,0.08); border-radius: var(--cms-r-md); text-decoration: none;"
                               onmouseover="this.style.background='rgba(74,121,255,0.15)'" onmouseout="this.style.background='rgba(74,121,255,0.08)'">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function setTab(tab) {
        ['overview','audit','links'].forEach(t => {
            document.getElementById('tab-' + t).style.display = t === tab ? 'block' : 'none';
        });
        document.querySelectorAll('.seo-tab').forEach(btn => {
            btn.classList.toggle('seo-tab--active', btn.dataset.tab === tab);
        });
    }

    function filterAudit(filter, btn) {
        document.querySelectorAll('.audit-filter').forEach(b => b.classList.remove('audit-filter--active'));
        btn.classList.add('audit-filter--active');

        document.querySelectorAll('.audit-row').forEach(row => {
            if (filter === 'all') row.style.display = '';
            else if (filter === 'missing_meta') row.style.display = row.dataset.missing === '1' ? '' : 'none';
            else if (filter === 'low_score') row.style.display = parseInt(row.dataset.score) < 60 ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-score-width]').forEach(el => {
            el.style.width = el.getAttribute('data-score-width');
        });
    });
</script>
@endsection
