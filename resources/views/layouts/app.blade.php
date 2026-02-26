<!DOCTYPE html>
<html lang="id" class="scroll-smooth" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title'){{ isset($__env->getSections()['title']) ? ' | ' : '' }}{{ $setting->nama_event ?? 'LEOS EVENT' }}
    </title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="{{ $setting->font_family_url ?? 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap' }}"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
            --text-main:
                {{ $setting->body_text_color ?? '#fdf6f0' }}
            ;
            --primary-glow:
                {{ $setting->primary_color ?? '#712f23' }}
                80;
            --font-primary: 'Plus Jakarta Sans', sans-serif;
            --font-secondary: 'Outfit', sans-serif;
            @if($setting && $setting->background_image)
                --bg-page: url('{{ asset('storage/' . $setting->background_image) }}');
                --bg-body: transparent;
            @else --bg-page:
                {{ $setting->background_color ?? '#0f0908' }}
                ;
                --bg-body:
                    {{ $setting->background_color ?? '#0f0908' }}
                ;
            @endif
        }

        /* Anti-Blue & Theme Sync */
        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
            color: var(--text-on-primary) !important;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: var(--text-on-primary) !important;
        }

        .btn-primary:hover {
            filter: brightness(1.1);
        }

        .text-secondary {
            color: var(--secondary) !important;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
            color: var(--text-on-secondary) !important;
        }

        .btn-secondary {
            background-color: var(--secondary) !important;
            border-color: var(--secondary) !important;
            color: var(--text-on-secondary) !important;
        }

        .border-primary {
            border-color: var(--primary) !important;
        }

        .border-secondary {
            border-color: var(--secondary) !important;
        }

        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary) !important;
            color: var(--text-on-primary) !important;
        }

        body {
            color: var(--text-main) !important;
        }

        a {
            color: var(--secondary);
            text-decoration: none;
        }

        a:hover {
            color: var(--primary);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.25rem var(--primary-glow) !important;
        }

        .pagination .page-link {
            color: var(--text-main);
            background-color: var(--bg-card);
            border-color: var(--glass-border);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: var(--text-on-primary) !important;
        }

        .pagination .page-link:hover {
            background-color: var(--bg-card-hover);
        }

        body {
            background: var(--bg-page) !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
            background-position: center !important;
            min-height: 100vh;
            font-family: var(--font-primary);
            overflow-x: hidden;
            position: relative;
            /* Base for absolute side images */
        }

        /* Decorative Container */
        .decoration-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .decor-side {
            position: absolute;
            max-width: 15%;
            /* Responsive width */
            opacity: 0.4;
            transition: opacity 0.3s ease;
        }

        .decor-left-top {
            top: 0;
            left: 0;
        }

        .decor-right-top {
            top: 0;
            right: 0;
        }

        .decor-left-bottom {
            bottom: 0;
            left: 0;
        }

        .decor-right-bottom {
            bottom: 0;
            right: 0;
        }

        /* Navbar Top Decoration - Integrated */
        .navbar-decoration-wrapper {
            position: absolute;
            bottom: -20px;
            /* Slight overlap downwards */
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            pointer-events: none;
            z-index: -1;
        }

        .navbar-decoration-img {
            width: 100%;
            max-width: 1200px;
            /* Remove fixed height to prevent sqashing */
            height: auto;
            max-height: 150px;
            /* Allow it to be taller if natural ratio permits */
            object-fit: contain;
            /* Contain ensures the whole image is seen without distortion */
            opacity: 0.9;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
            transform: translateY(10px);
            /* Slight offet */
        }

        /* Navbar Overflow Fix */
        .navbar {
            overflow: visible !important;
        }

        .bg-secondary-custom {
            background-color: var(--secondary);
            color: var(--bg-body);
            font-weight: 700;
        }

        @media (max-width: 991px) {
            .decor-side {
                display: none;
            }

            .navbar-decoration-wrapper {
                display: none;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body class="text-white">



    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top bg-body shadow-sm" id="mainNav">
        @if($setting && $setting->top_image)
            <div class="navbar-decoration-wrapper">
                <img src="{{ asset('storage/' . $setting->top_image) }}" class="navbar-decoration-img" alt="Decoration">
            </div>
        @endif
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <div class="brand-icon me-2">
                    @if($setting && $setting->logo)
                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" style="height: 40px; width: auto;">
                    @else
                        <i class="bi bi-intersect fs-3 text-secondary"></i>
                    @endif
                </div>
                <span class="brand-text">{{ $setting->nama_event ?? 'LEOS EVENT' }}</span>
            </a>
            <button class="navbar-toggler border-0 text-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#galeri">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#faq">F.A.Q</a>
                    </li>
                    @if($setting && $setting->navbar_element)
                        <li class="nav-item px-lg-3">
                            <span class="badge bg-secondary-custom rounded-pill py-2 px-3">
                                {{ $setting->navbar_element }}
                            </span>
                        </li>
                    @endif
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('pendaftaran') }}" class="btn btn-primary-custom rounded-pill px-4 shadow-sm">
                            Join Event <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-premium pt-5 pb-4 border-top border-secondary border-opacity-10">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <h3 class="fw-bold mb-4 d-flex align-items-center">
                        <i class="bi bi-intersect text-primary me-2"></i>
                        {{ $setting->nama_event ?? 'LEOS EVENT' }}
                    </h3>
                    <p class="text-muted mb-4 fs-5" style="max-width: 400px;">
                        {{ $setting->deskripsi_event ?? 'Redefining the standard of excellence in event experiences. Join us for a journey of innovation and connection.' }}
                    </p>
                    <div class="social-links d-flex gap-3">
                        @if($setting && $setting->footer_ig_link)
                            <a href="{{ $setting->footer_ig_link }}" target="_blank" class="social-icon-btn"><i
                                    class="bi bi-instagram"></i></a>
                        @endif
                        <!-- Additional social links can be added here if needed in the future -->
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white fw-bold mb-4">Quick Links</h6>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#about" class="text-muted text-decoration-none">About</a></li>

                        <li class="mb-2"><a href="#faq" class="text-muted text-decoration-none">F.A.Q</a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-8">
                    <h6 class="text-white fw-bold mb-4">Location Map</h6>
                    @if($setting && $setting->footer_map_link)
                        <style>
                            .map-container iframe {
                                width: 100% !important;
                                height: 100% !important;
                                border: 0 !important;
                            }
                        </style>
                        <div class="map-container rounded overflow-hidden shadow-sm" style="height: 150px;">
                            @if(\Illuminate\Support\Str::contains($setting->footer_map_link, '<iframe'))
                                {!! $setting->footer_map_link !!}
                            @else
                                <iframe src="{{ $setting->footer_map_link }}" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-4 text-xs">Peta lokasi belum di atur di menu pengaturan admin.</p>
                    @endif
                </div>
            </div>
            <hr class="my-5 border-secondary border-opacity-10">
            <div class="row align-items-center mb-4">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-muted mb-0 small">
                        {{ $setting->footer_text ?? '© 2024 Leos Event. All Rights Reserved.' }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="text-muted mb-0 small">Handcrafted by <span class="text-primary font-bold"> Zidny</span>
                    </p>
                </div>
            </div>
            @if($setting && $setting->footer_image)
                <div class="text-center mt-5">
                    <img src="{{ asset('storage/' . $setting->footer_image) }}" class="img-fluid"
                        style="max-height: 80px; opacity: 0.6;" alt="Footer Decoration">
                </div>
            @endif
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 1200,
            offset: 100,
            easing: 'ease-out-cubic'
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>