@php
    $theme = $settings['theme'] ?? 'gold-black';
    $headline = $settings['headline'] ?? 'Welcome to Debesties';
    $subtext = $settings['subtext'] ?? 'Discover premium content curated for you.';
    $ctaLabel = $settings['cta_label'] ?? 'Explore';
    $ctaLink = $settings['cta_link'] ?? '#';

    $bgStyle = 'background: #17120D; border: 1px solid var(--border-color);';
    $titleColor = '#F8F5F0';
    $subtextColor = '#A69F94';
    $accentColor = 'var(--accent-gold)';
    $btnStyle = 'background-color: var(--accent-gold); color: #17120D;';
    $btnHoverStyle = 'background-color: var(--accent-gold-hover);';

    if ($theme === 'sunset') {
        $bgStyle = 'background: linear-gradient(135deg, #3B0066, #9900EF); border: 1px solid #7B00CC;';
        $titleColor = '#FFFFFF';
        $subtextColor = '#E2C8FA';
        $accentColor = '#FFB300';
        $btnStyle = 'background-color: #FFB300; color: #3B0066;';
        $btnHoverStyle = 'background-color: #E6A100;';
    } elseif ($theme === 'skyline') {
        $bgStyle = 'background: linear-gradient(135deg, #0A192F, #172A45); border: 1px solid #233554;';
        $titleColor = '#CCD6F6';
        $subtextColor = '#8892B0';
        $accentColor = '#64FFDA';
        $btnStyle = 'background-color: #64FFDA; color: #0A192F;';
        $btnHoverStyle = 'background-color: #52DEB8;';
    }
@endphp

<div class="homepage-hero-wrapper" style="{{ $bgStyle }} border-radius: var(--radius-lg); padding: 4rem 3rem; margin-bottom: 3.5rem; position: relative; overflow: hidden; box-shadow: var(--shadow-md);">
    <!-- Decorative background glow -->
    <div style="position: absolute; right: -50px; top: -50px; width: 250px; height: 250px; background: {{ $accentColor }}; opacity: 0.08; filter: blur(60px); border-radius: 50%;"></div>
    
    <div style="max-width: 650px; position: relative; z-index: 2;">
        <span style="font-family: 'Space Mono', monospace; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: {{ $accentColor }}; letter-spacing: 2px; margin-bottom: 1rem; display: block;">Featured Focus</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3.2rem; line-height: 1.15; color: {{ $titleColor }}; margin-bottom: 1.5rem; font-weight: 700;">{{ $headline }}</h1>
        <p style="font-size: 1.2rem; line-height: 1.7; color: {{ $subtextColor }}; margin-bottom: 2.5rem; font-weight: 300;">{{ $subtext }}</p>
        
        @if($ctaLabel)
            <a href="{{ $ctaLink }}" class="hero-cta-btn" style="{{ $btnStyle }} display: inline-flex; align-items: center; justify-content: center; padding: 0.8rem 2.2rem; border-radius: 25px; font-weight: 700; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.2s ease;">
                {{ $ctaLabel }}
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-left: 8px;"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        @endif
    </div>
</div>

<style>
    .hero-cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        opacity: 0.95;
    }
</style>
