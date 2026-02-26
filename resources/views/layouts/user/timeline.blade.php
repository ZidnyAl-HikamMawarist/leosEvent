@if($setting && $setting->is_save_the_date_active && ($setting->event_status !== 'finished'))
    <section id="timeline" class="pt-5 pb-2 position-relative overflow-hidden">
        <div class="container pt-5 pb-2">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-tag mb-4 shadow-sm mx-auto d-inline-block text-white">
                    {{ $setting->countdown_tag ?? '🕒 Countdown to Excellence' }}
                </div>
                <h2 class="display-4 fw-bold text-white font-secondary mb-3">
                    {{ $setting->countdown_title ?? 'Save the' }}
                    <span class="text-gradient">{{ $setting->countdown_subtitle ?? 'Date' }}</span>
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
            <section id="timeline" class="pt-5 pb-2 position-relative overflow-hidden">
                <div class="container pt-5 pb-2">
        @endif

                <!-- Process Flow -->
                <div class="process-flow-wrapper mb-1 mb-md-2" data-aos="fade-up">
                    <div class="row g-4">
                        <!-- Step 1 -->
                        <div class="col-md-4">
                            <div class="process-step text-center p-4">
                                <div class="step-icon mb-4 mx-auto">
                                    <i class="bi {{ $setting->process_icon1 ?? 'bi-pencil-square' }} fs-1"></i>
                                    <span class="step-num">01</span>
                                </div>
                                <h4 class="text-white fw-bold">{{ $setting->process_title1 ?? 'Pendaftaran' }}</h4>
                                <p class="text-muted small">
                                    {{ $setting->process_desc1 ?? 'Daftarkan diri atau tim Anda secara online melalui form yang disediakan.' }}
                                </p>
                            </div>
                        </div>
                        <!-- Step 2 -->
                        <div class="col-md-4">
                            <div class="process-step text-center p-4">
                                <div class="step-icon mb-4 mx-auto">
                                    <i class="bi {{ $setting->process_icon2 ?? 'bi-check2-all' }} fs-1"></i>
                                    <span class="step-num">02</span>
                                </div>
                                <h4 class="text-white fw-bold">{{ $setting->process_title2 ?? 'Daftar Ulang' }}</h4>
                                <p class="text-muted small">
                                    {{ $setting->process_desc2 ?? 'Konfirmasi kehadiran dan verifikasi berkas administrative di lokasi.' }}
                                </p>
                            </div>
                        </div>
                        <!-- Step 3 -->
                        <div class="col-md-4">
                            <div class="process-step text-center p-4">
                                <div class="step-icon mb-4 mx-auto">
                                    <i class="bi {{ $setting->process_icon3 ?? 'bi-trophy' }} fs-1"></i>
                                    <span class="step-num">03</span>
                                </div>
                                <h4 class="text-white fw-bold">{{ $setting->process_title3 ?? 'Pelaksanaan Lomba' }}
                                </h4>
                                <p class="text-muted small">
                                    {{ $setting->process_desc3 ?? 'Waktunya menunjukkan kemampuan terbaik Anda dalam kompetisi.' }}
                                </p>
                            </div>
                        </div>
                    </div>
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
                        @if($setting->auto_update_status)
                            setTimeout(() => { location.reload(); }, 2000);
                        @endif
                                                    }
                }, 1000);
            </script>
        @endif

        <style>
            .section-tag {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                padding: 8px 20px;
                border-radius: 50px;
                font-size: 0.85rem;
                letter-spacing: 2px;
                font-weight: 600;
                text-transform: uppercase;
            }

            .text-gradient {
                background: linear-gradient(to right, #fff, var(--secondary));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

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