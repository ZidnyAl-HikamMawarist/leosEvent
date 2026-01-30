<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting->nama_event ?? 'LEOS EVENT' }} | Premier Experience</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap"
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
            --font-primary: 'Plus Jakarta Sans', sans-serif;
            --font-secondary: 'Outfit', sans-serif;
        }

        body {
            font-family: var(--font-primary);
        }
    </style>
</head>

<body class="bg-dark text-white">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top bg-body shadow-sm" id="mainNav">
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <div class="brand-icon me-2">
                    <i class="bi bi-intersect fs-3 text-secondary"></i>
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
                        <a class="nav-link px-3" href="{{ route('home') }}#timeline">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#galeri">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}#faq">F.A.Q</a>
                    </li>
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
                        Redefining the standard of excellence in event experiences. Join us for a journey of innovation
                        and connection.
                    </p>
                    <div class="social-links d-flex gap-3">
                        <a href="#" class="social-icon-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon-btn"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon-btn"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white fw-bold mb-4">Quick Links</h6>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#about" class="text-muted text-decoration-none">About</a></li>
                        <li class="mb-2"><a href="#timeline" class="text-muted text-decoration-none">Schedule</a></li>
                        <li class="mb-2"><a href="#faq" class="text-muted text-decoration-none">F.A.Q</a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-8">
                    <h6 class="text-white fw-bold mb-4">Newsletter</h6>
                    <p class="text-muted mb-4 text-xs">Stay updated with our latest news and event announcements.</p>
                    <div class="input-group mb-3 glass-input-group">
                        <input type="text" class="form-control bg-transparent border-secondary text-white"
                            placeholder="Email address">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="my-5 border-secondary border-opacity-10">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-muted mb-0 small">
                        {{ $setting->footer_text ?? '© 2024 Leos Event. All Rights Reserved.' }}
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="text-muted mb-0 small">Handcrafted by <span class="text-primary font-bold">Leos
                            Digital</span></p>
                </div>
            </div>
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