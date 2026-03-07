<section id="lomba" class="pt-0 pb-5 position-relative overflow-hidden">
    <div class="container pt-0 pb-5">
        <div class="text-center mb-5" data-aos="fade-up">

            <div class="d-flex justify-content-center mb-5" data-aos="fade-up">
                <div class="btn-group p-1 bg-glass rounded-pill border border-white border-opacity-10">
                    @foreach($availableYears as $year)
                        <a href="?year={{ $year }}#lomba"
                            class="btn rounded-pill px-4 py-2 {{ $selectedYear == $year ? 'btn-primary' : 'text-white' }}">
                            {{ $year }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="section-tag mb-4 shadow-sm mx-auto d-inline-block text-white">
                {{ $setting->lomba_tag ?? '🏆 Active Competitions' }}
            </div>
            <h2 class="display-4 fw-bold text-white font-secondary mb-3">
                {{ $setting->lomba_title ?? 'Unleash Your Potential' }}
            </h2>
            <div class="divider-gradient mx-auto mb-4" style="width: 100px; height: 4px; border-radius: 2px;"></div>
            <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                {{ $setting->lomba_subtitle ?? 'Choose your field of excellence and compete with the best minds in the industry.' }}
            </p>
        </div>

        <!-- Container with smooth marquee effect or refined scroll -->
        <div id="lombaScrollContainer" class="d-flex flex-nowrap overflow-x-auto pb-4 gap-4 custom-scrollbar">
            @foreach($lombas as $l)
                <div style="flex: 0 0 250px; scroll-snap-align: start;">
                    <div
                        class="premium-card bg-glass overflow-hidden d-flex flex-column h-100 shadow-lg border border-white border-opacity-10 rounded-4">
                        <a href="{{ route('lomba.detail', $l->slug) }}" class="text-decoration-none">
                            <div class="position-relative overflow-hidden w-100 rounded-top-4" style="height: 200px;">
                                <img src="{{ asset('storage/' . $l->poster) }}" class="w-100 h-100"
                                    style="object-fit: cover; object-position: center; transition: transform 0.3s ease;"
                                    alt="{{ $l->nama_lomba }}">
                            </div>
                        </a>

                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <a href="{{ route('lomba.detail', $l->slug) }}" class="text-decoration-none mb-2">
                                <h6 class="text-white fw-bold mb-0 text-uppercase"
                                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.8em; line-height: 1.4;">
                                    {{ $l->nama_lomba }}
                                </h6>
                            </a>


                            <div class="mt-auto">
                                <a href="{{ route('pendaftaran', ['lomba_id' => $l->id]) }}"
                                    class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm">
                                    Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('lombaScrollContainer');
        if (!container) return;

        let isHovered = false;
        let scrollSpeed = 0.5; // Kecepatan gerak (pixel per frame)

        const smoothLoop = () => {
            if (!isHovered) {
                container.scrollLeft += scrollSpeed;

                // Jika sudah sampai di paling kanan (dengan toleransi), balik ke awal secara smooth
                if (container.scrollLeft >= (container.scrollWidth - container.clientWidth - 1)) {
                    container.scrollLeft = 0;
                }
            }
            requestAnimationFrame(smoothLoop);
        };

        // Mulai animasi halus
        requestAnimationFrame(smoothLoop);

        // Slow down on hover instead of full stop for more "premium" feel, or full stop if preferred
        container.addEventListener('mouseenter', () => { isHovered = true; });
        container.addEventListener('mouseleave', () => { isHovered = false; });

        // Touch support
        container.addEventListener('touchstart', () => { isHovered = true; }, { passive: true });
        container.addEventListener('touchend', () => { isHovered = false; }, { passive: true });
    });
</script>

<style>
    .premium-card:hover img {
        transform: scale(1.1);
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .divider-gradient {
        background: linear-gradient(to right, var(--primary), var(--secondary));
    }

    .hover-scale-110:hover {
        transform: scale(1.1);
    }

    /* Menghaluskan scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        height: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }

    /* Memastikan konten tidak terpotong */
    .flex-nowrap {
        display: flex !important;
        -webkit-overflow-scrolling: touch;
    }
</style>