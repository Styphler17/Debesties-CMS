@extends('admin.layouts.app')

@section('title', 'AI Visibility — Debesties Studio')
@section('page_title', 'AI Visibility')

@section('content')
<style>
    .visibility-header-title { font-family: var(--cms-font-disp), serif; font-size: 18px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 4px; }
    .visibility-header-desc { font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; color: var(--cms-fg3); }
    .visibility-section-title { font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1); }
    .visibility-section-desc { font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg4); }

    .visibility-rec-card { padding: 12px; background: var(--cms-bg); border-radius: var(--cms-r-md); }

    .visibility-rec-card--high { border-left: 3px solid var(--cms-red); }
    .visibility-rec-card--medium { border-left: 3px solid var(--cms-gold); }
    .visibility-rec-card--low { border-left: 3px solid var(--cms-blue); }

    .bot-status-label { font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; }
    .bot-status-label--blocked { color: var(--cms-red); }
    .bot-status-label--allowed { color: var(--cms-green); }

    .bot-toggle-btn { width: 48px; height: 26px; border-radius: 999px; border: none; cursor: pointer; position: relative; transition: background 220ms; flex-shrink: 0; }
    .bot-toggle-btn--blocked { background: #C8372B; }
    .bot-toggle-btn--allowed { background: var(--cms-green); }

    .bot-toggle-dot { position: absolute; top: 3px; width: 20px; height: 20px; border-radius: 999px; background: #fff; transition: left 220ms; }
    .bot-toggle-dot--blocked { left: 4px; }
    .bot-toggle-dot--allowed { left: 24px; }

    .feature-toggle-btn { width: 48px; height: 26px; border-radius: 999px; border: none; cursor: pointer; position: relative; transition: background 220ms; flex-shrink: 0; }
    .feature-toggle-btn--on { background: var(--cms-green); }
    .feature-toggle-btn--off { background: rgba(74,66,54,0.18); }

    .log-status-badge { padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; }
    .log-status-badge--success { background: var(--cms-green-soft); color: var(--cms-green-deep); }
    .log-status-badge--error { background: var(--cms-red-soft); color: var(--cms-red-deep); }
</style>

{{-- Header Banner --}}
<div style="background: linear-gradient(135deg, rgba(74,66,54,0.06) 0%, rgba(232,168,0,0.06) 100%); border: 1px solid rgba(232,168,0,0.2); border-radius: var(--cms-r-xl); padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
    <div style="width: 48px; height: 48px; border-radius: var(--cms-r-lg); background: linear-gradient(135deg, var(--cms-gold), #FF8C42); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px;">🤖</div>
    <div>
        <div class="visibility-header-title">AI Crawler Access Control</div>
        <div class="visibility-header-desc">Control how AI search engines — Perplexity, ChatGPT, Gemini, Claude — index and use your content. Changes update <code style="font-family: var(--cms-font-mono), monospace; background: rgba(74,66,54,0.08); padding: 1px 5px; border-radius: 4px; font-size: 11.5px;">robots.txt</code> in real time.</div>
    </div>
</div>


<div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start;">

    <div style="display: flex; flex-direction: column; gap: 20px;">

        {{-- Score & Recommendations Row --}}
        <div style="display: grid; grid-template-columns: 240px 1fr; gap: 20px;">
            {{-- Score Card --}}
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 24px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; box-shadow: var(--cms-sh-card);">
                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">Visibility Score</div>
                <div style="position: relative; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                    @php
                        $score = $visibilityScore['score'];
                        $gaugeStyle = "stroke: var(--cms-gold); --score: $score; stroke-dasharray: $score, 100; transition: stroke-dasharray 0.6s ease;";
                    @endphp
                    <svg viewBox="0 0 36 36" style="width: 100%; height: 100%; transform: rotate(-90deg);">
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="rgba(0,0,0,0.05)" stroke-width="3" />
                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" 
                              fill="none" 
                              stroke-width="3" 
                              stroke-linecap="round" 
                              class="gauge-path"
                              @style([
                                  "stroke: var(--cms-gold)",
                                  "--score: $score",
                                  "stroke-dasharray: $score, 100",
                              ]) />
                    </svg>
                    <div style="position: absolute; font-family: var(--cms-font-disp), serif; font-size: 24px; font-weight: 800; color: var(--cms-fg1);">{{ $score }}<span style="font-size: 14px; opacity: 0.4;">%</span></div>
                </div>
                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 600; color: var(--cms-gold-deep);">
                    {{ $score >= 80 ? 'Excellent Optimization' : ($score >= 50 ? 'Good Progress' : 'Needs Attention') }}
                </div>
            </div>

            {{-- Recommendations Card --}}
            <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 20px; box-shadow: var(--cms-sh-card);">
                <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="sparkles" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                    Optimization Recommendations
                </div>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @forelse($recommendations as $rec)
                        <div @class([
                            'visibility-rec-card',
                            'visibility-rec-card--high' => $rec['priority'] === 'high',
                            'visibility-rec-card--medium' => $rec['priority'] === 'medium',
                            'visibility-rec-card--low' => $rec['priority'] !== 'high' && $rec['priority'] !== 'medium',
                        ])>
                            <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 13px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 2px;">{{ $rec['title'] }}</div>
                            <div style="font-size: 12px; color: var(--cms-fg3); line-height: 1.4;">{{ $rec['body'] }}</div>
                        </div>
                    @empty
                        <div style="padding: 20px; text-align: center; color: var(--cms-fg4); font-size: 13px;">
                            <i data-lucide="check-circle" style="width: 24px; height: 24px; margin-bottom: 8px; opacity: 0.5;"></i>
                            <div>Your site is fully optimized for AI visibility!</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Section 1: Bot Access --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 10px;">
                <i data-lucide="shield" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                <div>
                    <div class="visibility-section-title">LLM Crawler Access</div>
                    <div class="visibility-section-desc">Toggle access per AI bot. Blocked bots are added to robots.txt Disallow.</div>
                </div>
            </div>
            @foreach($bots as $bot)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                     onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; border-radius: var(--cms-r-md); background: var(--cms-bg); border: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">{{ $bot['icon'] }}</div>
                        <div>
                            <div style="font-family: var(--cms-font-mono), monospace; font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $bot['name'] }}</div>
                            <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg4);">{{ $bot['owner'] }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span id="bot-label-{{ $bot['id'] }}" 
                            @class([
                                'bot-status-label',
                                'bot-status-label--blocked' => $bot['blocked'],
                                'bot-status-label--allowed' => ! $bot['blocked'],
                            ])>
                            {{ $bot['blocked'] ? 'Blocked' : 'Allowed' }}
                        </span>
                        <button onclick="toggleBot(this.dataset.botId, this)"
                                data-bot-id="{{ $bot['id'] }}"
                                data-blocked="{{ $bot['blocked'] ? 'true' : 'false' }}"
                                @class([
                                    'bot-toggle-btn',
                                    'bot-toggle-btn--blocked' => $bot['blocked'],
                                    'bot-toggle-btn--allowed' => ! $bot['blocked'],
                                ])>
                            <span @class([
                                'bot-toggle-dot',
                                'bot-toggle-dot--blocked' => $bot['blocked'],
                                'bot-toggle-dot--allowed' => ! $bot['blocked'],
                            ])></span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Section 2: Sitemap & Features --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 10px;">
                <i data-lucide="map" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                <div>
                    <div class="visibility-section-title">Visibility Features</div>
                    <div class="visibility-section-desc">Control advanced discovery signals.</div>
                </div>
            </div>
            @php
                $features = [
                    ['id'=>'llms_txt',        'label'=>'Enable llms.txt',              'sub'=>'Machine-readable index for LLM crawlers',             'on'=> \App\Services\SettingsService::get('ai_llms_txt_enabled', '1') === '1'],
                    ['id'=>'article_schema',  'label'=>'Article Schema (JSON-LD)',     'sub'=>'Outputs post as Article/NewsArticle schema type',     'on'=> \App\Services\SettingsService::get('ai_article_schema_enabled', '1') === '1'],
                    ['id'=>'faq_schema',      'label'=>'FAQ Schema (JSON-LD)',         'sub'=>'Outputs PostFaq data as structured FAQ schema',        'on'=> \App\Services\SettingsService::get('ai_faq_schema_enabled', '1') === '1'],
                    ['id'=>'breadcrumb',      'label'=>'BreadcrumbList Schema',        'sub'=>'Adds breadcrumb structured data to article pages',    'on'=> \App\Services\SettingsService::get('ai_breadcrumb_enabled', '1') === '1'],
                ];
            @endphp
            @foreach($features as $f)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--cms-border);">
                    <div>
                        <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $f['label'] }}</div>
                        <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg4); margin-top: 2px;">{{ $f['sub'] }}</div>
                    </div>
                    <button onclick="toggleFeature(this.dataset.featureId, this)"
                            data-feature-id="{{ $f['id'] }}"
                            data-on="{{ $f['on'] ? 'true' : 'false' }}"
                            @class([
                                'feature-toggle-btn',
                                'feature-toggle-btn--on' => $f['on'],
                                'feature-toggle-btn--off' => ! $f['on'],
                            ])>
                    <span @class([
                        'bot-toggle-dot',
                        'bot-toggle-dot--allowed' => $f['on'],
                        'bot-toggle-dot--blocked' => ! $f['on'],
                    ])></span>
                    </button>
                </div>
            @endforeach
        </div>

        {{-- Section 3: Crawler Logs --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="list-filter" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                    <div>
                        <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Recent AI Traffic</div>
                        <div style="font-family: var(--cms-font-ui), sans-serif; font-size: 12px; color: var(--cms-fg4);">Live logs of detected AI crawlers.</div>
                    </div>
                </div>
                <form action="{{ route('admin.ai-visibility.logs.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; font-weight: 700; color: var(--cms-red); background: none; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 0.05em;">Clear Logs</button>
                </form>
            </div>
            <div style="max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse; font-family: var(--cms-font-ui), sans-serif; font-size: 13px;">
                    <thead style="background: var(--cms-bg); position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th style="padding: 12px 20px; text-align: left; font-weight: 700; color: var(--cms-fg3); border-bottom: 1px solid var(--cms-border);">Bot / Agent</th>
                            <th style="padding: 12px 20px; text-align: left; font-weight: 700; color: var(--cms-fg3); border-bottom: 1px solid var(--cms-border);">Path</th>
                            <th style="padding: 12px 20px; text-align: left; font-weight: 700; color: var(--cms-fg3); border-bottom: 1px solid var(--cms-border);">Status</th>
                            <th style="padding: 12px 20px; text-align: right; font-weight: 700; color: var(--cms-fg3); border-bottom: 1px solid var(--cms-border);">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr style="border-bottom: 1px solid var(--cms-border);">
                                <td style="padding: 12px 20px;">
                                    <div style="font-weight: 600; color: var(--cms-fg1);">{{ $log->bot_name }}</div>
                                    <div style="font-size: 11px; color: var(--cms-fg4); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;" title="{{ $log->user_agent }}">{{ $log->user_agent }}</div>
                                </td>
                                <td style="padding: 12px 20px; color: var(--cms-fg2); font-family: var(--cms-font-mono), monospace; font-size: 12px;">/{{ $log->path }}</td>
                                <td style="padding: 12px 20px;">
                                    <span @class([
                                        'log-status-badge',
                                        'log-status-badge--success' => $log->status_code == '200',
                                        'log-status-badge--error' => $log->status_code != '200',
                                    ])>
                                        {{ $log->status_code }}
                                    </span>
                                </td>
                                <td style="padding: 12px 20px; text-align: right; color: var(--cms-fg4); font-size: 12px;">{{ $log->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 40px; text-align: center; color: var(--cms-fg4);">No traffic detected yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- robots.txt Preview --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); position: sticky; top: 88px;">
        <div style="padding: 12px 16px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 7px;">
                <i data-lucide="file-text" style="width: 14px; height: 14px; color: var(--cms-gold);"></i>
                <span style="font-family: var(--cms-font-mono), monospace; font-size: 13px; font-weight: 700; color: var(--cms-fg1);">robots.txt</span>
            </div>
            <span style="font-family: var(--cms-font-ui), sans-serif; font-size: 11px; color: var(--cms-fg4);">Live preview</span>
        </div>
        <pre id="robots-preview" style="margin: 0; padding: 16px; font-family: var(--cms-font-mono), monospace; font-size: 11.5px; color: var(--cms-fg2); line-height: 1.6; background: #1A1410; white-space: pre-wrap; word-break: break-all; min-height: 300px;">{{ $robotsTxt }}</pre>
        <div style="padding: 12px 16px; border-top: 1px solid var(--cms-border);">
            <a href="/robots.txt" target="_blank"
               style="display: flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui), sans-serif; font-size: 12.5px; color: var(--cms-blue); text-decoration: none;"
               onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                <i data-lucide="external-link" style="width: 13px; height: 13px;"></i>
                View live robots.txt
            </a>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="toast" style="display: none; position: fixed; bottom: 24px; right: 24px; background: #1A1410; color: #fff; font-family: var(--cms-font-ui), sans-serif; font-size: 13.5px; font-weight: 600; padding: 12px 20px; border-radius: var(--cms-r-lg); box-shadow: var(--cms-sh-pop); z-index: 500; display: none; align-items: center; gap: 8px; animation: dsPop 200ms ease;">
    <i data-lucide="check-circle" style="width: 16px; height: 16px; color: var(--cms-green);"></i>
    <span id="toast-message">Settings saved</span>
</div>

<script>
    async function toggleBot(id, btn) {
        const isBlocked = btn.dataset.blocked === 'true';
        
        try {
            const response = await fetch("{{ route('admin.ai-visibility.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ bot_id: id })
            });

            if (response.ok) {
                const newState = !isBlocked;
                btn.dataset.blocked = newState ? 'true' : 'false';
                btn.style.background = newState ? '#C8372B' : 'var(--cms-green)';
                btn.querySelector('span').style.left = newState ? '4px' : '24px';
                
                const label = document.getElementById('bot-label-' + id);
                if (label) {
                    label.textContent = newState ? 'Blocked' : 'Allowed';
                    label.style.color = newState ? 'var(--cms-red)' : 'var(--cms-green)';
                }
                
                showToast(newState ? `Blocked ${id}` : `Allowed ${id}`);
                // Refresh robots.txt preview could be done via another AJAX or just reloading
                // For simplicity, we can reload or just update the UI state
            }
        } catch (e) {
            alert('Failed to update bot access.');
        }
    }

    async function toggleFeature(id, btn) {
        const isOn = btn.dataset.on === 'true';
        
        try {
            const response = await fetch("{{ route('admin.ai-visibility.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ feature_id: id })
            });

            if (response.ok) {
                const newState = !isOn;
                btn.dataset.on = newState ? 'true' : 'false';
                btn.style.background = newState ? 'var(--cms-green)' : 'rgba(74,66,54,0.18)';
                btn.querySelector('span').style.left = newState ? '24px' : '4px';
                
                showToast(newState ? `Enabled ${id.replace('_', ' ')}` : `Disabled ${id.replace('_', ' ')}`);
            }
        } catch (e) {
            alert('Failed to update feature.');
        }
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        const msgSpan = document.getElementById('toast-message');
        msgSpan.textContent = message;
        toast.style.display = 'flex';
        lucide.createIcons();
        setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
</script>
@endsection
