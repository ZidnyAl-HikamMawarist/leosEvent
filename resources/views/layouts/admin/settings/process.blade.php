@extends('layouts.admin.layout')
@section('title', 'Kustomisasi Process Flow')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-arrow-repeat text-primary me-2"></i>Kustomisasi Save the Date & Process Flow
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row g-4 mb-4 pb-4 border-bottom">
                            <div class="col-md-12">
                                <h6 class="fw-bold text-primary mb-3">Header Section (Save the Date)</h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label small">Countdown Tag (Badge)</label>
                                        <input type="text" name="countdown_tag" class="form-control"
                                            value="{{ $setting->countdown_tag ?? '🕒 Countdown to Excellence' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Judul Utama (Putih)</label>
                                        <input type="text" name="countdown_title" class="form-control"
                                            value="{{ $setting->countdown_title ?? 'Save the' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Judul Highlight (Gradasi)</label>
                                        <input type="text" name="countdown_subtitle" class="form-control"
                                            value="{{ $setting->countdown_subtitle ?? 'Date' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Process step 1 -->
                            <div class="col-md-12 p-3 bg-light rounded-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-2 mb-3 text-primary">Langkah 01</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Judul Langkah 1</label>
                                        <input type="text" name="process_title1" class="form-control"
                                            value="{{ $setting->process_title1 ?? 'Pendaftaran' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Ikon Langkah 1 (Bootstrap Icon Class)</label>
                                        <input type="text" name="process_icon1" class="form-control"
                                            value="{{ $setting->process_icon1 ?? 'bi-pencil-square' }}">
                                        <div class="form-text mt-1">Contoh: <code>bi-pencil-square</code>,
                                            <code>bi-trophy</code>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small">Deskripsi Langkah 1</label>
                                        <textarea name="process_desc1" class="form-control"
                                            rows="2">{{ $setting->process_desc1 ?? 'Daftarkan diri atau tim Anda secara online melalui form yang disediakan.' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Process step 2 -->
                            <div class="col-md-12 p-3 bg-light rounded-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-2 mb-3 text-primary">Langkah 02</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Judul Langkah 2</label>
                                        <input type="text" name="process_title2" class="form-control"
                                            value="{{ $setting->process_title2 ?? 'Daftar Ulang' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Ikon Langkah 2</label>
                                        <input type="text" name="process_icon2" class="form-control"
                                            value="{{ $setting->process_icon2 ?? 'bi-check2-all' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small">Deskripsi Langkah 2</label>
                                        <textarea name="process_desc2" class="form-control"
                                            rows="2">{{ $setting->process_desc2 ?? 'Konfirmasi kehadiran dan verifikasi berkas administrative di lokasi.' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Process step 3 -->
                            <div class="col-md-12 p-3 bg-light rounded-3 mb-2">
                                <h6 class="fw-bold border-bottom pb-2 mb-3 text-primary">Langkah 03</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Judul Langkah 3</label>
                                        <input type="text" name="process_title3" class="form-control"
                                            value="{{ $setting->process_title3 ?? 'Pelaksanaan Lomba' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small">Ikon Langkah 3</label>
                                        <input type="text" name="process_icon3" class="form-control"
                                            value="{{ $setting->process_icon3 ?? 'bi-trophy' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small">Deskripsi Langkah 3</label>
                                        <textarea name="process_desc3" class="form-control"
                                            rows="2">{{ $setting->process_desc3 ?? 'Waktunya menunjukkan kemampuan terbaik Anda dalam kompetisi.' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Teks ini muncul di bagian "Save the Date" pada halaman depan. Ikon menggunakan class dari <a
                                href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>.
                        </div>

                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow">
                                    <i class="bi bi-save me-2"></i> Simpan Process Flow
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        .dark-mode .bg-light {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }
    </style>
@endsection