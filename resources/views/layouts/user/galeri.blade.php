<section id="galeri" class="pt-5 pb-3 overflow-hidden">
    <div class="container pt-4 pb-2">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag mb-4 shadow-sm text-white">
                {{ $setting->galeri_tag ?? '📸 Visual Journey' }}
            </div>
            <h2 class="display-4 fw-bold text-white font-secondary">
                {{ $setting->galeri_title ?? 'Event Highlights' }}
            </h2>
            <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                {{ $setting->galeri_subtitle ?? 'Relive the most memorable moments from our previous sessions and special gatherings.' }}
            </p>
        </div>

        <div class="galeri-grid">
            @foreach($galeris as $g)
                <div class="galeri-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="galeri-img-wrapper group shadow-2xl rounded-4 overflow-hidden">
                        <img src="{{ asset('storage/' . $g->gambar) }}" class="img-fluid w-100 h-100 object-fit-cover"
                            alt="Gallery Image">

                        <div class="galeri-overlay">
                            <div class="overlay-content w-100">
                                <span class="badge bg-primary rounded-pill mb-2 px-3">Highlight</span>
                                <h5 class="text-white fw-bold mb-0">{{ $g->judul }}</h5>
                            </div>
                            <div class="zoom-icon-btn ms-auto">
                                <i class="bi bi-fullscreen text-white fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($galeris->isEmpty())
                <div class="w-100" data-aos="fade-up">
                    <div class="bg-glass p-5 rounded-5 text-center border border-white border-opacity-10 py-5 my-5">
                        <i class="bi bi-images fs-1 text-muted opacity-25 mb-4 d-block"></i>
                        <h4 class="text-white fw-bold">Memories being processed</h4>
                        <p class="text-muted mb-0">Our media team is currently curating the best shots for you.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .galeri-grid {
        column-count: 3;
        column-gap: 20px;
        margin-top: 1.5rem;
    }

    .galeri-item {
        break-inside: avoid;
        margin-bottom: 20px;
        position: relative;
    }

    .galeri-img-wrapper {
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.4s ease, border-color 0.4s ease;
    }

    /* Remove fixed height so images look masonry-style */
    .galeri-img-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 1rem;
        transition: transform 0.5s ease;
    }

    .galeri-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 9, 8, 0.9) 0%, rgba(15, 9, 8, 0.4) 50%, rgba(15, 9, 8, 0) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.5rem;
    }

    .galeri-img-wrapper:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
    }

    .galeri-img-wrapper:hover img {
        transform: scale(1.05);
    }

    .galeri-img-wrapper:hover .galeri-overlay {
        opacity: 1;
    }

    @media (max-width: 991.98px) {
        .galeri-grid {
            column-count: 2;
        }
    }

    @media (max-width: 767.98px) {
        .galeri-grid {
            column-count: 2;
            column-gap: 10px;
        }

        .galeri-item {
            margin-bottom: 10px;
        }

        .galeri-overlay {
            padding: 0.8rem;
        }

        .galeri-overlay .badge {
            font-size: 0.6rem;
            padding: 0.2rem 0.5rem;
        }

        .galeri-overlay h5 {
            font-size: 0.85rem;
        }

        .zoom-icon-btn {
            width: 30px;
            height: 30px;
        }

        .zoom-icon-btn i {
            font-size: 0.9rem !important;
        }
    }

    .zoom-icon-btn {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .galeri-img-wrapper:hover .zoom-icon-btn {
        transform: translateY(0);
        opacity: 1;
    }
</style>