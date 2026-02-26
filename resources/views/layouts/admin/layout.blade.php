<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:
                {{ $setting->primary_color ?? '#712f23' }}
            ;
            --text-on-primary:
                {{ $setting->text_primary_color ?? '#ffffff' }}
            ;
            --secondary:
                {{ $setting->secondary_color ?? '#c5a353' }}
            ;
            --text-on-secondary:
                {{ $setting->text_secondary_color ?? '#ffffff' }}
            ;
            --accent:
                {{ $setting->accent_color ?? '#d4af37' }}
            ;
            --primary-glow:
                {{ ($setting->primary_color ?? '#712f23') . '80' }}
            ;

            /* Light Theme Variables */
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --bg-sidebar: #ffffff;
            --bg-topbar: rgba(255, 255, 255, 0.8);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: rgba(0, 0, 0, 0.05);
            --sidebar-hover: #f1f5f9;
        }

        body.dark-mode {
            --bg-body: #0a0a0b;
            /* True Dark Black */
            --bg-card: #141417;
            /* Slate Black Card */
            --bg-sidebar: #141417;
            --bg-topbar: rgba(20, 20, 23, 0.85);
            /* Blurred Black Topbar */
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            /* Subtle white border */
            --sidebar-hover: #1e1e22;
        }

        /* Dark Mode Global Table & Form Fixes */
        .dark-mode .table {
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }

        .dark-mode .table thead,
        .dark-mode .table thead tr,
        .dark-mode .table thead th,
        .dark-mode .table-light {
            background-color: #1a1a1e !important;
            color: var(--accent) !important;
            border-color: var(--border-color) !important;
        }

        .dark-mode .table td {
            background-color: transparent !important;
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }

        .dark-mode .dropdown-menu {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4) !important;
        }

        .dark-mode .dropdown-item {
            color: var(--text-main);
        }

        .dark-mode .dropdown-item:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary);
        }

        .dark-mode .btn-light {
            background-color: #1e1e22 !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }

        .dark-mode .alert-success {
            background-color: rgba(16, 185, 129, 0.1) !important;
            border: 1px solid rgba(16, 185, 129, 0.2) !important;
            color: #34d399 !important;
        }

        .dark-mode .alert-danger {
            background-color: rgba(239, 68, 68, 0.1) !important;
            border: 1px solid rgba(239, 68, 68, 0.2) !important;
            color: #f87171 !important;
        }

        .dark-mode .modal-content {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border-color) !important;
        }

        /* Fix for data that might still be white due to global classes */
        .dark-mode .bg-white {
            background-color: var(--bg-card) !important;
        }

        .dark-mode .text-dark {
            color: var(--text-main) !important;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
        }

        /* Anti-Blue overrides */
        .text-primary {
            color: var(--primary) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: var(--text-on-primary) !important;
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .bg-primary {
            background-color: var(--primary) !important;
            color: var(--text-on-primary) !important;
        }

        /* ===== SIDEBAR REFINEMENT ===== */
        .sidebar {
            width: 260px;
            height: calc(100vh - 40px);
            /* Fallback */
            height: calc(100dvh - 40px);
            position: fixed;
            left: 20px;
            top: 20px;
            background: var(--bg-sidebar);
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            border-radius: 20px;
            border: 1px solid var(--border-color);
        }

        .sidebar-header {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 1.5px;
            color: var(--primary);
        }

        .sidebar-header i {
            font-size: 28px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            padding: 15px 10px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 12px;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sidebar-menu a:hover {
            background: var(--sidebar-hover);
            color: var(--primary);
            padding-left: 22px;
        }

        .sidebar-menu a.active {
            background: var(--primary);
            color: var(--text-on-primary);
            box-shadow: 0 8px 16px var(--primary-glow);
        }

        .submenu {
            padding-left: 15px;
            display: none;
        }

        .submenu.show {
            display: block;
        }

        .submenu a {
            padding: 8px 15px 8px 40px;
            font-size: 12px;
            margin-bottom: 2px;
        }

        .submenu a.active {
            background: rgba(var(--primary-rgb, 113, 47, 35), 0.1);
            color: var(--primary);
            box-shadow: none;
            border-left: 3px solid var(--primary);
            border-radius: 0 14px 14px 0;
        }

        .sidebar-menu [data-bs-toggle="collapse"] {
            position: relative;
        }

        .sidebar-menu [data-bs-toggle="collapse"]::after {
            content: "\F282";
            font-family: "bootstrap-icons";
            position: absolute;
            right: 18px;
            transition: transform 0.3s ease;
            font-size: 12px;
        }

        .sidebar-menu [data-bs-toggle="collapse"]:not(.collapsed)::after {
            transform: rotate(180deg);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
        }

        .sidebar-footer .btn-logout {
            background: rgba(225, 29, 72, 0.1);
            color: #e11d48;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            padding: 12px;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-footer .btn-logout:hover {
            background: #e11d48;
            color: #ffffff;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 20px;
            left: 300px;
            right: 20px;
            height: 70px;
            background: var(--bg-topbar);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            z-index: 999;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .topbar-title {
            font-weight: 700;
            color: var(--text-main);
            font-size: 18px;
            margin: 0;
        }

        /* Theme Toggle Button */
        .theme-toggle,
        .mobile-btn {
            background: var(--sidebar-hover);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover,
        .mobile-btn:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.05);
        }

        .mobile-btn {
            display: none;
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 300px;
            padding: 110px 20px 40px 20px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* ===== CARD STYLE ===== */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            background: var(--bg-card);
            color: var(--text-main);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        /* Form Controls Dark Adjustments */
        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: #1e1e22;
            border-color: rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }

        .dark-mode .form-control:focus,
        .dark-mode .form-select:focus {
            background-color: #2a2a2e;
            color: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem var(--primary-glow);
        }

        /* Pagination & Badge Refinements */
        .dark-mode .pagination .page-link {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-main);
        }

        .dark-mode .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .dark-mode .bg-light {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        .dark-mode .text-secondary {
            color: #94a3b8 !important;
        }

        .dark-mode .card img {
            opacity: 0.9;
            filter: grayscale(0.2) contrast(1.1);
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
            backdrop-filter: blur(3px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* DataTables overflow on mobile */
        .table-responsive {
            border-radius: 12px;
        }

        /* ===== RESPONSIVE ===== */
        /* Tablet */
        @media (max-width: 992px) {
            .sidebar {
                left: 10px;
                top: 10px;
                height: calc(100vh - 20px);
                /* Fallback */
                height: calc(100dvh - 20px);
                width: 80px;
            }

            .sidebar-header span,
            .sidebar-menu a span,
            .sidebar-footer span {
                display: none;
            }

            .sidebar-header {
                height: 80px;
            }

            .topbar {
                left: 105px;
                right: 10px;
                top: 10px;
            }

            .content {
                margin-left: 80px;
                padding: 100px 15px 30px 15px;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 12px;
            }

            .sidebar-footer .btn-logout {
                padding: 10px;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-150%);
                width: 260px;
                z-index: 1050;
            }

            .sidebar.active {
                transform: translateX(0);
                left: 10px;
                top: 10px;
                height: calc(100vh - 20px);
                /* Fallback */
                height: calc(100dvh - 20px);
            }

            .sidebar-header span,
            .sidebar-menu a span,
            .sidebar-footer span {
                display: inline;
            }

            .sidebar-menu a {
                justify-content: flex-start;
                padding: 12px 18px;
            }

            .topbar {
                left: 10px;
                right: 10px;
                top: 10px;
            }

            .content {
                margin-left: 0;
                padding: 100px 10px 30px 10px;
            }

            .mobile-btn {
                display: flex !important;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR OVERLAY --}}
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span>ADMIN PANEL</span>
            <button class="btn btn-close d-md-none position-absolute end-0 me-3" id="close-sidebar"></button>
        </div>

        <div class="sidebar-menu">
            <a href="{{ url('admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ url('admin/carousel') }}" class="{{ request()->is('admin/carousel*') ? 'active' : '' }}">
                <i class="bi bi-collection"></i>
                <span>Carousel</span>
            </a>

            <a href="{{ url('admin/lomba') }}" class="{{ request()->is('admin/lomba*') ? 'active' : '' }}">
                <i class="bi bi-trophy"></i>
                <span>Lomba</span>
            </a>

            <a href="{{ url('admin/galeri') }}" class="{{ request()->is('admin/galeri*') ? 'active' : '' }}">
                <i class="bi bi-image"></i>
                <span>Galeri</span>
            </a>

            <a href="{{ url('admin/faq') }}" class="{{ request()->is('admin/faq*') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i>
                <span>FAQ</span>
            </a>
            <a href="{{ url('admin/pendaftaran') }}" class="{{ request()->is('admin/pendaftaran*') ? 'active' : '' }}">
                <i class="bi bi-person-check"></i>
                <span>Pendaftar</span>
            </a>

            <!-- Settings Dropdown -->
            <a href="#settingsSubmenu"
                class="{{ request()->is('admin/settings*') ? 'active' : '' }} {{ request()->is('admin/settings*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" role="button"
                aria-expanded="{{ request()->is('admin/settings*') ? 'true' : 'false' }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
            <div class="collapse submenu {{ request()->is('admin/settings*') ? 'show' : '' }}" id="settingsSubmenu">
                <a href="{{ route('admin.settings') }}"
                    class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i> Umum & Tema
                </a>
                <a href="{{ route('admin.settings.about') }}"
                    class="{{ request()->routeIs('admin.settings.about') ? 'active' : '' }}">
                    <i class="bi bi-info-circle"></i> Teks About
                </a>
                <a href="{{ route('admin.settings.pendaftaran') }}"
                    class="{{ request()->routeIs('admin.settings.pendaftaran') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Teks Pendaftaran
                </a>
                <a href="{{ route('admin.settings.galeri') }}"
                    class="{{ request()->routeIs('admin.settings.galeri') ? 'active' : '' }}">
                    <i class="bi bi-images"></i> Teks Galeri
                </a>
                <a href="{{ route('admin.settings.hero') }}"
                    class="{{ request()->routeIs('admin.settings.hero') ? 'active' : '' }}">
                    <i class="bi bi-megaphone"></i> Hero & Promo
                </a>
                <a href="{{ route('admin.settings.informasi') }}"
                    class="{{ request()->routeIs('admin.settings.informasi') ? 'active' : '' }}">
                    <i class="bi bi-card-text"></i> FAQ & Lomba
                </a>
                <a href="{{ route('admin.settings.process') }}"
                    class="{{ request()->routeIs('admin.settings.process') ? 'active' : '' }}">
                    <i class="bi bi-arrow-repeat"></i> Process Flow
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    {{-- TOPBAR --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-2">
            <button class="mobile-btn" id="open-sidebar" title="Open Menu">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h5 class="topbar-title">@yield('title', 'Admin Panel')</h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-sm-block">
                <div class="fw-bold small">{{ auth()->user()->name }}</div>
                <div class="text-muted" style="font-size: 11px;">Administrator</div>
            </div>

            <button class="theme-toggle" id="theme-toggle" title="Toggle Dark/Light Mode">
                <i class="bi bi-moon-stars" id="theme-icon"></i>
            </button>

            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
                style="width: 40px; height: 40px;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const body = document.body;
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openSidebarBtn = document.getElementById('open-sidebar');
        const closeSidebarBtn = document.getElementById('close-sidebar');

        // Dark Mode Logic
        const currentTheme = localStorage.getItem('admin-theme');
        if (currentTheme === 'dark') {
            body.classList.add('dark-mode');
            themeIcon.classList.replace('bi-moon-stars', 'bi-sun');
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');

            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('admin-theme', 'dark');
                themeIcon.classList.replace('bi-moon-stars', 'bi-sun');
            } else {
                localStorage.setItem('admin-theme', 'light');
                themeIcon.classList.replace('bi-sun', 'bi-moon-stars');
            }
        });

        // Mobile Sidebar Logic
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('show');
            if (sidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        openSidebarBtn.addEventListener('click', toggleSidebar);
        closeSidebarBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Sidebar Scroll Persistence
        const sidebarMenu = document.querySelector('.sidebar-menu');
        if (sidebarMenu) {
            // Restore scroll position
            const savedScrollPos = localStorage.getItem('sidebar-scroll');
            if (savedScrollPos) {
                sidebarMenu.scrollTop = savedScrollPos;
            }

            // Save scroll position on scroll
            sidebarMenu.addEventListener('scroll', () => {
                localStorage.setItem('sidebar-scroll', sidebarMenu.scrollTop);
            });

            // Auto-scroll to active link if it's not visible
            const activeLink = sidebarMenu.querySelector('a.active');
            if (activeLink) {
                activeLink.scrollIntoView({ behavior: 'auto', block: 'nearest' });
            }
        }
    </script>
</body>

</html>