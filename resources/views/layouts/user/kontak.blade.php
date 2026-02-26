@extends('layouts.app')

@section('content')
    <section class="py-5 mt-5 position-relative overflow-hidden min-vh-100 d-flex align-items-center">
        <!-- Background Elements -->
        <div class="blob-decor bg-primary opacity-5 top-0 start-0 w-75 h-75" style="filter: blur(150px);"></div>
        <div class="blob-decor bg-secondary opacity-5 bottom-0 end-0 w-50 h-50" style="filter: blur(120px);"></div>

        <div class="container position-relative z-1 py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5" data-aos="fade-up">
                        <div class="section-tag mb-4 shadow-sm">
                            ✉️ Get In Touch
                        </div>
                        <h2 class="display-4 fw-bold text-white font-secondary">Contact Our <span
                                class="text-gradient">Team</span></h2>
                        <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                            Whether you're an attendee, speaker, or sponsor, we're here to assist you with any inquiries.
                        </p>
                    </div>

                    <div class="row g-4 align-items-stretch mt-4">
                        <!-- Contact Info Card -->
                        <div class="col-lg-4" data-aos="fade-right">
                            <div class="premium-card bg-glass h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <h4 class="text-white fw-bold mb-4">Support Info</h4>
                                    <div class="mb-5">
                                        <p class="text-muted small text-uppercase fw-bold letter-spacing-2 mb-3">
                                            Headquarters</p>
                                        <p class="text-white opacity-75">Digital Innovation Center, 42nd Floor<br>Jakarta,
                                            Indonesia</p>
                                    </div>
                                    <div class="mb-5">
                                        <p class="text-muted small text-uppercase fw-bold letter-spacing-2 mb-3">Office
                                            Hours</p>
                                        <p class="text-white opacity-75">Mon - Fri: 09:00 - 18:00<br>Sat: 10:00 - 14:00</p>
                                    </div>
                                </div>
                                <div class="social-links d-flex gap-2">
                                    <a href="#" class="social-icon-btn"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="social-icon-btn"><i class="bi bi-instagram"></i></a>
                                    <a href="#" class="social-icon-btn"><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Main Contact Methods -->
                        <div class="col-lg-8" data-aos="fade-left">
                            <div class="bg-glass p-1 rounded-5 border border-white border-opacity-10 h-100">
                                <div class="row g-0 h-100">
                                    <div class="col-md-6 border-end border-white border-opacity-5">
                                        <div
                                            class="p-5 text-center contact-method-item h-100 d-flex flex-column align-items-center justify-content-center">
                                            <div
                                                class="bg-primary bg-opacity-10 text-primary p-4 rounded-circle mb-4 border border-primary border-opacity-10">
                                                <i class="bi bi-envelope-at fs-1"></i>
                                            </div>
                                            <h4 class="text-white fw-bold mb-2">Email Support</h4>
                                            <p class="text-muted small mb-4">Drop us a line anytime!</p>
                                            <a href="mailto:{{ $setting->kontak_email ?? 'support@leosevent.com' }}"
                                                class="btn btn-outline-custom rounded-pill w-100">
                                                {{ $setting->kontak_email ?? 'support@leosevent.com' }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="p-5 text-center contact-method-item h-100 d-flex flex-column align-items-center justify-content-center">
                                            <div
                                                class="bg-secondary bg-opacity-10 text-secondary p-4 rounded-circle mb-4 border border-secondary border-opacity-10">
                                                <i class="bi bi-whatsapp fs-1"></i>
                                            </div>
                                            <h4 class="text-white fw-bold mb-2">Live WhatsApp</h4>
                                            <p class="text-muted small mb-4">Chat with our representative.</p>
                                            @php
                                                $wa = $setting->kontak ?? '6281234567890';
                                                $formattedWa = preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', trim($wa)));
                                                if (!str_starts_with($formattedWa, '62') && !empty($formattedWa))
                                                    $formattedWa = '62' . $formattedWa;
                                            @endphp
                                            <a href="https://api.whatsapp.com/send?phone={{ $formattedWa }}"
                                                class="btn btn-primary-custom rounded-pill w-100">
                                                +{{ $wa }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Decorative Section -->
                    <div class="mt-5 text-center" data-aos="fade-up" data-aos-delay="400">
                        <div
                            class="bg-glass p-4 rounded-pill d-inline-flex align-items-center gap-3 border border-white border-opacity-5">
                            <span class="pulse-dot"></span>
                            <span class="text-muted small">Our average response time today is <strong class="text-white">12
                                    minutes</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .contact-method-item {
            transition: all 0.4s ease;
        }

        .contact-method-item:hover {
            background: rgba(255, 255, 255, 0.02);
        }
    </style>
@endsection