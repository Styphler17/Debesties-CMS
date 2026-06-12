@php
    $style = $settings['style'] ?? 'grid';
    $limit = $settings['limit'] ?? 6;
    $category = $settings['category'] ?? 'all';
    $gridClass = $style === 'masonry' ? 'homepage-masonry-grid' : 'homepage-balanced-grid';
    $sectionTitle = $category === 'all' ? 'Featured Editorial' : 'Latest in ' . ucfirst($category);
@endphp

<div class="homepage-grid-section" style="margin-bottom: 4rem;">
    <h3 class="homepage-section-title" style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.8rem; margin-bottom: 2rem; position: relative; padding-bottom: 0.5rem; font-weight: 700;">
        {{ $sectionTitle }}
        <span style="position: absolute; left: 0; bottom: 0; width: 40px; height: 3px; background-color: var(--accent-green);"></span>
    </h3>

    @if(isset($posts) && $posts->count() > 0)
        <div class="{{ $gridClass }}">
            @foreach($posts as $post)
                <article class="grid-article-card">
                    <div class="grid-card-img-container">
                        @if($post->featuredImage)
                            <img src="{{ $post->featuredImage->file_url }}" alt="{{ $post->title }}" class="grid-card-img">
                        @endif
                        <span class="grid-card-kicker">
                            @if($post->category)
                                <a href="{{ route('categories.show', $post->category->slug) }}">{{ $post->category->name }}</a>
                            @else
                                Editorial
                            @endif
                        </span>
                    </div>
                    <div class="grid-card-content">
                        <h4 class="grid-card-title">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h4>
                        <p class="grid-card-excerpt">{{ $post->excerpt ?: substr(strip_tags($post->body), 0, 120) }}...</p>
                        
                        <div class="grid-meta-row">
                            @if($post->user && $post->user->avatar)
                                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="grid-author-img">
                            @else
                                <div class="grid-author-img" style="display: flex; align-items: center; justify-content: center; background-color: var(--accent-green); color: white; font-weight: bold; font-size: 0.8rem;">
                                    {{ substr($post->user->name ?? 'D', 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight: 600; font-size: 0.85rem;">
                                    @if($post->user)
                                        <a href="{{ route('authors.show', $post->user->slug) }}">{{ $post->user->name }}</a>
                                    @else
                                        Editor
                                    @endif
                                </div>
                                <div style="font-size: 0.75rem; font-family: 'Space Mono', monospace; color: var(--text-muted);">
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 4rem 1.5rem; border: 1px dashed var(--border-color); border-radius: var(--radius-lg); background-color: var(--card-bg);">
            <p style="color: var(--text-muted); font-size: 1.1rem;">No articles matching these layout configurations exist.</p>
        </div>
    @endif
</div>

<style>
    .homepage-balanced-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
    }

    .homepage-masonry-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2.5rem;
    }
    
    @media (min-width: 992px) {
        .homepage-masonry-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        /* Make first child featured/larger in masonry mode */
        .homepage-masonry-grid > article:first-child {
            grid-column: span 2;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            min-height: 380px;
        }
        .homepage-masonry-grid > article:first-child .grid-card-img-container {
            height: 100%;
        }
    }

    .grid-article-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .grid-article-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .grid-card-img-container {
        position: relative;
        height: 200px;
        background: linear-gradient(135deg, #1A5C2E, #E8A800);
        overflow: hidden;
    }

    .grid-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .grid-article-card:hover .grid-card-img {
        transform: scale(1.05);
    }

    .grid-card-kicker {
        position: absolute;
        top: 1rem;
        left: 1rem;
        font-family: 'Space Mono', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        background-color: var(--bg-color);
        color: var(--accent-green);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        letter-spacing: 1px;
        box-shadow: var(--shadow-sm);
    }

    .grid-card-kicker a {
        color: var(--accent-green);
    }

    .grid-card-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .grid-card-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.3rem;
        margin-bottom: 0.6rem;
        line-height: 1.3;
    }

    .grid-card-excerpt {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .grid-meta-row {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        border-top: 1px solid var(--border-color);
        padding-top: 1rem;
        margin-top: auto;
    }

    .grid-author-img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        background-color: var(--border-color);
    }
</style>
