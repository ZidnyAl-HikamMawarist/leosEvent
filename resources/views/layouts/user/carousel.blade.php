@if($carousels->count() > 0)
    <section id="home" class="py-4">
        <div class="container-fluid px-lg-5">
            <div id="heroCarousel"
                class="carousel slide carousel-fade hero-carousel-premium shadow-2xl overflow-hidden rounded-5"
                data-bs-ride="carousel" style="height: 600px;">
                <div class="carousel-inner h-100">
                    @foreach($carousels as $key => $slide)
                        <div class="carousel-item h-100 {{ $key == 0 ? 'active' : '' }}"
                            style="background: linear-gradient(rgba(15, 9, 8, 0.4), rgba(15, 9, 8, 0.7)), url('{{ asset('storage/' . $slide->gambar) }}') no-repeat center center; background-size: cover;">
                            <div class="container h-100 d-flex align-items-center">
                                <div class="row w-100">
                                    <div class="col-lg-10 col-xl-8" data-aos="fade-right">
                                        <div
                                            class="badge bg-secondary bg-opacity-20 text-secondary px-3 py-2 rounded-pill mb-4 border border-secondary border-opacity-30 shadow-sm">
                                            <i class="bi bi-rocket-takeoff-fill me-2 text-accent"></i>
                                            {{ $setting->nama_event ?? 'The Event' }}
                                        </div>
                                        <h1 class="display-2 fw-bold text-white mb-3 mt-2 font-secondary">
                                            <span class="text-gradient">{{ $slide->judul }}</span>
                                        </h1>
                                        <p class="text-muted fs-5 mb-5 pe-lg-5" style="color: #e2d1c3 !important;">
                                            {{ $slide->deskripsi }}
                                        </p>
                                        <div class="d-flex flex-column flex-sm-row gap-3">
                                            <a href="{{ route('pendaftaran') }}"
                                                class="btn btn-primary-custom btn-lg rounded-pill px-5 py-3">
                                                Join Now <i class="bi bi-arrow-right-circle ms-2"></i>
                                            </a>
                                            <a href="#about"
                                                class="btn btn-outline-custom btn-lg rounded-pill px-5 py-3 glass-effect">
                                                Learn More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($carousels->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon-custom" aria-hidden="true">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon-custom" aria-hidden="true">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </button>

                    <div class="carousel-indicators-custom">
                        @foreach($carousels as $key => $slide)
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}"
                                class="{{ $key == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@else
    <section id="home" class="py-4">
        <div class="container-fluid px-lg-5">
            <div class="hero-section-alt rounded-5 overflow-hidden position-relative shadow-2xl"
                style="background-image: url('{{ asset('images/hero.png') }}'); height: 600px;">
                <div class="hero-overlay"></div>
                <div class="container h-100 d-flex align-items-center position-relative" style="z-index: 2;">
                    <div class="row">
                        <div class="col-lg-9" data-aos="fade-up">
                            <div
                                class="badge bg-secondary bg-opacity-20 text-secondary px-3 py-2 rounded-pill mb-4 border border-secondary border-opacity-30 shadow-sm">
                                <i class="bi bi-stars me-2 text-accent"></i> THE MOST AWAITED EVENT
                            </div>
                            <h1 class="display-2 fw-bold text-white mb-3 mt-2 font-secondary">
                                <span class="text-gradient">Experience</span> The New Standard
                            </h1>
                            <p class="text-muted fs-5 mb-5 pe-lg-5" style="color: #e2d1c3 !important;">
                                {{ $setting->deskripsi_event ?? 'Join thousand of visionaries and industry leaders at the most impactful event of the decade.' }}
                            </p>
                            <div class="d-flex flex-column flex-sm-row gap-3">
                                <a href="{{ route('pendaftaran') }}"
                                    class="btn btn-primary-custom btn-lg rounded-pill px-5 py-3">
                                    Secure Your Spot <i class="bi bi-arrow-right-circle ms-2"></i>
                                </a>
                                <a href="#about" class="btn btn-outline-custom btn-lg rounded-pill px-5 py-3 glass-effect">
                                    Explore More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<style>
    .hero-carousel-premium,
    .hero-section-alt {
        background-color: var(--bg-card);
        border: 1px solid var(--glass-border);
    }

    .carousel-indicators-custom {
        position: absolute;
        bottom: 30px;
        left: 50px;
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .carousel-indicators-custom button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        border: none;
        transition: all 0.3s ease;
    }

    .carousel-indicators-custom button.active {
        background: var(--secondary);
        width: 30px;
        border-radius: 5px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .hero-carousel-premium:hover .carousel-control-prev,
    .hero-carousel-premium:hover .carousel-control-next {
        opacity: 1;
    }

    .carousel-control-prev-icon-custom,
    .carousel-control-next-icon-custom {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }

    .carousel-control-prev-icon-custom:hover,
    .carousel-control-next-icon-custom:hover {
        background: var(--secondary);
        border-color: var(--secondary);
        transform: scale(1.1);
    }

    .text-gradient {
        background: linear-gradient(to right, #fff, var(--secondary));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>