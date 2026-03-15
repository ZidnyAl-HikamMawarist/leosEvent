@extends('layouts.app')

@section('title', $lomba->nama_lomba)

@section('content')
    <div class="container py-5" style="margin-top: 100px;">

        <div class="row g-5">
            <!-- Kolom Kiri: Gambar Utama -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
                    <img src="{{ asset('storage/' . $lomba->poster) }}"
                        class="img-fluid w-100 transition-transform hover-zoom" alt="{{ $lomba->nama_lomba }}"
                        style="transition: 0.5s">
                </div>
            </div>

            <!-- Kolom Kanan: Detail Konten -->
            <div class="col-lg-7">
                <div class="ps-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge border border-primary text-primary px-3 py-2 rounded-pill bg-white">
                            {{ ucfirst($lomba->kategori) }}
                        </span>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                            {{ ucfirst($lomba->status) }}
                        </span>
                    </div>

                    <h1 class="display-5 fw-bold text-white mb-2 font-secondary">{{ $lomba->nama_lomba }}</h1>
                    <div class="h5 text-accent mb-4 fw-normal">Tingkat: {{ $lomba->tingkat }}</div>
                    
                    <p class="text-white-50 mb-5 fs-5 lh-lg">{{ $lomba->deskripsi }}</p>

                    {{-- Info Grid --}}
                    <div class="row g-4 mb-5">
                        <div class="col-sm-6">
                            <div class="info-item d-flex align-items-center p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10">
                                <div class="info-icon me-3 h2 mb-0 text-accent">📅</div>
                                <div>
                                    <div class="small text-white-50">Tanggal</div>
                                    <div class="fw-bold text-white">{{ \Carbon\Carbon::parse($lomba->tanggal_pelaksanaan)->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-item d-flex align-items-center p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10">
                                <div class="info-icon me-3 h2 mb-0 text-accent">📍</div>
                                <div>
                                    <div class="small text-white-50">Lokasi</div>
                                    <div class="fw-bold text-white">{{ $lomba->lokasi ?? 'Online / TBA' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-item d-flex align-items-center p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10">
                                <div class="info-icon me-3 h2 mb-0 text-accent">💰</div>
                                <div>
                                    <div class="small text-white-50">Biaya Pendaftaran</div>
                                    <div class="fw-bold text-white">Rp {{ number_format($lomba->harga_tiket, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-item d-flex align-items-center p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10">
                                <div class="info-icon me-3 h2 mb-0 text-accent">📎</div>
                                <div>
                                    <div class="small text-white-50">Pedoman Lomba</div>
                                    <a href="{{ $lomba->juklak_juknis_link }}" class="fw-bold text-accent text-decoration-none" target="_blank">Download Juklak/Juknis</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="/pendaftaran" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold">Daftar Sekarang</a>
                        <a href="/" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill glass-effect fw-bold">Kembali</a>
                    </div>

                    {{-- Section Polling --}}
                    @if(count($participants) > 0)
                        <div class="mt-5 pt-5 border-top border-white border-opacity-10">
                            <h3 class="text-white fw-bold mb-4 font-secondary">🔥 Vote Jagoanmu</h3>
                            <p class="text-white-50 small mb-4">Berikan dukunganmu untuk tim favorit di mata lomba ini. 1 vote per jam untuk setiap jagoan!</p>
                            
                            @if(session('success_vote'))
                                <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-20 text-success rounded-4 mb-4">
                                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success_vote') }}
                                </div>
                            @endif
                            
                            @if(session('error_vote'))
                                <div class="alert alert-warning bg-warning bg-opacity-10 border-warning border-opacity-20 text-warning rounded-4 mb-4">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error_vote') }}
                                </div>
                            @endif

                            <div class="row g-3">
                                @foreach($participants as $p)
                                    <div class="col-12" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                        <div class="p-3 rounded-4 bg-glass d-flex align-items-center justify-content-between shadow-sm hover-lift">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rank-badge bg-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 36px; height: 36px; font-size: 0.85rem; color: var(--bg-body);">
                                                    #{{ $loop->iteration }}
                                                </div>
                                                <div>
                                                    <div class="text-white fw-bold">{{ $p->nama }}</div>
                                                    <small class="text-white-50">{{ $p->sekolah }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="text-end me-2">
                                                    <div class="text-primary fw-bold mb-0 vote-count" id="count-{{ $p->id }}">{{ $p->vote_count }}</div>
                                                    <small class="text-white-50" style="font-size: 0.7rem;">Suara</small>
                                                </div>
                                                <form action="{{ route('vote.store') }}" method="POST" class="vote-form">
                                                    @csrf
                                                    <input type="hidden" name="participant_id" value="{{ $p->id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-vote">
                                                        Vote <i class="bi bi-heart-fill ms-1"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Toast Notification Container --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
        <div id="voteToast" class="toast align-items-center text-white border-0 rounded-4 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i id="toastIcon" class="bi fs-4"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const voteForms = document.querySelectorAll('.vote-form');
            const toastElement = document.getElementById('voteToast');
            const toastObj = new bootstrap.Toast(toastElement, { delay: 4000 });
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = document.getElementById('toastIcon');

            function showToast(message, type = 'success') {
                toastMessage.innerText = message;
                toastElement.classList.remove('bg-success', 'bg-danger', 'bg-warning');
                
                if (type === 'success') {
                    toastElement.classList.add('bg-success');
                    toastIcon.className = 'bi bi-check-circle-fill text-white';
                } else if (type === 'error' || type === 'warning') {
                    toastElement.classList.add('bg-danger');
                    toastIcon.className = 'bi bi-exclamation-triangle-fill text-white';
                }
                
                toastObj.show();
            }

            voteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const btn = form.querySelector('.btn-vote');
                    const originalBtnContent = btn.innerHTML;
                    const participantId = form.querySelector('input[name="participant_id"]').value;
                    const voteCountElement = document.getElementById('count-' + participantId);

                    // Loading state
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            participant_id: participantId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showToast(data.message, 'success');
                            if (voteCountElement && data.new_vote_count) {
                                voteCountElement.innerText = data.new_vote_count;
                                // Visual pop effect
                                voteCountElement.classList.add('animate__animated', 'animate__bounceIn');
                                setTimeout(() => {
                                    voteCountElement.classList.remove('animate__animated', 'animate__bounceIn');
                                }, 1000);
                            }
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan saat mencoba mengirim vote.', 'error');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalBtnContent;
                    });
                });
            });
        });
    </script>
@endsection