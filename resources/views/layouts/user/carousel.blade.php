@if($carousels->count() > 0)
    <section id="home" class="py-4 mt-5 position-relative">
        <!-- Corner Decorations -->
        <div class="carousel-corner-decor">
            @if(isset($setting) && $setting->side_image_left)
                <img src="{{ asset('storage/' . $setting->side_image_left) }}" class="corner-decor corner-left" alt="">
            @endif
            @if(isset($setting) && $setting->side_image_right)
                <img src="{{ asset('storage/' . $setting->side_image_right) }}" class="corner-decor corner-right" alt="">
            @endif
            @if(isset($setting) && $setting->side_image_left_bottom)
                <img src="{{ asset('storage/' . $setting->side_image_left_bottom) }}" class="corner-decor corner-left-bottom"
                    alt="">
            @endif
            @if(isset($setting) && $setting->side_image_right_bottom)
                <img src="{{ asset('storage/' . $setting->side_image_right_bottom) }}" class="corner-decor corner-right-bottom"
                    alt="">
            @endif
        </div>

        <!-- Tambahkan px-0 agar di HP tidak ada ruang kosong di kiri/kanan, tapi tetap ada jarak di laptop (px-lg-5) -->
        <div class="container-fluid px-2 px-lg-5 position-relative z-1">
            <div id="heroCarousel"
                class="carousel slide carousel-fade hero-carousel-premium shadow-2xl overflow-hidden rounded-5 hero-carousel-height"
                data-bs-ride="carousel">
                <div class="carousel-inner h-100">
                    @foreach($carousels as $key => $slide)
                        <div class="carousel-item h-100 {{ $key == 0 ? 'active' : '' }}"
                            style="background: linear-gradient(rgba(15, 9, 8, 0.4), rgba(15, 9, 8, 0.7)), url('{{ asset('storage/' . $slide->gambar) }}') no-repeat center center; background-size: cover; position: relative;">
                            <!-- Tambahkan position relative -->

                            <div class="container h-100 d-flex align-items-center">
                                <div class="row w-100 align-items-center justify-content-center justify-content-md-start">
                                    <div class="col-lg-10 col-xl-8" data-aos="fade-right">
                                        {{-- Group Tombol Tetap Di Tengah dengan padding ekstra di HP agar terhindar panah
                                        carousel --}}
                                        <div class="d-flex flex-column flex-sm-row gap-3 px-4 px-md-0 ms-3">
                                            <a href="{{ $slide->link_url ?? route('pendaftaran') }}"
                                                class="btn btn-primary-custom rounded-pill px-4 px-md-5 py-2 py-md-3 shadow fw-bold d-flex justify-content-center align-items-center"
                                                style="font-size: min(1rem, 4vw);">
                                                {{ $setting->hero_primary_btn_text ?? 'Join Now' }} <i
                                                    class="bi bi-arrow-right-circle ms-2"></i>
                                            </a>
                                            <a href="#about"
                                                class="btn btn-outline-custom rounded-pill px-4 px-md-5 py-2 py-md-3 glass-effect text-white fw-bold d-flex justify-content-center align-items-center"
                                                style="font-size: min(1rem, 4vw);">
                                                {{ $setting->hero_secondary_btn_text ?? 'Learn More' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Keterangan diletakkan di luar container flex agar bisa diatur posisinya ke bawah --}}
                            @if($slide->keterangan)
                                <div class="position-absolute start-0 w-100 carousel-keterangan">
                                    <div class="container">
                                        <div class="border-start border-primary border-4 ps-4 overflow-hidden"
                                            style="background: linear-gradient(90deg, rgba(212, 175, 55, 0.15) 0%, transparent 100%); display: inline-block; max-width: 90%;">
                                            <p class="text-white mb-0 fw-bold fs-4 carousel-keterangan-text"
                                                style="letter-spacing: 0.5px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                                <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                                {{ $slide->keterangan }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                @endif
            </div>
        </div>
    </section>
