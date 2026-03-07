<section id="about" class="py-5 overflow-hidden">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <div class="about-image-wrapper position-relative z-1 rounded-5 overflow-hidden shadow-2xl">
                        <img src="{{ isset($setting->about_image) ? asset('storage/' . $setting->about_image) : asset('images/about.png') }}"
                            class="img-fluid w-100" alt="About Event"
                            style="transition: transform 1.5s ease; height: 500px; object-fit: cover;">

                        <!-- Floating Card (compact) -->
                        <div class="position-absolute bottom-0 start-0 p-3 w-100">
                            <div
                                class="bg-glass px-3 py-2 rounded-3 text-white shadow-lg border border-white border-opacity-10 d-inline-flex align-items-center gap-2">
                                <div class="bg-secondary text-dark p-1 rounded-2 d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px;">
                                    <i class="bi bi-stars fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold" style="font-size: 0.85rem;">
                                        {{ $setting->about_experience_label ?? 'Ajang Bergengsi' }}
                                    </h6>
                                    <p class="mb-0 text-white-50" style="font-size: 0.72rem;">
                                        {{ $setting->about_experience_sublabel ?? 'Tingkatkan potensimu' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ps-lg-5">
                    <div class="section-tag mb-4 shadow-sm text-white">
                        {{ $setting->about_tag ?? '✨ Tentang Lomba' }}
                    </div>
                    <h2 class="display-5 fw-bold text-white mb-4">
                        {{ $setting->about_title ?? 'Wujudkan Prestasimu di Ajang Kompetisi Ini' }}
                    </h2>
                    <p class="text-muted fs-5 mb-5 leading-relaxed">
                        {{ $setting->deskripsi_event ?? 'Bergabunglah dalam kompetisi paling seru tahun ini. Kami memberikan ruang bagi generasi muda untuk mengasah kreativitas, inovasi, dan keberanian dalam berkompetisi secara sportif.' }}
                    </p>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box bg-primary text-white p-3 rounded-4 shadow">
                                    <i class="bi {{ $setting->about_feature1_icon ?? 'bi-trophy' }} fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">
                                        {{ $setting->about_feature1_title ?? 'Kompetisi Sportif' }}
                                    </h6>
                                    <p class="small text-muted mb-0">
                                        {{ $setting->about_feature1_desc ?? 'Berkompetisi dan asah kemampuan terbaikmu.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box bg-secondary text-dark p-3 rounded-4 shadow">
                                    <i class="bi {{ $setting->about_feature2_icon ?? 'bi-award' }} fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">
                                        {{ $setting->about_feature2_title ?? 'Penghargaan' }}
                                    </h6>
                                    <p class="small text-muted mb-0">
                                        {{ $setting->about_feature2_desc ?? 'Menangkan piala, sertifikat, dan hadiah menarik.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box bg-white text-primary p-3 rounded-4 shadow">
                                    <i class="bi {{ $setting->about_feature3_icon ?? 'bi-people' }} fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">
                                        {{ $setting->about_feature3_title ?? 'Juri Profesional' }}
                                    </h6>
                                    <p class="small text-muted mb-0">
                                        {{ $setting->about_feature3_desc ?? 'Akan dinilai langsung secara adil dan objektif.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box p-3 rounded-4 shadow"
                                    style="background-color: var(--accent); color: var(--bg-body);">
                                    <i class="bi {{ $setting->about_feature4_icon ?? 'bi-patch-check' }} fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="text-white fw-bold mb-1">
                                        {{ $setting->about_feature4_title ?? 'Sertifikat Resmi' }}
                                    </h6>
                                    <p class="small text-muted mb-0">
                                        {{ $setting->about_feature4_desc ?? 'Dapatkan sertifikat untuk setiap partisipan.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('pendaftaran') }}"
                        class="btn btn-primary-custom btn-lg rounded-pill px-5 py-3 hover-lift shadow-sm">
                        {{ $setting->about_btn_text ?? 'Daftar Sekarang' }} <i
                            class="bi bi-chevron-right ms-2 small"></i>
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
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }

    .icon-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
    }
</style>