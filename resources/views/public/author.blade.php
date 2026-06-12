@extends('public.layouts.app')

@section('title', 'Author: ' . $user->name . ' - ' . \App\Services\SettingsService::get('site_name', 'Debesties CMS'))

@section('styles')
<style>
    .author-header {
        background-color: #F0EDE6;
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 4rem;
        border: 1px solid var(--border-color);
    }

    .author-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        background-color: var(--border-color);
    }

    .author-details h1 {
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
    }

    .author-details p {
        font-size: 1.05rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 0.8rem;
    }

    .author-meta {
        font-family: 'Space Mono', monospace;
        font-size: 0.8rem;
        color: var(--accent-green);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .kicker {
        font-family: 'Space Mono', monospace;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--accent-gold);
        letter-spacing: 1.5px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2.5rem;
    }

    .article-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .card-img-container {
        position: relative;
        height: 220px;
        background: linear-gradient(135deg, #1A5C2E, #E8A800);
    }

    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-content {
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title {
        font-size: 1.4rem;
        margin-bottom: 0.8rem;
    }

    .card-excerpt {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .meta-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.9rem;
        color: var(--text-muted);
        border-top: 1px solid var(--border-color);
        padding-top: 1.5rem;
        margin-top: auto;
    }

    .author-img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        background-color: var(--border-color);
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1.5rem;
        margin-top: 4rem;
    }

    .page-link {
        padding: 0.6rem 1.4rem;
        border: 1px solid var(--border-color);
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        background-color: var(--card-bg);
    }

    .page-link:not(.disabled):hover {
        border-color: var(--accent-gold);
        color: var(--accent-gold);
    }

    .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-info {
        font-family: 'Space Mono', monospace;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .author-header {
            flex-direction: column;
            text-align: center;
            padding: 2rem 1.5rem;
        }
    }
</style>
@endsection

@section('content')

    <!-- Author Header -->
    <div class="author-header">
        @if($user->avatar)
            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="author-avatar">
        @else
            <div class="author-avatar" style="display: flex; align-items: center; justify-content: center; background-color: var(--accent-green); color: white; font-weight: bold; font-size: 2rem;">
                {{ substr($user->name, 0, 1) }}
            </div>
        @endif
        <div class="author-details">
            <span class="kicker">Author Profile</span>
            <h1>{{ $user->name }}</h1>
            <p>{{ $user->bio ?: 'Contributor and editorial writer for Debesties.' }}</p>
            <div class="author-meta">{{ $posts->total() }} Articles Published</div>
        </div>
    </div>

    <!-- Articles Grid -->
    <h3 style="font-size: 1.5rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Articles by {{ $user->name }}</h3>
    @if($posts->count() > 0)
        <div class="articles-grid">
            @foreach($posts as $post)
                <article class="article-card">
                    <div class="card-img-container">
                        @if($post->featuredImage)
                            <img src="{{ $post->featuredImage->file_url }}" alt="{{ $post->title }}" class="card-img">
                        @endif
                    </div>
                    <div class="card-content">
                        <span class="kicker">
                            @if($post->category)
                                <a href="{{ route('categories.show', $post->category->slug) }}" style="color: var(--accent-green);">{{ $post->category->name }}</a>
                            @else
                                Article
                            @endif
                        </span>
                        <h4 class="card-title">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h4>
                        <p class="card-excerpt">{{ $post->excerpt ?: substr(strip_tags($post->body), 0, 120) }}...</p>
                        
                        <div class="meta-row">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="author-img">
                            @else
                                <div class="author-img" style="display: flex; align-items: center; justify-content: center; background-color: var(--accent-green); color: white; font-weight: bold; font-size: 0.8rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight: 500;">{{ $user->name }}</div>
                                <div style="font-size: 0.8rem; font-family: 'Space Mono', monospace;">
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Custom Pagination Links -->
        @if($posts->hasPages())
            <div class="pagination">
                @if($posts->onFirstPage())
                    <span class="page-link disabled">&larr; Previous</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="page-link">&larr; Previous</a>
                @endif

                <span class="page-info">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>

                @if($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="page-link">Next &rarr;</a>
                @else
                    <span class="page-link disabled">Next &rarr;</span>
                @endif
            </div>
        @endif
    @else
        <div style="text-align: center; padding: 4rem 1.5rem; border: 1px dashed var(--border-color); border-radius: var(--radius-lg); background-color: var(--card-bg);">
            <p style="color: var(--text-muted); font-size: 1.1rem;">No articles published by this author yet.</p>
        </div>
    @endif

@endsection
