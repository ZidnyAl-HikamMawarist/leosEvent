<section id="galeri" class="py-5 overflow-hidden">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag mb-4 shadow-sm">
                📸 Visual Journey
            </div>
            <h2 class="display-4 fw-bold text-white font-secondary">Event <span class="text-gradient">Highlights</span>
            </h2>
            <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                Relive the most memorable moments from our previous sessions and special gatherings.
            </p>
        </div>

        <div class="row g-4 mt-4">
            @foreach($galeris as $g)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="galeri-img-wrapper group shadow-2xl">
                        <img src="{{ asset('storage/' . $g->gambar) }}" class="img-fluid w-100 h-100 object-fit-cover"
                            alt="Gallery Image">

                        <div class="galeri-overlay">
                            <div class="overlay-content w-100">
                                <span class="badge bg-primary rounded-pill mb-2 px-3">Moment</span>
                                <h5 class="text-white fw-bold mb-0">Captured Excellence</h5>
                                <p class="text-white-50 small mb-0">Event Atmosphere</p>
                            </div>
                            <div class="zoom-icon-btn ms-auto">
                                <i class="bi bi-fullscreen text-white fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($galeris->isEmpty())
                <div class="col-12" data-aos="fade-up">
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
    .galeri-img-wrapper {
        height: 350px;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.05);
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

    .galeri-img-wrapper:hover {
        border-color: var(--primary);
    }
</style>