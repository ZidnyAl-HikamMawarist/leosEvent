<section id="lomba" class="py-5 position-relative overflow-hidden">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag mb-4 shadow-sm mx-auto d-inline-block">
                🏆 Active Competitions
            </div>
            <h2 class="display-4 fw-bold text-white font-secondary mb-3">Unleash Your <span
                    class="text-gradient">Potential</span></h2>
            <div class="divider-gradient mx-auto mb-4" style="width: 100px; height: 4px; border-radius: 2px;"></div>
            <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                Choose your field of excellence and compete with the best minds in the industry.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($lombas as $l)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="premium-card bg-glass overflow-hidden d-flex flex-column h-100">
                        <div class="position-relative overflow-hidden" style="height: 450px;">
                            <img src="{{ asset('storage/' . $l->poster) }}" class="img-fluid w-100 h-100 object-fit-cover"
                                alt="{{ $l->nama_lomba }}" style="transition: transform 0.6s ease;">
                            <div
                                class="position-absolute top-0 start-0 m-3 badge bg-primary bg-opacity-75 px-3 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-tag-fill me-1"></i> {{ $l->kategori }}
                            </div>
                        </div>

                        <div class="p-4 flex-grow-1 d-flex flex-column">
                            <h4 class="text-white fw-bold mb-3 h3">{{ $l->nama_lomba }}</h4>
                            <div class="d-flex align-items-center gap-3 text-white-50 small mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-calendar3 text-secondary"></i>
                                    <span>{{ \Carbon\Carbon::parse($l->tanggal_pelaksanaan)->format('d M Y') }}</span>
                                </div>
                                <div class="vr bg-secondary opacity-25" style="height: 15px;"></div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt text-secondary"></i>
                                    <span>{{ $l->tingkat }}</span>
                                </div>
                            </div>
                            <p class="text-muted small mb-4 line-clamp-3">
                                {{ $l->deskripsi }}
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('pendaftaran', ['lomba_id' => $l->id]) }}"
                                    class="btn btn-primary-custom w-100 rounded-pill py-3 fw-bold">
                                    Join Now <i class="bi bi-chevron-right ms-2 small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($lombas->isEmpty())
                <div class="col-12" data-aos="fade-up">
                    <div class="bg-glass p-5 rounded-5 text-center border border-white border-opacity-10 py-5">
                        <i class="bi bi-emoji-smile fs-1 text-muted opacity-25 mb-4 d-block"></i>
                        <h4 class="text-white fw-bold">Competitions coming soon</h4>
                        <p class="text-muted mb-0">We are currently finalizing the details for this season's events.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

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
</style>