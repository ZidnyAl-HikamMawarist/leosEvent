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
                                    <a href="{{ $lomba->juklak_juknis_link }}" class="fw-bold text-accent text-decoration-none">Download Juklak/Juknis</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Winners Section --}}
                    @if($lomba->juara_1 || $lomba->juara_2 || $lomba->juara_3)
                    <div class="winners-box p-4 rounded-4 mb-5 border border-accent border-opacity-20" style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%);">
                        <h5 class="text-accent fw-bold mb-4 d-flex align-items-center">
                            <i class="bi bi-trophy-fill me-2"></i> Pengumuman Pemenang
                        </h5>
                        <div class="row g-3">
                            @if($lomba->juara_1)
                            <div class="col-12">
                                <div class="winner-item d-flex align-items-center p-2 rounded-3 bg-white bg-opacity-5">
                                    <span class="me-3 h4 mb-0">🥇</span>
                                    <div>
                                        <div class="small text-white-50">Juara 1</div>
                                        <div class="fw-bold text-white">{{ $lomba->juara_1 }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($lomba->juara_2)
                            <div class="col-6">
                                <div class="winner-item d-flex align-items-center p-2 rounded-3 bg-white bg-opacity-5">
                                    <span class="me-3 h4 mb-0">🥈</span>
                                    <div>
                                        <div class="small text-white-50">Juara 2</div>
                                        <div class="fw-bold text-white">{{ $lomba->juara_2 }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($lomba->juara_3)
                            <div class="col-6">
                                <div class="winner-item d-flex align-items-center p-2 rounded-3 bg-white bg-opacity-5">
                                    <span class="me-3 h4 mb-0">🥉</span>
                                    <div>
                                        <div class="small text-white-50">Juara 3</div>
                                        <div class="fw-bold text-white">{{ $lomba->juara_3 }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="d-flex flex-wrap gap-3">
                        <a href="/pendaftaran" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold">Daftar Sekarang</a>
                        <a href="/" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill glass-effect fw-bold">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection