@extends('layouts.admin.layout')
@section('title', 'Kustomisasi Teks Pendaftaran')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h1 class="h5 fw-bold mb-4">
                            <i class="bi bi-pencil-square text-primary me-2"></i>Kustomisasi Teks Halaman Pendaftaran
                        </h1>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-5">
                                <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Informasi Kiri (Promo)</h2>
                                <div class="mb-3">
                                    <label for="reg_tag" class="form-label small">Reg Tag (Badge)</label>
                                    <input type="text" id="reg_tag" name="reg_tag" class="form-control" aria-label="Reg Tag (Badge)"
                                        value="{{ $setting->reg_tag ?? 'REGISTRATION OPEN' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="reg_title" class="form-label small">Reg Title (Judul Besar)</label>
                                    <input type="text" id="reg_title" name="reg_title" class="form-control" aria-label="Reg Title (Judul Besar)"
                                        value="{{ $setting->reg_title ?? 'Begin Your Journey With Us.' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="reg_subtitle" class="form-label small">Reg Subtitle (Penjelasan)</label>
                                    <textarea id="reg_subtitle" name="reg_subtitle" class="form-control" aria-label="Reg Subtitle (Penjelasan)"
                                        rows="3">{{ $setting->reg_subtitle ?? 'Secure your place at the premier event of the season. Join industry leaders and visionaries in a day of innovation.' }}</textarea>
                                </div>

                                <div class="mt-4">
                                    <label for="reg_feature_1" class="form-label small fw-bold">Poin Keunggulan (Features)</label>
                                    <div class="mb-2">
                                        <input type="text" id="reg_feature_1" name="reg_feature_1" class="form-control" aria-label="Poin Keunggulan 1"
                                            value="{{ $setting->reg_feature_1 ?? 'Secure and fast verification process.' }}"
                                            placeholder="Fitur 1">
                                    </div>
                                    <div class="mb-2">
                                        <label for="reg_feature_2" class="visually-hidden">Poin Keunggulan 2</label>
                                        <input type="text" id="reg_feature_2" name="reg_feature_2" class="form-control" aria-label="Poin Keunggulan 2"
                                            value="{{ $setting->reg_feature_2 ?? 'Instant confirmation via email.' }}"
                                            placeholder="Fitur 2">
                                    </div>
                                    <div>
                                        <label for="reg_feature_3" class="visually-hidden">Poin Keunggulan 3</label>
                                        <input type="text" id="reg_feature_3" name="reg_feature_3" class="form-control" aria-label="Poin Keunggulan 3"
                                            value="{{ $setting->reg_feature_3 ?? '24/7 Priority support for attendees.' }}"
                                            placeholder="Fitur 3">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="ps-md-4 border-start">
                                    <h2 class="h6 fw-bold border-bottom pb-2 mb-3">Teks Formulir (Kanan)</h2>
                                    <div class="mb-3">
                                        <label for="reg_form_title" class="form-label small">Judul Form</label>
                                        <input type="text" id="reg_form_title" name="reg_form_title" class="form-control" aria-label="Judul Form"
                                            value="{{ $setting->reg_form_title ?? 'Registration Form' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="reg_form_subtitle" class="form-label small">Subtitle Form (Penjelasan di bawah judul)</label>
                                        <input type="text" id="reg_form_subtitle" name="reg_form_subtitle" class="form-control" aria-label="Subtitle Form (Penjelasan di bawah judul)"
                                            value="{{ $setting->reg_form_subtitle ?? 'Fill in your details to get started' }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_tm_picker" class="form-label small fw-bold text-danger">Batas Waktu Pendaftaran (Tanggal TM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-calendar-event text-danger"></i>
                                            </span>
                                            <input type="text" name="tanggal_tm" id="tanggal_tm_picker" class="form-control border-start-0" aria-label="Batas Waktu Pendaftaran (Tanggal TM)"
                                                value="{{ $setting && $setting->tanggal_tm ? \Carbon\Carbon::parse($setting->tanggal_tm)->format('Y-m-d H:i') : '' }}"
                                                placeholder="Pilih Tanggal dan Waktu...">
                                        </div>
                                        <small class="text-muted">Pendaftaran akan otomatis ditutup setelah waktu ini. Gunakan pemilih tanggal di atas.</small>
                                    </div>

                                    <!-- Flatpickr CSS -->
                                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
                                    <style>
                                        .flatpickr-calendar {
                                            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
                                            border: 1px solid rgba(0,0,0,0.05) !important;
                                            border-radius: 12px !important;
                                        }
                                        .dark-mode .flatpickr-calendar {
                                            background: #1e1e22 !important;
                                            border-color: rgba(255,255,255,0.1) !important;
                                            color: white !important;
                                        }
                                        .dark-mode .flatpickr-day { color: #e2e8f0 !important; }
                                        .dark-mode .flatpickr-months .flatpickr-month,
                                        .dark-mode .flatpickr-weekday {
                                            color: #e2e8f0 !important;
                                            fill: #e2e8f0 !important;
                                        }
                                        .dark-mode .flatpickr-current-month .flatpickr-monthDropdown-months {
                                            background: #1e1e22 !important;
                                        }
                                        .dark-mode .numInputWrapper span.arrowUp:after { border-bottom-color: #94a3b8 !important; }
                                        .dark-mode .numInputWrapper span.arrowDown:after { border-top-color: #94a3b8 !important; }
                                    </style>

                                    <!-- Flatpickr JS -->
                                    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            flatpickr("#tanggal_tm_picker", {
                                                enableTime: true,
                                                dateFormat: "Y-m-d H:i",
                                                time_24hr: true,
                                                allowInput: true,
                                                minDate: "today",
                                                monthSelectorType: 'static'
                                            });
                                        });
                                    </script>

                                    <div class="alert alert-info mt-4">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Bidang input pendaftaran (seperti Nama, Email, dll) dikelola melalui pengaturan
                                        database sistem. Di sini Anda hanya mengubah narasi pemasarannya.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow">
                                    <i class="bi bi-save me-2"></i> Simpan Teks Pendaftaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection