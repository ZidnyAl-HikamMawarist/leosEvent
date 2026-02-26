@extends('layouts.admin.layout')
@section('title', 'Kustomisasi Teks Galeri')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-images text-primary me-2"></i>Kustomisasi Teks Bagian "Galeri"
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Galeri Tag (Badge)</label>
                            <input type="text" name="galeri_tag" class="form-control"
                                value="{{ $setting->galeri_tag ?? '📸 Visual Journey' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Galeri Title (Judul Utama)</label>
                            <input type="text" name="galeri_title" class="form-control"
                                value="{{ $setting->galeri_title ?? 'Event Highlights' }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Galeri Subtitle (Penjelasan singkat)</label>
                            <textarea name="galeri_subtitle" class="form-control"
                                rows="3">{{ $setting->galeri_subtitle ?? 'Relive the most memorable moments from our previous sessions and special gatherings.' }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Batas Jumlah Foto Utama (Limit)</label>
                            <input type="number" name="galeri_limit" class="form-control"
                                value="{{ $setting->galeri_limit ?? 6 }}" min="3" max="20" required>
                            <div class="form-text">Berapa banyak foto utama yang akan ditampilkan di beranda (*sisanya
                                adalah slot cadangan). Kapasitas server = <strong>Batas Foto Utama + 3.</strong></div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Untuk menambah atau menghapus foto di dalam galeri, silakan ke menu <strong><a
                                    href="{{ route('galeri.index') }}">Galeri Foto</a></strong>.
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow">
                                    <i class="bi bi-save me-2"></i> Simpan Teks Galeri
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection