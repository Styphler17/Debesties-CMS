@extends('public.layouts.app')

@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $posts */
@endphp

@section('title', \App\Services\SettingsService::get('site_name', 'Debesties CMS') . ' - Home')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        margin-bottom: 4rem;
    }

    .featured-card {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        background-color: transparent;
        border: none;
        border-radius: 0;
        overflow: visible;
        box-shadow: none;
        gap: 2rem;
        align-items: center;
    }

    .featured-img-container {
        position: relative;
        min-height: 440px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        background: linear-gradient(135deg, #1A5C2E, #E8A800);
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.6s ease;
    }

    .featured-card:hover .featured-img-container {
        transform: scale(1.01) translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .featured-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .featured-content {
        padding: 3rem;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        margin-left: -5rem;
        z-index: 10;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.6s ease;
    }

    .featured-card:hover .featured-content {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .kicker {
        font-family: 'Space Mono', monospace;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--accent-gold);
        letter-spacing: 1.5px;
        margin-bottom: 1rem;
    }

    .featured-title {
        font-size: 2.5rem;
        color: var(--text-color);
        margin-bottom: 1rem;
    }

    .featured-excerpt {
        color: var(--text-muted);
        font-size: 1.05rem;
        margin-bottom: 2rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
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

    /* Grid Section */
    .section-title {
        font-size: 1.8rem;
        margin-bottom: 2rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background-color: var(--accent-green);
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
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.6s ease;
    }

    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .card-img-container {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, #1A5C2E, #E8A800);
    }

    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .article-card:hover .card-img {
        transform: scale(1.04);
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

    .card-title a, .featured-title a {
        position: relative;
        transition: color 0.3s ease;
    }

    .card-title a::after, .featured-title a::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 1.5px;
        bottom: -2px;
        left: 0;
        background-color: var(--accent-gold);
        transform-origin: bottom right;
        transition: transform 0.25s ease-out;
    }

    .article-card:hover .card-title a::after,
    .featured-card:hover .featured-title a::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }

    .article-card:hover .card-title a,
    .featured-card:hover .featured-title a {
        color: var(--accent-gold);
    }

    .card-excerpt {
        color: var(--text-muted);
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Pagination */
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

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .featured-card {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .featured-img-container {
            min-height: 300px;
        }
        .featured-content {
            margin-left: 0;
            padding: 2rem;
            margin-top: -3rem;
        }
    }
</style>
@section('content')

    @if(isset($widgets) && count($widgets) > 0)
        @foreach($widgets as $widget)
            @include('public.components.homepage.' . $widget['type'], [
                'settings' => $widget['settings'],
                'posts' => $widget['posts'] ?? collect(),
                'categories' => $widget['categories'] ?? collect()
            ])
        @endforeach
    @else
        <!-- Hero Section -->
        @if($featuredPost)
            <div class="hero-section">
                <article class="featured-card">
                    <div class="featured-img-container">
                        @if($featuredPost->featuredImage)
                            <img src="{{ $featuredPost->featuredImage->file_url }}" alt="{{ $featuredPost->title }}" class="featured-img">
                        @endif
                    </div>
                    <div class="featured-content">
                        <span class="kicker">
                            @if($featuredPost->category)
                                <a href="{{ route('categories.show', $featuredPost->category->slug) }}" style="color: var(--accent-green);">{{ $featuredPost->category->name }}</a>
                            @else
                                Featured Post
                            @endif
                        </span>
                        <h2 class="featured-title">
                            <a href="{{ route('posts.show', $featuredPost->slug) }}">{{ $featuredPost->title }}</a>
                        </h2>
                        <p class="featured-excerpt">{{ $featuredPost->excerpt ?: substr(strip_tags($featuredPost->body), 0, 180) }}...</p>
                        
                        <div class="meta-row">
                            @if($featuredPost->user && $featuredPost->user->avatar)
                                <img src="{{ $featuredPost->user->avatar }}" alt="{{ $featuredPost->user->name }}" class="author-img">
                            @else
                                <div class="author-img" style="display: flex; align-items: center; justify-content: center; background-color: var(--accent-green); color: white; font-weight: bold; font-size: 0.8rem;">
                                    {{ substr($featuredPost->user->name ?? 'D', 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight: 600;">
                                    @if($featuredPost->user)
                                        <a href="{{ route('authors.show', $featuredPost->user->slug) }}">{{ $featuredPost->user->name }}</a>
                                    @else
                                        Editor
                                    @endif
                                </div>
                                <div style="font-size: 0.8rem; font-family: 'Space Mono', monospace;">
                                    {{ $featuredPost->published_at ? $featuredPost->published_at->format('M d, Y') : $featuredPost->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @endif

        <!-- Articles Grid -->
        <div style="margin-top: 4rem;">
            <h3 class="section-title">Latest Editorial</h3>
            
            @if(count($posts) > 0)
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
                                    @if($post->user && $post->user->avatar)
                                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="author-img">
                                    @else
                                        <div class="author-img" style="display: flex; align-items: center; justify-content: center; background-color: var(--accent-green); color: white; font-weight: bold; font-size: 0.8rem;">
                                            {{ substr($post->user->name ?? 'D', 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 500;">
                                            @if($post->user)
                                                <a href="{{ route('authors.show', $post->user->slug) }}">{{ $post->user->name }}</a>
                                            @else
                                                Editor
                                            @endif
                                        </div>
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
                    <p style="color: var(--text-muted); font-size: 1.1rem;">No articles available yet. Check back soon!</p>
                </div>
            @endif
        </div>
    @endif

@endsection