@else
    <section id="home" class="py-4 mt-5">
        <div class="container-fluid px-lg-5">
            <div class="hero-section-alt rounded-5 overflow-hidden position-relative shadow-2xl"
                style="background-image: url('{{ asset('images/hero.png') }}'); height: 600px;">
                <div class="hero-overlay"></div>
                <div class="container h-100 d-flex align-items-center position-relative" style="z-index: 2;">
                    <div class="row">
                        <div class="col-lg-9" data-aos="fade-up">
                            <div
                                class="badge bg-secondary bg-opacity-20 text-secondary px-3 py-2 rounded-pill mb-4 border border-secondary border-opacity-30 shadow-sm">
                                <i class="bi bi-stars me-2 text-accent"></i>
                                {{ $setting->hero_tag ?? 'THE MOST AWAITED EVENT' }}
                            </div>
                            <h1 class="display-2 fw-bold text-white mb-3 mt-2 font-secondary">
                                {{ $setting->hero_title ?? 'Experience The New Standard' }}
                            </h1>
                            <p class="text-muted fs-5 mb-5 pe-lg-5" style="color: #e2d1c3 !important;">
                                {{ $setting->deskripsi_event ?? 'Join thousand of visionaries and industry leaders at the most impactful event of the decade.' }}
                            </p>
                            <div class="d-flex flex-column flex-sm-row gap-3 px-4 px-md-0">
                                <a href="{{ route('pendaftaran') }}"
                                    class="btn btn-primary-custom rounded-pill px-4 px-md-5 py-2 py-md-3 shadow fw-bold d-flex justify-content-center align-items-center"
                                    style="font-size: min(1rem, 4vw);">
                                    {{ $setting->hero_primary_btn_text ?? 'Join Now' }} <i
                                        class="bi bi-arrow-right-circle ms-2"></i>
                                </a>
                                <a href="#about"
                                    class="btn btn-outline-custom rounded-pill px-4 px-md-5 py-2 py-md-3 glass-effect fw-bold d-flex justify-content-center align-items-center"
                                    style="font-size: min(1rem, 4vw);">
                                    {{ $setting->hero_secondary_btn_text ?? 'Learn More' }}
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

    /* Corner Decorations */
    .carousel-corner-decor {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 10;
        /* Bring to front to overlap carousel */
    }

    .corner-decor {
        position: absolute;
        width: 250px;
        height: auto;
        opacity: 1;
        transition: all 0.3s ease;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
        /* Add shadow for depth */
    }

    .corner-left {
        top: -30px;
        left: -30px;
        /* Pull it out a bit to hug the corner */
    }

    .corner-right {
        top: -30px;
        right: -30px;
        /* Pull it out a bit */
    }

    .corner-left-bottom {
        bottom: -150px;
        left: -30px;
    }

    .corner-right-bottom {
        bottom: -150px;
        right: -30px;
    }

    .hero-carousel-height {
        height: 600px;
    }

    .carousel-keterangan {
        bottom: 145px;
        z-index: 10;
    }

    @media (max-width: 991px) {
        .corner-decor {
            width: 120px;
        }

        /* Top corners adjustment for mobile */
        .corner-left,
        .corner-right {
            top: -20px;
        }

        /* Bottom corners adjustment for mobile */
        .corner-left-bottom,
        .corner-right-bottom {
            bottom: -50px;
            top: auto;
        }
    }

    @media (max-width: 768px) {
        .hero-carousel-height {
            height: 480px;
        }

        .carousel-keterangan {
            bottom: 60px;
        }

        .carousel-keterangan-text {
            font-size: 1.1rem !important;
            line-height: 1.4 !important;
        }

        /* Fix deformed/squished carousel buttons on mobile */
        .carousel-control-prev,
        .carousel-control-next {
            width: 15%;
            /* Increase width so buttons have breathing room */
        }

        .carousel-control-prev-icon-custom,
        .carousel-control-next-icon-custom {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            flex-shrink: 0;
            /* Prevent the circle from being squished */
        }
    }
</style>