@php
    $heading = $settings['heading'] ?? 'Read by Category';
@endphp

<div class="homepage-categories-section" style="margin-bottom: 4rem;">
    <h3 class="homepage-section-title" style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.8rem; margin-bottom: 1.8rem; position: relative; padding-bottom: 0.5rem; font-weight: 700;">
        {{ $heading }}
        <span style="position: absolute; left: 0; bottom: 0; width: 40px; height: 3px; background-color: var(--accent-green);"></span>
    </h3>

    @if(isset($categories) && $categories->count() > 0)
        <div class="homepage-categories-list" style="display: flex; gap: 1rem; flex-wrap: wrap;">
            @foreach($categories as $cat)
                <a href="{{ route('categories.show', $cat->slug) }}" class="category-badge-card">
                    <span class="cat-card-name">{{ $cat->name }}</span>
                    @if($cat->posts_count !== null)
                        <span class="cat-card-count">{{ $cat->posts_count }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 2rem 1.5rem; border: 1px dashed var(--border-color); border-radius: var(--radius-lg); background-color: var(--card-bg);">
            <p style="color: var(--text-muted); font-size: 0.95rem;">No categories available.</p>
        </div>
    @endif
</div>

<style>
    .category-badge-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 0.5rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
    }

    .category-badge-card:hover {
        border-color: var(--accent-green);
        color: var(--accent-green);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .cat-card-count {
        font-family: 'Space Mono', monospace;
        font-size: 0.75rem;
        background-color: var(--bg-color);
        padding: 0.1rem 0.5rem;
        border-radius: 10px;
        color: var(--text-muted);
    }
</style>
