<section id="cheer-wall" class="py-5 position-relative overflow-hidden mb-5">
    <div class="container position-relative z-1">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag mb-4 shadow-sm mx-auto d-inline-block text-white">
                📣 Virtual Cheer Wall
            </div>
            <h2 class="display-5 fw-bold text-white font-secondary mb-3">Tembok Dukungan</h2>
            <div class="divider-gradient mx-auto mb-4" style="width: 100px; height: 4px; border-radius: 2px;"></div>
            <p class="text-muted fs-6 mx-auto" style="max-width: 600px;">
                Berikan semangat dan dukunganmu untuk tim atau jagoanmu yang berkompetisi di Leos Event!
            </p>
        </div>

        @if(count($topParticipants) > 0)
            <div class="row g-4 mb-5 justify-content-center">
                <div class="col-12 text-center mb-4">
                    <h5 class="text-white fw-bold"><i class="bi bi-fire text-danger me-2"></i> Top 3 Peserta Terpopuler</h5>
                </div>
                @foreach($topParticipants as $tp)
                    <div class="col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="premium-card p-3 bg-glass border border-primary border-opacity-20 rounded-4 text-center shadow-lg position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 p-2">
                                <span class="badge bg-primary rounded-pill">#{{ $loop->iteration }}</span>
                            </div>
                            <div class="avatar-lg bg-primary bg-opacity-10 text-primary mx-auto d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                🏆
                            </div>
                            <h6 class="text-white fw-bold mb-1">{{ $tp->nama }}</h6>
                            <p class="text-white-50 small mb-2">{{ $tp->sekolah }}</p>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="text-primary fw-bold">{{ $tp->vote_count }}</span>
                                <small class="text-muted">Suara</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="divider-gradient mx-auto mb-5 opacity-25" style="width: 200px; height: 1px;"></div>
        @endif

        <div class="row g-4 mb-5">
            @forelse($supportMessages as $msg)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="premium-card p-4 bg-glass border border-white border-opacity-10 rounded-4 h-100 shadow-sm">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="avatar-circle bg-primary bg-opacity-20 text-primary d-flex align-items-center justify-content-center fw-bold rounded-circle" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($msg->nama, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="text-white fw-bold mb-0">{{ $msg->nama }}</h6>
                                @if($msg->lomba)
                                    <small class="text-primary text-uppercase" style="font-size: 0.7rem;">Mendukung: {{ $msg->lomba->nama_lomba }}</small>
                                @else
                                    <small class="text-muted" style="font-size: 0.7rem;">Dukungan Umum</small>
                                @endif
                            </div>
                        </div>
                        <p class="text-white-50 mb-0 font-italic" style="font-style: italic;">
                            "{{ $msg->pesan }}"
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada pesan dukungan. Jadilah yang pertama memberikan semangat!</p>
                </div>
            @endforelse
        </div>

        <div class="text-center">
            <button class="btn btn-primary-custom rounded-pill px-5 shadow-lg" data-bs-toggle="modal" data-bs-target="#cheerModal">
                <i class="bi bi-chat-heart-fill me-2"></i> Kirim Semangatmu
            </button>
        </div>
    </div>
</section>

<!-- Cheer Modal -->
<div class="modal fade" id="cheerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-glass border border-white border-opacity-10 rounded-5 p-2" style="background: rgba(15, 9, 8, 0.95); backdrop-filter: blur(20px);">
            <div class="modal-header border-0 justify-content-between px-4 pt-4">
                <h4 class="fw-bold text-white mb-0">Kirim Dukungan</h4>
                <button type="button" class="btn-close btn-close-white opacity-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('support-message.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 pb-5 pt-4">
                    <div class="mb-3">
                        <label class="form-label text-white-50 small">Nama Kamu</label>
                        <input type="text" name="nama" class="form-control glass-input-field" placeholder="Ketik namamu..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-50 small">Dukungan Untuk (Opsional)</label>
                        <select name="lomba_id" class="form-select glass-input-field">
                            <option value="">Semua Mata Lomba</option>
                            @foreach($lombas as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lomba }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white-50 small">Pesan Semangat (Max 300 Karakter)</label>
                        <textarea name="pesan" class="form-control glass-input-field" rows="3" placeholder="Contoh: Semangat buat tim futsal SMKN 1 Ciamis! Juara! 🔥" maxlength="300" required></textarea>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary-custom rounded-pill py-3 fw-bold">
                            Kirim Pesan <i class="bi bi-send-fill ms-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success_message'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="cheerToast" class="toast bg-success text-white rounded-3 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success_message') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('cheerToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 5000 });
                toast.show();
            }
        });
    </script>
@endif
