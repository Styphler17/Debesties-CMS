<div class="homepage-news-strip" style="background-color: #17120D; border-radius: var(--radius-md); padding: 0.8rem 1.5rem; margin-bottom: 3.5rem; overflow: hidden; display: flex; align-items: center; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
    <div class="strip-label" style="font-family: 'Space Mono', monospace; font-size: 0.75rem; font-weight: 700; color: var(--accent-gold); text-transform: uppercase; letter-spacing: 1.5px; border-right: 1.5px solid rgba(255,255,255,0.15); padding-right: 1rem; margin-right: 1rem; white-space: nowrap; display: flex; align-items: center; gap: 6px;">
        <span style="display: inline-block; width: 6px; height: 6px; background-color: var(--accent-gold); border-radius: 50%; animation: pulse-glow 1.5s infinite;"></span>
        Latest News
    </div>
    
    @if(isset($posts) && count($posts) > 0)
        <div class="strip-marquee-container" style="flex-grow: 1; overflow: hidden; position: relative;">
            <div class="strip-marquee-wrapper" style="display: flex; gap: 2.5rem; animation: marquee-scroll 20s linear infinite; white-space: nowrap;">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="strip-post-link" style="color: #CCD6F6; font-size: 0.9rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                        <span style="color: var(--accent-gold);">•</span>
                        {{ $post->title }}
                    </a>
                @endforeach
                <!-- Duplicate for seamless looping if there are enough items -->
                @if(count($posts) >= 3)
                    @foreach($posts as $post)
                        <a href="{{ route('posts.show', $post->slug) }}" class="strip-post-link" style="color: #CCD6F6; font-size: 0.9rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                            <span style="color: var(--accent-gold);">•</span>
                            {{ $post->title }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    @else
        <span style="color: #A69F94; font-size: 0.85rem;">No publications at this moment.</span>
    @endif
</div>

<style>
    @keyframes pulse-glow {
        0% { opacity: 0.3; }
        50% { opacity: 1; }
        100% { opacity: 0.3; }
    }

    @keyframes marquee-scroll {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-50%); }
    }

    .strip-marquee-container:hover .strip-marquee-wrapper {
        animation-play-state: paused;
    }

    .strip-post-link:hover {
        color: var(--accent-gold) !important;
        text-decoration: underline;
    }
</style>
