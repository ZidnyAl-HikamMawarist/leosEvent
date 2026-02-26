@extends('layouts.admin.layout')
@section('title', 'Kustomisasi FAQ & Lomba')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-card-text text-primary me-2"></i>Kustomisasi Teks FAQ & Lomba
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- FAQ Info -->
                            <div class="col-md-12 mb-5">
                                <h6 class="fw-bold border-bottom pb-2 mb-3">Informasi Bagian FAQ</h6>
                                <div class="mb-3">
                                    <label class="form-label small">FAQ Tag (Badge)</label>
                                    <input type="text" name="faq_tag" class="form-control"
                                        value="{{ $setting->faq_tag ?? '❓ Support Portal' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">FAQ Title (Judul)</label>
                                    <input type="text" name="faq_title" class="form-control"
                                        value="{{ $setting->faq_title ?? 'Frequently Asked Questions' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">FAQ Subtitle (Penjelasan)</label>
                                    <textarea name="faq_subtitle" class="form-control"
                                        rows="3">{{ $setting->faq_subtitle ?? 'Have questions? We\'ve compiled a list of the most common inquiries to help you get started quickly.' }}</textarea>
                                </div>
                            </div>

                            <!-- Lomba Info -->
                            <div class="col-md-12">
                                <h6 class="fw-bold border-bottom pb-2 mb-3">Informasi Bagian Lomba</h6>
                                <div class="mb-3">
                                    <label class="form-label small">Lomba Tag (Badge)</label>
                                    <input type="text" name="lomba_tag" class="form-control"
                                        value="{{ $setting->lomba_tag ?? '🏆 Active Competitions' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Lomba Title (Judul)</label>
                                    <input type="text" name="lomba_title" class="form-control"
                                        value="{{ $setting->lomba_title ?? 'Unleash Your Potential' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Lomba Subtitle (Penjelasan)</label>
                                    <textarea name="lomba_subtitle" class="form-control"
                                        rows="3">{{ $setting->lomba_subtitle ?? 'Choose your field of excellence and compete with the best minds in the industry.' }}</textarea>
                                </div>
                            </div>

                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Teks ini muncul sebagai pengantar pada daftar Lomba dan FAQ di halaman depan. Untuk isi detail,
                            gunakan menu Lomba atau FAQ di sidebar.
                        </div>

                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow">
                                    <i class="bi bi-save me-2"></i> Simpan Teks Informasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection