@extends('admin.layouts.app')

@section('title', 'AI Visibility — Debesties Studio')
@section('page_title', 'AI Visibility')

@section('content')
@php
    $bots = [
        ['id'=>'gptbot',      'name'=>'GPTBot',         'owner'=>'OpenAI',      'blocked'=>false, 'icon'=>'🤖'],
        ['id'=>'google-ext',  'name'=>'Google-Extended', 'owner'=>'Google',      'blocked'=>false, 'icon'=>'🔍'],
        ['id'=>'perplexity',  'name'=>'PerplexityBot',   'owner'=>'Perplexity',  'blocked'=>true,  'icon'=>'🔮'],
        ['id'=>'claudebot',   'name'=>'ClaudeBot',       'owner'=>'Anthropic',   'blocked'=>false, 'icon'=>'🧠'],
        ['id'=>'anthropic',   'name'=>'anthropic-ai',    'owner'=>'Anthropic',   'blocked'=>false, 'icon'=>'🧠'],
        ['id'=>'ccbot',       'name'=>'CCBot',           'owner'=>'Common Crawl','blocked'=>true,  'icon'=>'🕷'],
    ];

    $robots = "User-agent: *\nAllow: /\n\n# AI Crawlers\nUser-agent: CCBot\nDisallow: /\n\nUser-agent: PerplexityBot\nDisallow: /\n\nSitemap: https://debesties.com/sitemap.xml";
@endphp

