@php
    $placeholder = $settings['placeholder'] ?? 'Your email address...';
    $cta = $settings['cta'] ?? 'Subscribe';
@endphp

<div class="homepage-newsletter-section" style="background-color: var(--card-bg); border: 1.5px solid var(--border-color); border-radius: var(--radius-lg); padding: 3rem; text-align: center; margin-bottom: 4rem; box-shadow: var(--shadow-sm); position: relative; overflow: hidden;">
    <div style="max-width: 500px; margin: 0 auto; position: relative; z-index: 2;">
        <span style="font-family: 'Space Mono', monospace; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--accent-gold); letter-spacing: 1.5px; margin-bottom: 0.8rem; display: block;">Stay Updated</span>
        <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.8rem; margin-bottom: 0.8rem; font-weight: 700;">Join the Debesties Circle</h3>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.6;">Receive weekly digests of curated culture, soundscapes, and lifestyle editorials directly to your inbox.</p>
        
        <form action="#" method="POST" style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
            <input type="email" placeholder="{{ $placeholder }}" required 
                   style="font-family: 'Outfit', sans-serif; font-size: 0.9rem; padding: 0.75rem 1.2rem; border: 1.5px solid var(--border-color); border-radius: 25px; outline: none; flex-grow: 1; min-width: 250px; background-color: var(--bg-color); transition: border-color 0.2s ease;">
            <button type="submit" class="btn btn-green" style="padding: 0.75rem 1.8rem; border-radius: 25px; font-weight: 600; font-size: 0.9rem;">
                {{ $cta }}
            </button>
        </form>
    </div>
</div>
