@extends('public.layouts.app')

@section('title', $page->title . ' - ' . \App\Services\SettingsService::get('site_name', 'Debesties CMS'))

@section('styles')
<style>
    .page-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .page-header {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 2rem;
        margin-bottom: 3rem;
        text-align: center;
    }

    .page-title {
        font-size: 3rem;
        color: var(--text-color);
        margin-bottom: 1rem;
        font-family: 'Playfair Display', Georgia, serif;
    }

    .page-meta {
        font-family: 'Space Mono', monospace;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 1.5px;
    }

    .page-body {
        font-size: 1.15rem;
        line-height: 1.8;
        color: var(--text-color);
    }

    .page-body p {
        margin-bottom: 1.8rem;
    }

    .page-body h2 {
        font-size: 1.8rem;
        margin: 2.5rem 0 1rem;
        color: var(--accent-green);
    }

    .page-body h3 {
        font-size: 1.4rem;
        margin: 2rem 0 1rem;
        color: var(--text-color);
    }

    .page-body ul, .page-body ol {
        margin-bottom: 1.8rem;
        padding-left: 2rem;
    }

    .page-body li {
        margin-bottom: 0.5rem;
    }

    .page-body blockquote {
        border-left: 4px solid var(--accent-gold);
        padding-left: 1.5rem;
        margin: 2rem 0;
        font-style: italic;
        color: var(--text-muted);
    }

    .page-body img {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius-md);
        margin: 2rem 0;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2.2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <header class="page-header">
        <h1 class="page-title">{{ $page->title }}</h1>
        <div class="page-meta">
            <span>Last Updated {{ $page->updated_at->format('M d, Y') }}</span>
        </div>
    </header>

    <article class="page-body">
        {!! $page->body !!}
    </article>
</div>
@endsection
