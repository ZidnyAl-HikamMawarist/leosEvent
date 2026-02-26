@extends('layouts.admin.layout')
@section('title', 'Kustomisasi Hero & Promo')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-megaphone text-primary me-2"></i>Teks Promo Hero & Tombol
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-4 pt-2">
                            <h6 class="fw-bold border-bottom pb-2 mb-3">Teks Carousel/Banner</h6>
                            <div class="mb-3">
                                <label class="form-label small">Tag Promo Hero (Badge)</label>
                                <input type="text" name="hero_tag" class="form-control"
                                    value="{{ $setting->hero_tag ?? 'THE MOST AWAITED EVENT' }}">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small">Judul Hero (Besar)</label>
                                <input type="text" name="hero_title" class="form-control"
                                    value="{{ $setting->hero_title ?? 'Experience The New Standard' }}">
                                <small class="text-muted">Teks ini akan muncul jika slider carousel kosong atau sebagai teks
                                    default.</small>
                            </div>
                        </div>

                        <div class="mb-4 pt-2">
                            <h6 class="fw-bold border-bottom pb-2 mb-3">Teks Tombol Aksi (Call to Action)</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Tombol Utama (Primary)</label>
                                    <input type="text" name="hero_primary_btn_text" class="form-control"
                                        value="{{ $setting->hero_primary_btn_text ?? 'Join Now' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Tombol Kedua (Secondary)</label>
                                    <input type="text" name="hero_secondary_btn_text" class="form-control"
                                        value="{{ $setting->hero_secondary_btn_text ?? 'Learn More' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow">
                                    <i class="bi bi-save me-2"></i> Simpan Teks Hero
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection