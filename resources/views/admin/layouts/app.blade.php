<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Debesties Studio — Publishing CMS')</title>
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,400&family=Outfit:wght@300;400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
    
    <!-- Inline styles to support collapse transitions -->
    <style>
        .cms-sidebar {
            transition: width 200ms cubic-bezier(0.25, 0, 0, 1) !important;
        }
        .cms-sidebar.collapsed {
            width: 72px !important;
        }
        .cms-sidebar.collapsed .sidebar-label,
        .cms-sidebar.collapsed .group-title,
        .cms-sidebar.collapsed .sidebar-logo-text,
        .cms-sidebar.collapsed .sidebar-badge,
        .cms-sidebar.collapsed .sidebar-count,
        .cms-sidebar.collapsed .sidebar-footer-text,
        .cms-sidebar.collapsed .sidebar-footer-arrow {
            display: none !important;
        }
        .cms-sidebar.collapsed .sidebar-link {
            justify-content: center !important;
            padding: 10px !important;
        }
        .cms-sidebar.collapsed .logo-container {
            padding: 0 16px !important;
            justify-content: center !important;
        }
        .cms-sidebar.collapsed .user-footer-container {
            justify-content: center !important;
            padding: 8px 0 !important;
        }
        .sidebar-link {
            background: transparent;
            color: rgba(255, 255, 255, 0.66);
            border: none;
            cursor: pointer;
            transition: background 140ms, color 140ms;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: rgba(255, 255, 255, 0.92) !important;
        }
        .sidebar-link.active {
            background: rgba(232, 168, 0, 0.14) !important;
            color: var(--cms-gold) !important;
            font-weight: 600;
        }
        .cms-sidebar.collapsed .sidebar-logo-full {
            display: none !important;
        }
        .cms-sidebar.collapsed .sidebar-logo-icon {
            display: block !important;
        }
    </style>
