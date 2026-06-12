@php
    $theme = $settings['theme'] ?? 'gold-black';
    $headline = $settings['headline'] ?? 'Welcome to Debesties';
    $subtext = $settings['subtext'] ?? 'Discover premium content curated for you.';
    $ctaLabel = $settings['cta_label'] ?? 'Explore';
    $ctaLink = $settings['cta_link'] ?? '#';
@endphp

<div class="homepage-hero-wrapper hero-theme-{{ $theme }}">
    <!-- Decorative background glow -->
    <div class="hero-decorative-glow"></div>
    
    <div class="hero-content-inner">
        <span class="hero-focus-span">Featured Focus</span>
        <h1 class="hero-headline-h1">{{ $headline }}</h1>
        <p class="hero-subtext-p">{{ $subtext }}</p>
        
        @if($ctaLabel)
            <a href="{{ $ctaLink }}" class="hero-cta-btn">
                {{ $ctaLabel }}
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-left: 8px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        @endif
    </div>
</div>

<style>
    .homepage-hero-wrapper {
        border-radius: var(--radius-lg);
        padding: 4rem 3rem;
        margin-bottom: 3.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    /* Theme: Gold-black */
    .hero-theme-gold-black {
        background: #17120D;
        border: 1px solid var(--border-color);
        --hero-accent: var(--accent-gold);
        --hero-title-color: #F8F5F0;
        --hero-text-color: #A69F94;
        --hero-btn-bg: var(--accent-gold);
        --hero-btn-color: #17120D;
        --hero-btn-hover-bg: var(--accent-gold-hover);
    }
    
    /* Theme: Sunset */
    .hero-theme-sunset {
        background: linear-gradient(135deg, #3B0066, #9900EF);
        border: 1px solid #7B00CC;
        --hero-accent: #FFB300;
        --hero-title-color: #FFFFFF;
        --hero-text-color: #E2C8FA;
        --hero-btn-bg: #FFB300;
        --hero-btn-color: #3B0066;
        --hero-btn-hover-bg: #E6A100;
    }

    /* Theme: Skyline */
    .hero-theme-skyline {
        background: linear-gradient(135deg, #0A192F, #172A45);
        border: 1px solid #233554;
        --hero-accent: #64FFDA;
        --hero-title-color: #CCD6F6;
        --hero-text-color: #8892B0;
        --hero-btn-bg: #64FFDA;
        --hero-btn-color: #0A192F;
        --hero-btn-hover-bg: #52DEB8;
    }

    .hero-decorative-glow {
        position: absolute;
        right: -50px;
        top: -50px;
        width: 250px;
        height: 250px;
        background: var(--hero-accent);
        opacity: 0.08;
        filter: blur(60px);
        border-radius: 50%;
    }

    .hero-content-inner {
        max-width: 650px;
        position: relative;
        z-index: 2;
    }

    .hero-focus-span {
        font-family: 'Space Mono', monospace;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--hero-accent);
        letter-spacing: 2px;
        margin-bottom: 1rem;
        display: block;
    }

    .hero-headline-h1 {
        font-family: 'Playfair Display', serif;
        font-size: 3.2rem;
        line-height: 1.15;
        color: var(--hero-title-color);
        margin-bottom: 1.5rem;
        font-weight: 700;
    }

    .hero-subtext-p {
        font-size: 1.2rem;
        line-height: 1.7;
        color: var(--hero-text-color);
        margin-bottom: 2.5rem;
        font-weight: 300;
    }

    .hero-cta-btn {
        background-color: var(--hero-btn-bg);
        color: var(--hero-btn-color);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.8rem 2.2rem;
        border-radius: 25px;
        font-weight: 700;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s ease;
    }

    .hero-cta-btn:hover {
        background-color: var(--hero-btn-hover-bg);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        opacity: 0.95;
    }
</style>
