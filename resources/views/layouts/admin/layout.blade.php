<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f4f6fb;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #0b1220, #0f172a);
            color: white;
            display: flex;
            flex-direction: column;
            transition: .3s;
        }

        .sidebar-header {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            white-space: nowrap;
        }

        .sidebar-menu {
            padding: 12px;
            flex: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            transition: .25s;
            font-size: 15px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #2563eb;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, .1);
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 240px;
            padding: 32px;
            transition: .3s;
        }

        .page-wrapper {
            max-width: 1100px;
            margin: auto;
        }

        /* ===== RESPONSIVE (TEKS TETAP ADA) ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 160px;
            }

            .sidebar-header {
                font-size: 13px;
                padding: 0 6px;
                text-align: center;
            }

            .sidebar-menu a {
                font-size: 13px;
                gap: 8px;
                padding: 10px;
            }

            .content {
                margin-left: 160px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="sidebar-header">
            ADMIN PANEL
        </div>

        <div class="sidebar-menu">
            <a href="{{ url('admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">🏠
                Dashboard</a>
            <a href="{{ url('admin/carousel') }}" class="{{ request()->is('admin/carousel*') ? 'active' : '' }}">🎪
                Carousel</a>
            <a href="{{ url('admin/timeline') }}" class="{{ request()->is('admin/timeline*') ? 'active' : '' }}">📅
                Timeline</a>
            <a href="{{ url('admin/lomba') }}" class="{{ request()->is('admin/lomba*') ? 'active' : '' }}">🏆 Lomba</a>
            <a href="{{ url('admin/galeri') }}" class="{{ request()->is('admin/galeri*') ? 'active' : '' }}">🖼
                Galeri</a>
            <a href="{{ url('admin/faq') }}" class="{{ request()->is('admin/faq*') ? 'active' : '' }}">❓ FAQ</a>
            <a href="{{ url('admin/pendaftaran') }}"
                class="{{ request()->is('admin/pendaftaran*') ? 'active' : '' }}">📝 Pendaftar</a>
            <a href="{{ url('admin/settings') }}" class="{{ request()->is('admin/settings') ? 'active' : '' }}">⚙
                Settings</a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>

</body>

</html>