{{-- Header Banner --}}
<div style="background: linear-gradient(135deg, rgba(74,66,54,0.06) 0%, rgba(232,168,0,0.06) 100%); border: 1px solid rgba(232,168,0,0.2); border-radius: var(--cms-r-xl); padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
    <div style="width: 48px; height: 48px; border-radius: var(--cms-r-lg); background: linear-gradient(135deg, var(--cms-gold), #FF8C42); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px;">🤖</div>
    <div>
        <div style="font-family: var(--cms-font-disp); font-size: 18px; font-weight: 700; color: var(--cms-fg1); margin-bottom: 4px;">AI Crawler Access Control</div>
        <div style="font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg3);">Control how AI search engines — Perplexity, ChatGPT, Gemini, Claude — index and use your content. Changes update <code style="font-family: var(--cms-font-mono); background: rgba(74,66,54,0.08); padding: 1px 5px; border-radius: 4px; font-size: 11.5px;">robots.txt</code> in real time.</div>
    </div>
    <div style="margin-left: auto; flex-shrink: 0;">
        <button id="save-btn" onclick="saveSettings()"
                style="display: inline-flex; align-items: center; gap: 8px; height: 40px; padding: 0 20px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer;"
                onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
            <i data-lucide="save" style="width: 15px; height: 15px;"></i>
            Save Changes
        </button>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start;">

    <div style="display: flex; flex-direction: column; gap: 16px;">

        {{-- Section 1: Bot Access --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 10px;">
                <i data-lucide="shield" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                <div>
                    <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">LLM Crawler Access</div>
                    <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">Toggle access per AI bot. Blocked bots are added to robots.txt Disallow.</div>
                </div>
            </div>
            @foreach($bots as $bot)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                     onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; border-radius: var(--cms-r-md); background: var(--cms-bg); border: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">{{ $bot['icon'] }}</div>
                        <div>
                            <div style="font-family: var(--cms-font-mono); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $bot['name'] }}</div>
                            <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">{{ $bot['owner'] }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span id="bot-label-{{ $bot['id'] }}" style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: {{ $bot['blocked'] ? 'var(--cms-red)' : 'var(--cms-green)' }};">
                            {{ $bot['blocked'] ? 'Blocked' : 'Allowed' }}
                        </span>
                        <button onclick="toggleBot('{{ $bot['id'] }}', this)"
                                data-blocked="{{ $bot['blocked'] ? 'true' : 'false' }}"
                                style="width: 48px; height: 26px; border-radius: 999px; border: none; cursor: pointer; position: relative; transition: background 220ms; background: {{ $bot['blocked'] ? '#C8372B' : 'var(--cms-green)' }}; flex-shrink: 0;">
                            <span style="position: absolute; top: 3px; width: 20px; height: 20px; border-radius: 999px; background: #fff; transition: left 220ms; left: {{ $bot['blocked'] ? '4px' : '24px' }};"></span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Section 2: Sitemap --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 10px;">
                <i data-lucide="map" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                <div>
                    <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Sitemap Visibility</div>
                    <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">Control what's exposed in <code style="font-size: 11px; font-family: var(--cms-font-mono);">sitemap.xml</code> and the LLM-oriented <code style="font-size: 11px; font-family: var(--cms-font-mono);">llms.txt</code></div>
                </div>
            </div>
            @php
                $sitemapToggles = [
                    ['id'=>'llms-txt',  'label'=>'Include in llms.txt',              'sub'=>'Machine-readable index for LLM crawlers',             'on'=>true],
                    ['id'=>'ai-sitemap','label'=>'Generate AI-specific sitemap',       'sub'=>'Separate XML sitemap for AI indexing bots',           'on'=>false],
                    ['id'=>'noindex',   'label'=>'Block AI content reuse (noai tag)', 'sub'=>'Adds machine-readable noai signal to HTML head',      'on'=>false],
                ];
            @endphp
            @foreach($sitemapToggles as $t)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--cms-border);">
                    <div>
                        <div style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $t['label'] }}</div>
                        <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4); margin-top: 2px;">{{ $t['sub'] }}</div>
                    </div>
                    <button onclick="toggleFeature('{{ $t['id'] }}', this)" data-on="{{ $t['on'] ? 'true' : 'false' }}"
                            style="width: 48px; height: 26px; border-radius: 999px; border: none; cursor: pointer; position: relative; transition: background 220ms; background: {{ $t['on'] ? 'var(--cms-green)' : 'rgba(74,66,54,0.18)' }}; flex-shrink: 0;">
                        <span style="position: absolute; top: 3px; width: 20px; height: 20px; border-radius: 999px; background: #fff; transition: left 220ms; left: {{ $t['on'] ? '24px' : '4px' }};"></span>
                    </button>
                </div>
            @endforeach
        </div>

        {{-- Section 3: Content Signals --}}
        <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
            <div style="padding: 14px 20px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; gap: 10px;">
                <i data-lucide="code-2" style="width: 16px; height: 16px; color: var(--cms-gold);"></i>
                <div>
                    <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 700; color: var(--cms-fg1);">Content Signals</div>
                    <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4);">Structured data schemas that help AI understand your content</div>
                </div>
            </div>
            @php
                $signals = [
                    ['id'=>'faq-schema',     'label'=>'FAQ Schema (JSON-LD)',      'sub'=>'Outputs PostFaq data as structured FAQ schema',     'on'=>true],
                    ['id'=>'key-facts',      'label'=>'Key Facts JSON-LD',         'sub'=>'Outputs PostKeyFacts as machine-readable data',    'on'=>true],
                    ['id'=>'article-schema', 'label'=>'Article Schema',            'sub'=>'Outputs post as Article/NewsArticle schema type',  'on'=>true],
                    ['id'=>'breadcrumb',     'label'=>'BreadcrumbList Schema',     'sub'=>'Adds breadcrumb structured data to article pages','on'=>false],
                ];
            @endphp
            @foreach($signals as $s)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--cms-border);">
                    <div>
                        <div style="font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; color: var(--cms-fg1);">{{ $s['label'] }}</div>
                        <div style="font-family: var(--cms-font-ui); font-size: 12px; color: var(--cms-fg4); margin-top: 2px;">{{ $s['sub'] }}</div>
                    </div>
                    <button onclick="toggleFeature('{{ $s['id'] }}', this)" data-on="{{ $s['on'] ? 'true' : 'false' }}"
                            style="width: 48px; height: 26px; border-radius: 999px; border: none; cursor: pointer; position: relative; transition: background 220ms; background: {{ $s['on'] ? 'var(--cms-green)' : 'rgba(74,66,54,0.18)' }}; flex-shrink: 0;">
                        <span style="position: absolute; top: 3px; width: 20px; height: 20px; border-radius: 999px; background: #fff; transition: left 220ms; left: {{ $s['on'] ? '24px' : '4px' }};"></span>
                    </button>
                </div>
            @endforeach
        </div>

    </div>

    {{-- robots.txt Preview --}}
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card); position: sticky; top: 88px;">
        <div style="padding: 12px 16px; border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 7px;">
                <i data-lucide="file-text" style="width: 14px; height: 14px; color: var(--cms-gold);"></i>
                <span style="font-family: var(--cms-font-mono); font-size: 13px; font-weight: 700; color: var(--cms-fg1);">robots.txt</span>
            </div>
            <span style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4);">Live preview</span>
        </div>
        <pre id="robots-preview" style="margin: 0; padding: 16px; font-family: var(--cms-font-mono); font-size: 11.5px; color: var(--cms-fg2); line-height: 1.6; background: #1A1410; white-space: pre-wrap; word-break: break-all;">{{ $robots }}</pre>
        <div style="padding: 12px 16px; border-top: 1px solid var(--cms-border);">
            <a href="https://debesties.com/robots.txt" target="_blank"
               style="display: flex; align-items: center; gap: 6px; font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-blue); text-decoration: none;"
               onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                <i data-lucide="external-link" style="width: 13px; height: 13px;"></i>
                View live robots.txt
            </a>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="toast" style="display: none; position: fixed; bottom: 24px; right: 24px; background: #1A1410; color: #fff; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; padding: 12px 20px; border-radius: var(--cms-r-lg); box-shadow: var(--cms-sh-pop); z-index: 500; display: none; align-items: center; gap: 8px; animation: dsPop 200ms ease;">
    <i data-lucide="check-circle" style="width: 16px; height: 16px; color: var(--cms-green);"></i>
    <span>AI visibility settings saved</span>
</div>

<script>
    function toggleBot(id, btn) {
        const isBlocked = btn.dataset.blocked === 'true';
        btn.dataset.blocked = isBlocked ? 'false' : 'true';
        btn.style.background = isBlocked ? 'var(--cms-green)' : '#C8372B';
        btn.querySelector('span').style.left = isBlocked ? '24px' : '4px';
        const label = document.getElementById('bot-label-' + id);
        if (label) {
            label.textContent = isBlocked ? 'Allowed' : 'Blocked';
            label.style.color = isBlocked ? 'var(--cms-green)' : 'var(--cms-red)';
        }
    }

    function toggleFeature(id, btn) {
        const isOn = btn.dataset.on === 'true';
        btn.dataset.on = isOn ? 'false' : 'true';
        btn.style.background = isOn ? 'rgba(74,66,54,0.18)' : 'var(--cms-green)';
        btn.querySelector('span').style.left = isOn ? '4px' : '24px';
    }

    function saveSettings() {
        const toast = document.getElementById('toast');
        toast.style.display = 'flex';
        lucide.createIcons();
        setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
</script>
@endsection
