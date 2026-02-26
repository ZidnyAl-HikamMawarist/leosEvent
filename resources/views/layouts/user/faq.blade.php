<section id="faq" class="py-5 position-relative overflow-hidden">


    <div class="container py-5 position-relative">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="section-tag mb-4 shadow-sm text-white">
                    {{ $setting->faq_tag ?? '❓ Support Portal' }}
                </div>
                <h2 class="display-4 fw-bold text-white font-secondary mb-4">
                    {{ $setting->faq_title ?? 'Frequently Asked Questions' }}
                </h2>
                <p class="text-muted fs-5 mb-5" style="max-width: 500px;">
                    {{ $setting->faq_subtitle ?? 'Have questions? We\'ve compiled a list of the most common inquiries to help you get started quickly.' }}
                </p>
                <div class="d-flex align-items-center gap-4 text-white-50">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-chat-quote-fill text-primary"></i>
                        <span>Active Support</span>
                    </div>
                    <div class="vr bg-secondary opacity-25" style="height: 20px;"></div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-patch-question-fill text-secondary"></i>
                        <span>24h Response</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="accordion faq-premium" id="accordionFAQ">
                    @foreach($faqs as $i => $faq)
                        <div class="accordion-item shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $i != 0 ? 'collapsed' : '' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}"
                                    aria-expanded="{{ $i == 0 ? 'true' : 'false' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <span
                                            class="bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small fw-bold">0{{ $i + 1 }}</span>
                                        {{ $faq->pertanyaan }}
                                    </div>
                                </button>
                            </h2>
                            <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i == 0 ? 'show' : '' }}"
                                data-bs-parent="#accordionFAQ">
                                <div class="accordion-body text-muted border-top border-white border-opacity-5">
                                    <div class="ps-3 border-start border-primary border-opacity-50">
                                        {{ $faq->jawaban }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($faqs->isEmpty())
                        <div class="bg-glass p-5 rounded-5 text-center border border-white border-opacity-10 py-5">
                            <i class="bi bi-question-circle fs-1 text-muted opacity-25 mb-4 d-block"></i>
                            <h4 class="text-white fw-bold">No FAQs available</h4>
                            <p class="text-muted mb-0">Our support team is currently preparing the documentation.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($setting && $setting->kontak)
            @php
                $wa = $setting->kontak;
                $formattedWa = preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', trim($wa)));
                if (!str_starts_with($formattedWa, '62') && !empty($formattedWa))
                    $formattedWa = '62' . $formattedWa;
                $waLink = !empty($formattedWa) ? "https://api.whatsapp.com/send?phone={$formattedWa}&text=Halo%20Panitia%20" . urlencode($setting->nama_event ?? 'Leos Event') . ",%20saya%20ingin%20bertanya..." : "#";
            @endphp
            <div class="mt-5 text-center p-5 rounded-5 bg-glass border border-white border-opacity-10 shadow-lg"
                data-aos="zoom-in" data-aos-delay="300">
                <h4 class="text-white fw-bold mb-3">Masih punya pertanyaan?</h4>
                <p class="text-muted mb-4 fs-5">Tim bantuan kami siap membantu Anda dengan pertanyaan apa pun.</p>
                <a href="{{ $waLink }}" target="_blank" class="btn btn-outline-custom rounded-pill px-5 hover-lift">
                    Hubungi Bantuan <i class="bi bi-whatsapp ms-2"></i>
                </a>
            </div>
        @endif
    </div>
</section>