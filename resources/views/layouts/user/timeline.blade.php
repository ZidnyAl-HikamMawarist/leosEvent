@if($setting && $setting->is_save_the_date_active && ($setting->event_status !== 'finished'))
    <section id="timeline" class="py-5 position-relative overflow-hidden">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-tag mb-4 shadow-sm mx-auto d-inline-block text-white">
                    🕒 Countdown to Excellence
                </div>
                <h2 class="display-4 fw-bold text-white font-secondary mb-3">Save the <span
                        class="text-gradient">Date</span>
                </h2>

                @if($setting->event_status === 'upcoming' && $setting->event_start)
                    <!-- Countdown Timer -->
                    <div class="countdown-premium my-5 d-flex justify-content-center gap-3 gap-md-4" data-aos="zoom-in">
                        <div class="countdown-item">
                            <div class="countdown-value" id="days">00</div>
                            <div class="countdown-label">DAYS</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-value" id="hours">00</div>
                            <div class="countdown-label">HOURS</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-value" id="minutes">00</div>
                            <div class="countdown-label">MINUTES</div>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <div class="countdown-value" id="seconds">00</div>
                            <div class="countdown-label">SECONDS</div>
                        </div>
                    </div>
                @elseif($setting->event_status === 'ongoing')
                    <div class="my-5 p-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-4 d-inline-block shadow-lg animate-pulse"
                        data-aos="zoom-in">
                        <h3 class="display-6 fw-bold text-white mb-0">Sedang Berlangsung 🔥</h3>
                    </div>
                @else
                    <div class="my-5 p-4 bg-glass rounded-4 d-inline-block shadow-lg" data-aos="zoom-in">
                        <h3 class="display-6 fw-bold text-white mb-0 opacity-50">Coming Soon 🚀</h3>
                    </div>
                @endif
            </div>
