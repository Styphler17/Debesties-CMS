<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Debesties CMS')</title>
    
    <!-- Meta tags for SEO -->
    @if(isset($seo))
        <meta name="description" content="{{ $seo['meta_description'] }}">
        @if($seo['meta_keywords'])
            <meta name="keywords" content="{{ $seo['meta_keywords'] }}">
        @endif
        <link rel="canonical" href="{{ $seo['canonical_url'] }}">
        <meta property="og:title" content="{{ $seo['og_title'] }}">
        <meta property="og:description" content="{{ $seo['og_description'] }}">
        @if($seo['og_image'])
            <meta property="og:image" content="{{ $seo['og_image'] }}">
        @endif
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ request()->url() }}">
        {!! isset($seo['schema']) ? '<script type="application/ld+json">' . $seo['schema'] . '</script>' : '' !!}
    @else
        <meta name="description" content="Premium CMS Platform">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Space+Mono&display=swap" rel="stylesheet">

    <!-- Styling -->
    <style>
        :root {
            --bg-color: #F8F5F0;
            --text-color: #1A1410;
            --text-muted: #5C5448;
            --accent-gold: #E8A800;
            --accent-gold-hover: #C88C00;
            --accent-green: #1A5C2E;
            --accent-green-hover: #124020;
            --card-bg: #FFFFFF;
            --border-color: #EAE6DF;
            --shadow-sm: 0 2px 4px rgba(26, 20, 16, 0.05);
            --shadow-md: 0 4px 12px rgba(26, 20, 16, 0.08);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 16px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s ease, opacity 0.2s ease;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            line-height: 1.2;
        }

        /* Sticky Header */
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: rgba(248, 245, 240, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-color);
            white-space: nowrap;
        }

        .logo span {
            color: var(--accent-gold);
        }

        /* Navigation */
        nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-muted);
            position: relative;
            padding-bottom: 2px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 1.5px;
            bottom: 0;
            left: 0;
            background-color: var(--accent-gold);
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .nav-link:hover {
            color: var(--accent-gold);
        }

        /* Search Form */
        .search-form {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            padding-right: 2.2rem;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            background-color: var(--card-bg);
            outline: none;
            width: 180px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            width: 240px;
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 3px rgba(232, 168, 0, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 8px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
        }

        .search-btn:hover {
            color: var(--accent-gold);
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.9rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-gold {
            background-color: var(--accent-gold);
            color: #FFFFFF;
            border: none;
        }

        .btn-gold:hover {
            background-color: var(--accent-gold-hover);
            transform: translateY(-1px);
        }

        .btn-green {
            background-color: var(--accent-green);
            color: #FFFFFF;
            border: none;
        }

        .btn-green:hover {
            background-color: var(--accent-green-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .btn-outline:hover {
            background-color: rgba(26, 20, 16, 0.03);
            border-color: var(--text-color);
        }

        /* Main Layout */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
            min-height: 70vh;
        }

        /* Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: #E6F4EA;
            color: var(--accent-green);
            border: 1px solid #CEEAD6;
        }

        .alert-danger {
            background-color: #FCE8E6;
            color: #C5221F;
            border: 1px solid #FAD2CF;
        }

        /* Footer */
        footer {
            background-color: #1A1410;
            color: #F8F5F0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 4rem 1.5rem 2rem;
            margin-top: 4rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-logo span {
            color: var(--accent-gold);
        }

        .footer-text {
            font-size: 0.9rem;
            color: #A69F94;
            line-height: 1.7;
        }

        .footer-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.2rem;
            position: relative;
            padding-bottom: 0.5rem;
            color: #FFFFFF;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 2px;
            background-color: var(--accent-gold);
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            font-size: 0.9rem;
            color: #A69F94;
        }

        .footer-links a:hover {
            color: var(--accent-gold);
            padding-left: 4px;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.85rem;
            color: #7A7265;
        }

        /* Micro-animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animated-fade {
            animation: fadeIn 0.4s ease forwards;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                padding: 1rem;
                gap: 1rem;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }

            .search-input {
                width: 100%;
            }

            .search-input:focus {
                width: 100%;
            }

            .footer-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <header>
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">
                Debesties<span>.</span>
            </a>

            @php
                $headerMenu = \App\Services\MenuService::getMenu('header');
                $menuItems = $headerMenu ? $headerMenu->items : [];
                
                if (empty($menuItems)) {
                    $menuItems = \App\Models\Category::where('is_visible', true)->orderBy('sort_order')->get();
                }
            @endphp

            <nav>
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                @foreach($menuItems as $item)
                    @php
                        $url = $item instanceof \App\Models\Category ? route('categories.show', $item->slug) : $item->url;
                        $title = $item instanceof \App\Models\Category ? $item->name : $item->title;
                    @endphp
                    <a href="{{ $url }}" class="nav-link">{{ $title }}</a>
                @endforeach
            </nav>

            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <form action="{{ route('search') }}" method="GET" class="search-form">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search articles..." class="search-input" minlength="2" required>
                    <button type="submit" class="search-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                <div class="user-menu">
                    @auth
                        <span style="font-weight: 500;">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link" style="margin-right: 0.5rem;">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-gold">Join</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="animated-fade">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="alert alert-danger">
                {{ session('error') ?: $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="footer-container">
            <div>
                <div class="footer-logo">Debesties<span>.</span></div>
                <p class="footer-text">
                    {{ \App\Services\SettingsService::get('site_description', 'Premium CMS Platform') }}
                </p>
            </div>
            <div>
                <h4 class="footer-title">Explore</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                    @foreach(\App\Models\Category::where('is_visible', true)->limit(4)->get() as $cat)
                        <li><a href="{{ route('categories.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="footer-title">Connect</h4>
                <p class="footer-text" style="margin-bottom: 1rem;">
                    Stay updated with our latest editorial insights.
                </p>
                <a href="{{ route('register') }}" class="btn btn-green">Subscribe Now</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ \App\Services\SettingsService::get('site_name', 'Debesties CMS') }}. All rights reserved.</p>
            <p style="font-family: 'Space Mono', monospace; font-size: 0.8rem;">Designed for visual excellence.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