</head>
<body style="height: 100%;">
    <div style="display: flex; min-height: 100vh; background: var(--cms-bg);">
        
        <!-- Mobile Backdrop -->
        <div id="mobile-backdrop" onclick="toggleMobileSidebar(false)" style="position: fixed; inset: 0; background: rgba(20,16,12,0.5); zIndex: 90; display: none; animation: dsFade 160ms ease;" class="cms-mobile-backdrop"></div>

        <!-- Sidebar Navigation -->
        <aside id="cms-sidebar" class="cms-sidebar" style="width: 248px; background: var(--cms-sidebar); height: 100vh; position: sticky; top: 0; display: flex; flex-direction: column; flex-shrink: 0; z-index: 95; border-right: 1px solid rgba(255,255,255,0.06);">
            <!-- Logo Section -->
            <div class="logo-container" style="height: 64px; display: flex; align-items: center; gap: 10px; padding: 0 20px; flex-shrink: 0; border-bottom: 1px solid rgba(255,255,255,0.06);">
                <img class="sidebar-logo-icon" src="{{ asset('favicon-96x96.png') }}" style="width: 32px; height: 32px; flex-shrink: 0; display: none;" alt="debesties icon">
                <img class="sidebar-logo-full" src="{{ asset('logo.png') }}" style="height: 28px; width: auto; max-width: 100%; display: block;" alt="debesties logo">
            </div>

            <!-- Navigation Links -->
            <nav style="flex: 1; overflow-y: auto; padding: 14px 12px; display: flex; flex-direction: column; gap: 4px;" class="cms-nav-scroll">
                
                @php
                    $navGroups = [
                        'Overview' => [
                            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => 'admin.dashboard'],
                            ['key' => 'analytics', 'label' => 'Analytics', 'icon' => 'bar-chart-2', 'route' => 'admin.analytics.index'],
                            ['key' => 'calendar', 'label' => 'Editorial Calendar', 'icon' => 'calendar', 'route' => 'admin.calendar.index'],
                        ],
                        'Content' => [
                            ['key' => 'posts', 'label' => 'Posts', 'icon' => 'file-text', 'route' => 'admin.posts.index', 'count' => 248],
                            ['key' => 'pages', 'label' => 'Pages', 'icon' => 'file', 'route' => 'admin.pages.index'],
                            ['key' => 'categories', 'label' => 'Categories', 'icon' => 'folder', 'route' => 'admin.categories.index'],
                            ['key' => 'tags', 'label' => 'Tags', 'icon' => 'tag', 'route' => 'admin.tags.index'],
                            ['key' => 'media', 'label' => 'Media Library', 'icon' => 'image', 'route' => 'admin.media.index'],
                            ['key' => 'comments', 'label' => 'Comments', 'icon' => 'message-square', 'route' => 'admin.comments.index', 'count' => 12],
                            ['key' => 'newsletters', 'label' => 'Newsletters', 'icon' => 'mail', 'route' => 'admin.newsletters.index'],
                        ],
                        'Optimize' => [
                            ['key' => 'seo', 'label' => 'SEO Tools', 'icon' => 'search', 'route' => 'admin.seo.index'],
                            ['key' => 'ai', 'label' => 'AI Visibility', 'icon' => 'sparkles', 'route' => 'admin.ai-visibility.index', 'badge' => 'AI'],
                        ],
                        'Site' => [
                            ['key' => 'navbuilder', 'label' => 'Navigation Builder', 'icon' => 'list', 'route' => 'admin.menus.index'],
                            ['key' => 'homebuilder', 'label' => 'Homepage Builder', 'icon' => 'home', 'route' => 'admin.homepage-builder.index'],
                            ['key' => 'users', 'label' => 'Users & Roles', 'icon' => 'users', 'route' => 'admin.users.index'],
                            ['key' => 'settings', 'label' => 'Site Settings', 'icon' => 'settings', 'route' => 'admin.settings.index'],
                        ]
                    ];
                @endphp

                @foreach($navGroups as $groupName => $items)
                    <div style="margin-bottom: 10px;">
                        <div class="group-title" style="font-family: var(--cms-font-ui); font-size: 10.5px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.32); padding: 6px 10px 4px;">{{ $groupName }}</div>
                        
                        @foreach($items as $item)
                            @php
                                $isActive = request()->routeIs($item['route']) || (request()->routeIs(explode('.', $item['route'])[0] . '.*') && !in_array($item['key'], ['calendar', 'seo', 'ai', 'navbuilder', 'homebuilder', 'settings', 'pages']));
                            @endphp
                            
                            <a href="{{ route($item['route']) }}" class="sidebar-link {{ $isActive ? 'active' : '' }}" style="display: flex; align-items: center; gap: 11px; width: 100%; padding: 9px 10px; border-radius: var(--cms-r-md); margin-bottom: 1px; font-family: var(--cms-font-ui); font-size: 13.5px; text-decoration: none; position: relative;">
                                @if($isActive)
                                    <span class="active-indicator" style="position: absolute; left: -12px; top: 8px; bottom: 8px; width: 3px; border-radius: 999px; background: var(--cms-gold);"></span>
                                @endif
                                <i data-lucide="{{ $item['icon'] }}" style="width: 18px; height: 18px; stroke-width: 2;"></i>
                                <span class="sidebar-label" style="flex: 1; text-align: left;">{{ $item['label'] }}</span>
                                
                                @if(isset($item['count']))
                                    <span class="sidebar-count" style="font-family: var(--cms-font-ui); font-size: 11px; font-weight: 700; color: {{ $isActive ? 'var(--cms-gold)' : 'rgba(255,255,255,0.4)' }}; background: rgba(255,255,255,0.06); padding: 1px 7px; border-radius: 999px;">{{ $item['count'] }}</span>
                                @endif
                                
                                @if(isset($item['badge']))
                                    <span class="sidebar-badge" style="font-family: var(--cms-font-ui); font-size: 9.5px; font-weight: 800; letter-spacing: 0.05em; color: #fff; background: linear-gradient(120deg, var(--cms-ai-from), var(--cms-ai-to)); padding: 2px 6px; border-radius: 999px;">{{ $item['badge'] }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endforeach

            </nav>

            <!-- User profile footer -->
            <div style="padding: 12px; border-top: 1px solid rgba(255,255,255,0.06); flex-shrink: 0;">
                <div class="user-footer-container" style="display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: var(--cms-r-md); cursor: pointer;"
                     onmouseover="this.style.background='rgba(255,255,255,0.05)'"
                     onmouseout="this.style.background='transparent'">
                    <!-- Initials Avatar -->
                    <div style="width: 34px; height: 34px; border-radius: 999px; background: rgba(232, 168, 0, 0.22); color: var(--cms-gold); display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 700; flex-shrink: 0; border: 1.5px solid rgba(232, 168, 0, 0.33);">
                        @php
                            $initials = collect(explode(' ', Auth::user()->name))->map(fn($n) => substr($n, 0, 1))->join('');
                        @endphp
                        {{ $initials }}
                    </div>
                    <div class="sidebar-footer-text" style="flex: 1; overflow: hidden;">
                        <div style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</div>
                        <div style="font-family: var(--cms-font-ui); font-size: 11px; color: rgba(255,255,255,0.4)">{{ Auth::user()->roles->first()->name ?? 'User' }}</div>
                    </div>
                    <i data-lucide="chevron-down" class="sidebar-footer-arrow" style="width: 15px; height: 15px; color: rgba(255,255,255,0.4);"></i>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div style="flex: 1; min-width: 0; display: flex; flex-direction: column;">
            
            <!-- Topbar Header -->
            <header style="height: 64px; background: rgba(244,241,236,0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid var(--cms-border); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; gap: 16px; position: sticky; top: 0; z-index: 80; flex-shrink: 0;">
                <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                    <button onclick="toggleSidebarCollapse()" class="cms-desktop-only" style="border: none; background: none; cursor: pointer; color: var(--cms-fg3); display: flex; padding: 6px; border-radius: 8px;" title="Toggle sidebar">
                        <i data-lucide="panel-left" style="width: 20px; height: 20px;"></i>
                    </button>
                    <button onclick="toggleMobileSidebar(true)" class="cms-mobile-only" style="border: none; background: none; cursor: pointer; color: var(--cms-fg2); display: none; padding: 6px;">
                        <i data-lucide="menu" style="width: 22px; height: 22px;"></i>
                    </button>
                    <div style="min-width: 0;">
                        <h1 style="font-family: var(--cms-font-disp); font-size: 21px; font-weight: 700; color: var(--cms-fg1); margin: 0; letter-spacing: -0.01em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            @yield('page_title', 'Dashboard')
                        </h1>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                    <!-- Search Input -->
                    <div class="cms-search-hide" style="display: flex; align-items: center; gap: 8px; width: 240px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px; transition: border-color 140ms;" onfocusin="this.style.borderColor='var(--cms-gold)'; this.style.boxShadow='0 0 0 3px rgba(232, 168, 0, 0.13)';" onfocusout="this.style.borderColor='var(--cms-border)'; this.style.boxShadow='none';">
                        <i data-lucide="search" style="width: 16px; height: 16px; color: var(--cms-fg4);"></i>
                        <input placeholder="Search posts, media…" style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); min-width: 0;" />
                    </div>

                    <!-- Notification Bell Dropdown -->
                    <div style="position: relative;">
                        <button onclick="toggleNotifications()" style="border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; color: var(--cms-fg2); display: flex; padding: 9px; border-radius: var(--cms-r-md); position: relative;" title="Notifications">
                            <i data-lucide="bell" style="width: 18px; height: 18px;"></i>
                            <span style="position: absolute; top: 6px; right: 7px; width: 7px; height: 7px; border-radius: 999px; background: var(--cms-red); border: 1.5px solid var(--cms-surface);"></span>
                        </button>
                        <!-- Notifications Panel -->
                        <div id="notifications-panel" style="display: none; position: absolute; top: 48px; right: 0; width: 300px; background: var(--cms-surface); border-radius: var(--cms-r-lg); box-shadow: var(--cms-sh-pop); border: 1px solid var(--cms-border); z-index: 100; overflow: hidden; animation: dsPop 180ms ease;">
                            <div style="padding: 12px 16px; border-bottom: 1px solid var(--cms-border); font-family: var(--cms-font-ui); font-weight: 700; font-size: 13.5px; color: var(--cms-fg1);">Notifications</div>
                            
                            <div style="padding: 11px 16px; border-bottom: 1px solid var(--cms-border); display: flex; gap: 10px; cursor: pointer;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                <span style="width: 7px; height: 7px; border-radius: 999px; background: var(--cms-gold); id: 5px; flex-shrink: 0; margin-top: 5px;"></span>
                                <div>
                                    <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg1); line-height: 1.4;">Yaw submitted a post for review</div>
                                    <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); margin-top: 2px;">3h ago</div>
                                </div>
                            </div>
                            <div style="padding: 11px 16px; border-bottom: 1px solid var(--cms-border); display: flex; gap: 10px; cursor: pointer;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                <span style="width: 7px; height: 7px; border-radius: 999px; background: var(--cms-red); id: 5px; flex-shrink: 0; margin-top: 5px;"></span>
                                <div>
                                    <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg1); line-height: 1.4;">V.I.P article flagged for content decay</div>
                                    <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); margin-top: 2px;">1d ago</div>
                                </div>
                            </div>
                            <div style="padding: 11px 16px; display: flex; gap: 10px; cursor: pointer;" onmouseover="this.style.background='#FBF9F5'" onmouseout="this.style.background='transparent'">
                                <span style="width: 7px; height: 7px; border-radius: 999px; background: var(--cms-fg4); id: 5px; flex-shrink: 0; margin-top: 5px;"></span>
                                <div>
                                    <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg1); line-height: 1.4;">12 new comments awaiting moderation</div>
                                    <div style="font-family: var(--cms-font-ui); font-size: 11px; color: var(--cms-fg4); margin-top: 2px;">1d ago</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Post Button CTA -->
                    <div class="cms-newpost-hide">
                        <a href="{{ route('admin.posts.create') }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 7px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; padding: 9px 16px; height: 38px; background: var(--cms-gold); color: #1A1410; border: 1.5px solid transparent; border-radius: var(--cms-r-md); cursor: pointer; text-decoration: none; transition: background 140ms, transform 100ms;" onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
                            <i data-lucide="plus" style="width: 16px; height: 16px; stroke-width: 2;"></i>
                            New Post
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Yield Content -->
            <main class="cms-content" style="flex: 1; padding: 24px;">
                <div class="cms-view-enter">
                    @yield('content')
                </div>
            </main>
        </div>

    </div>

    <!-- Scripting for Sidebar interactions -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Check stored sidebar collapse state
        const sidebar = document.getElementById('cms-sidebar');
        const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        if (isCollapsed && sidebar) {
            sidebar.classList.add('collapsed');
        }

        function toggleSidebarCollapse() {
            if (sidebar) {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
            }
        }

        function toggleMobileSidebar(open) {
            const sidebar = document.getElementById('cms-sidebar');
            const backdrop = document.getElementById('mobile-backdrop');
            if (sidebar && backdrop) {
                if (open) {
                    sidebar.classList.add('cms-mobile-open');
                    backdrop.style.display = 'block';
                } else {
                    sidebar.classList.remove('cms-mobile-open');
                    backdrop.style.display = 'none';
                }
            }
        }

        function toggleNotifications() {
            const panel = document.getElementById('notifications-panel');
            if (panel) {
                panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
            }
        }

        // Close notifications when clicking outside
        window.addEventListener('click', function(e) {
            const panel = document.getElementById('notifications-panel');
            if (panel && panel.style.display === 'block') {
                const btn = panel.previousElementSibling;
                if (!panel.contains(e.target) && !btn.contains(e.target)) {
                    panel.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>