@else
            <section id="timeline" class="py-5 position-relative overflow-hidden">
                <div class="container py-5">
        @endif

                <!-- Process Flow -->
                <div class="process-flow-wrapper mb-5" data-aos="fade-up">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="process-step text-center p-4">
                                <div class="step-icon mb-4 mx-auto">
                                    <i class="bi bi-pencil-square fs-1"></i>
                                    <span class="step-num">01</span>
                                </div>
                                <h4 class="text-white fw-bold">Pendaftaran</h4>
                                <p class="text-muted small">Daftarkan diri atau tim Anda secara online melalui form yang
                                    disediakan.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="process-step text-center p-4">
                                <div class="step-icon mb-4 mx-auto">
                                    <i class="bi bi-check2-all fs-1"></i>
                                    <span class="step-num">02</span>
                                </div>
                                <h4 class="text-white fw-bold">Daftar Ulang</h4>
                                <p class="text-muted small">Konfirmasi kehadiran dan verifikasi berkas administrative di
                                    lokasi.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="process-step text-center p-4">
                                <div class="step-icon mb-4 mx-auto">
                                    <i class="bi bi-trophy fs-1"></i>
                                    <span class="step-num">03</span>
                                </div>
                                <h4 class="text-white fw-bold">Pelaksanaan Lomba</h4>
                                <p class="text-muted small">Waktunya menunjukkan kemampuan terbaik Anda dalam kompetisi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-5 mt-5 pt-5" data-aos="fade-up">
                    <h3 class="fw-bold text-white mb-4">Mata Lomba Schedule</h3>
                </div>

                <div class="accordion accordion-flush bg-glass rounded-4 overflow-hidden border border-white border-opacity-10 mb-5"
                    id="lombaScheduleAccordion" data-aos="fade-up">
                    @foreach($lombas as $l)
                        <div class="accordion-item bg-transparent border-bottom border-white border-opacity-10">
                            <h2 class="accordion-header" id="headingLomba{{ $l->id }}">
                                <button class="accordion-button collapsed bg-transparent text-white fw-bold py-4"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseLomba{{ $l->id }}">
                                    <div class="d-flex align-items-center w-100 me-3 text-start">
                                        <span
                                            class="bg-primary bg-opacity-25 text-primary px-3 py-1 rounded-pill small me-3">
                                            {{ \Carbon\Carbon::parse($l->tanggal_pelaksanaan)->format('d M') }}
                                        </span>
                                        <span class="flex-grow-1">{{ $l->nama_lomba }}</span>
                                        <span class="text-secondary small">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $l->event_start ? \Carbon\Carbon::parse($l->event_start)->format('H:i') : '--:--' }}
                                            -
                                            {{ $l->event_end ? \Carbon\Carbon::parse($l->event_end)->format('H:i') : '--:--' }}
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseLomba{{ $l->id }}" class="accordion-collapse collapse"
                                data-bs-parent="#lombaScheduleAccordion">
                                <div class="accordion-body text-muted py-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 mb-3 mb-md-0">
                                            <img src="{{ asset('storage/' . $l->poster) }}"
                                                class="img-fluid rounded shadow-sm" style="max-height: 100px;">
                                        </div>
                                        <div class="col-md-10 text-start">
                                            <p class="mb-3">{{ Str::limit($l->deskripsi, 200) }}</p>
                                            <div class="d-flex flex-wrap gap-4 small text-white-50">
                                                <div><i
                                                        class="bi bi-geo-alt text-secondary me-2"></i>{{ $l->lokasi ?? 'TBA' }}
                                                </div>
                                                <div><i class="bi bi-people text-secondary me-2"></i>{{ $l->tingkat }}</div>
                                                @if($l->harga_tiket > 0)
                                                    <div><i class="bi bi-ticket-perforated text-secondary me-2"></i>Rp
                                                        {{ number_format($l->harga_tiket, 0, ',', '.') }}</div>
                                                @else
                                                    <div><i class="bi bi-ticket-perforated text-secondary me-2"></i>Gratis</div>
                                                @endif
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('lomba.detail', $l->slug) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-4">
                                                    Detail Lomba <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($lombas->isEmpty())
                        <div class="p-5 text-center">
                            <p class="text-muted mb-0">Belum ada jadwal mata lomba yang tersedia.</p>
                        </div>
                    @endif
                </div>

                <div class="text-center mb-5 mt-5 pt-5" data-aos="fade-up">
                    <h3 class="fw-bold text-white mb-4">Detailed Process Flow</h3>
                </div>

                <div class="timeline-flow-wrapper mt-4" data-aos="fade-up">
                    <div class="timeline-line"></div>
                    <div class="row g-0 position-relative">
                        @foreach($timelines as $t)
                            <div class="col-md-4 mb-5 mb-md-0">
                                <div class="timeline-flow-item text-center px-3">
                                    <div class="timeline-dot-wrapper mb-4">
                                        <div class="timeline-dot mx-auto">
                                            <div class="timeline-dot-inner"></div>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-glass p-4 rounded-4 border border-white border-opacity-10 h-100 transition-all hover-lift">
                                        <div class="text-primary fw-bold small mb-2 h5">
                                            {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                        </div>
                                        <h4 class="text-white fw-bold mb-3">{{ $t->judul }}</h4>
                                        <p class="text-muted mb-0 small leading-relaxed">{{ $t->deskripsi }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($timelines->isEmpty())
                        <div class="bg-glass p-5 rounded-5 text-center border border-white border-opacity-10"
                            data-aos="fade-up">
                            <i class="bi bi-calendar-x fs-1 text-muted opacity-25 mb-4 d-block"></i>
                            <h4 class="text-white fw-bold">No detailed events scheduled yet</h4>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        @if($setting && $setting->event_status === 'upcoming' && $setting->event_start)
            <script>
                // Countdown Timer Logic
                const countdownDate = new Date("{{ \Carbon\Carbon::parse($setting->event_start)->format('F d, Y H:i:s') }}").getTime();

                const x = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = countdownDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    if (document.getElementById("days")) {
                        document.getElementById("days").innerHTML = days < 10 ? "0" + days : days;
                        document.getElementById("hours").innerHTML = hours < 10 ? "0" + hours : hours;
                        document.getElementById("minutes").innerHTML = minutes < 10 ? "0" + minutes : minutes;
                        document.getElementById("seconds").innerHTML = seconds < 10 ? "0" + seconds : seconds;
                    }

                    if (distance < 0) {
                        clearInterval(x);
                        if (document.querySelector(".countdown-premium")) {
                            document.querySelector(".countdown-premium").innerHTML = "<h3 class='text-white'>EVENT STARTED</h3>";
                        }
                        // Proactively reload once to refresh status via ViewServiceProvider if auto-update is on
                        @if($setting->auto_update_status)
                            setTimeout(() => { location.reload(); }, 2000);
                        @endif
                        }
                }, 1000);
            </script>
        @endif

        <style>
            /* Countdown Styles */
            .countdown-premium {
                perspective: 1000px;
            }

            .countdown-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                min-width: 80px;
            }

            .countdown-value {
                font-family: 'font-secondary', sans-serif;
                font-size: 3.5rem;
                font-weight: 800;
                color: white;
                line-height: 1;
                margin-bottom: 5px;
                text-shadow: 0 0 20px rgba(197, 163, 83, 0.3);
            }

            @media (max-width: 576px) {
                .countdown-value {
                    font-size: 2.2rem;
                }

                .countdown-separator {
                    font-size: 2rem;
                }

                .countdown-item {
                    min-width: 60px;
                }

                .countdown-label {
                    font-size: 0.6rem;
                }
            }

            .countdown-label {
                font-size: 0.75rem;
                letter-spacing: 2px;
                color: var(--secondary);
                font-weight: 700;
                opacity: 0.8;
            }

            .countdown-separator {
                font-size: 3rem;
                color: white;
                opacity: 0.2;
                line-height: 1;
                padding-top: 5px;
            }

            /* Timeline Flow Styles */
            .timeline-flow-wrapper {
                position: relative;
            }

            .timeline-line {
                position: absolute;
                top: 25px;
                left: 50px;
                right: 50px;
                height: 2px;
                background: linear-gradient(to right, transparent, var(--primary), var(--secondary), transparent);
                opacity: 0.2;
                display: none;
            }

            @media (min-width: 768px) {
                .timeline-line {
                    display: block;
                }
            }

            /* Process Step Styles */
            .process-step {
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                border-radius: 24px;
                height: 100%;
                transition: all 0.4s ease;
            }

            .process-step:hover {
                background: rgba(255, 255, 255, 0.06);
                transform: translateY(-10px);
                border-color: var(--primary);
            }

            .step-icon {
                width: 100px;
                height: 100px;
                background: rgba(113, 47, 35, 0.1);
                border: 2px solid rgba(113, 47, 35, 0.2);
                color: var(--primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            .step-num {
                position: absolute;
                top: -5px;
                right: -5px;
                background: var(--secondary);
                color: white;
                width: 35px;
                height: 35px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 800;
                font-size: 0.9rem;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            }

            .timeline-dot {
                width: 50px;
                height: 50px;
                background: rgba(113, 47, 35, 0.1);
                /* Based on --primary */
                border: 1px solid rgba(113, 47, 35, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                z-index: 2;
                transition: all 0.3s ease;
            }

            .timeline-dot-inner {
                width: 12px;
                height: 12px;
                background: var(--primary);
                border-radius: 50%;
                box-shadow: 0 0 15px var(--primary);
            }

            .timeline-flow-item:hover .timeline-dot {
                transform: scale(1.2);
                background: var(--primary);
                border-color: var(--primary);
            }

            .timeline-flow-item:hover .timeline-dot-inner {
                background: white;
                box-shadow: 0 0 15px white;
            }

            @media (max-width: 767px) {
                .timeline-dot-wrapper {
                    display: none;
                }

                .timeline-flow-wrapper {
                    border-left: 2px solid rgba(113, 47, 35, 0.2);
                    padding-left: 20px;
                }
            }
        </style>