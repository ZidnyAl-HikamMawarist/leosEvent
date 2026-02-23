<section id="about" class="py-5 overflow-hidden">


    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative p-4">
                    <!-- Glass Frame -->
                    <div
                        class="position-absolute top-0 start-0 w-100 h-100 border border-primary border-opacity-25 rounded-5 mt-3 ms-3 z-0">
                    </div>

                    <div class="about-image-wrapper position-relative z-1 rounded-5 overflow-hidden shadow-2xl">
                        <img src="{{ isset($setting->about_image) ? asset('storage/' . $setting->about_image) : asset('images/about.png') }}"
                            class="img-fluid w-100" alt="About Event"
                            style="transition: transform 1.5s ease; height: 600px; object-fit: cover;">

                        <!-- Floating Card -->
                        <div class="position-absolute bottom-0 start-0 p-4 w-100">
                            <div
                                class="bg-glass p-4 rounded-4 text-white shadow-lg border border-white border-opacity-10">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary p-2 rounded-3">
                                        <i class="bi bi-calendar-event fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Live Experiences</h6>
                                        <p class="small mb-0 text-white-50">Physical & Virtual Access</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ps-lg-5">
                    <div class="section-tag mb-4 shadow-sm text-white">
                        ✨ Discover Our Mission
                    </div>
                    <h2 class="display-4 fw-bold text-white mb-4 font-secondary">
                        Experience the <span class="text-gradient">Evolution</span> of Professional Growth
                    </h2>
                    <p class="text-muted fs-5 mb-5 leading-relaxed">
                        {{ $setting->deskripsi_event ?? 'Join us for an immersive experience that transcends traditional events. We focus on bridging the gap between today\'s innovations and tomorrow\'s potential through expert talks and hands-on networking.' }}
                    </p>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div
                                    class="icon-box bg-primary bg-opacity-10 text-primary p-3 rounded-4 border border-primary border-opacity-10">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">Global Speakers</h6>
                                    <p class="small text-muted mb-0">Learn from world-class industry pioneers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div
                                    class="icon-box bg-secondary bg-opacity-10 text-secondary p-3 rounded-4 border border-secondary border-opacity-10">
                                    <i class="bi bi-people fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">Elite Networking</h6>
                                    <p class="small text-muted mb-0">Connect with influential professionals.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div
                                    class="icon-box bg-accent bg-opacity-10 text-accent p-3 rounded-4 border border-accent border-opacity-10">
                                    <i class="bi bi-cpu fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">Modern Workshops</h6>
                                    <p class="small text-muted mb-0">Hands-on learning with latest tools.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div
                                    class="icon-box bg-warning bg-opacity-10 text-warning p-3 rounded-4 border border-warning border-opacity-10">
                                    <i class="bi bi-patch-check fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">Verified Certificate</h6>
                                    <p class="small text-muted mb-0">Boost your professional portfolio.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('pendaftaran') }}"
                        class="btn btn-primary-custom btn-lg rounded-pill px-5 py-3 hover-lift shadow-sm">
                        Start Your Journey <i class="bi bi-chevron-right ms-2 small"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .about-image-wrapper:hover img {
        transform: scale(1.05);
    }

    .icon-box {
        transition: all 0.3s ease;
    }

    .icon-box:hover {
        transform: translateY(-5px);
        background-opacity: 0.2;
    }
</style>