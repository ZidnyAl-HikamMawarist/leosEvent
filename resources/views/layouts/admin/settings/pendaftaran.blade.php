@extends('layouts.admin.layout')
@section('title', 'Kustomisasi Teks Pendaftaran')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4 justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-pencil-square text-primary me-2"></i>Kustomisasi Teks Halaman Pendaftaran
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-5">
                                <h6 class="fw-bold border-bottom pb-2 mb-3">Informasi Kiri (Promo)</h6>
                                <div class="mb-3">
                                    <label class="form-label small">Reg Tag (Badge)</label>
                                    <input type="text" name="reg_tag" class="form-control"
                                        value="{{ $setting->reg_tag ?? 'REGISTRATION OPEN' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Reg Title (Judul Besar)</label>
                                    <input type="text" name="reg_title" class="form-control"
                                        value="{{ $setting->reg_title ?? 'Begin Your Journey With Us.' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Reg Subtitle (Penjelasan)</label>
                                    <textarea name="reg_subtitle" class="form-control"
                                        rows="3">{{ $setting->reg_subtitle ?? 'Secure your place at the premier event of the season. Join industry leaders and visionaries in a day of innovation.' }}</textarea>
                                </div>

                                <div class="mt-4">
                                    <label class="form-label small fw-bold">Poin Keunggulan (Features)</label>
                                    <input type="text" name="reg_feature_1" class="form-control mb-2"
                                        value="{{ $setting->reg_feature_1 ?? 'Secure and fast verification process.' }}"
                                        placeholder="Fitur 1">
                                    <input type="text" name="reg_feature_2" class="form-control mb-2"
                                        value="{{ $setting->reg_feature_2 ?? 'Instant confirmation via email.' }}"
                                        placeholder="Fitur 2">
                                    <input type="text" name="reg_feature_3" class="form-control"
                                        value="{{ $setting->reg_feature_3 ?? '24/7 Priority support for attendees.' }}"
                                        placeholder="Fitur 3">
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="ps-md-4 border-start">
                                    <h6 class="fw-bold border-bottom pb-2 mb-3">Teks Formulir (Kanan)</h6>
                                    <div class="mb-3">
                                        <label class="form-label small">Judul Form</label>
                                        <input type="text" name="reg_form_title" class="form-control"
                                            value="{{ $setting->reg_form_title ?? 'Registration Form' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Subtitle Form (Penjelasan di bawah judul)</label>
                                        <input type="text" name="reg_form_subtitle" class="form-control"
                                            value="{{ $setting->reg_form_subtitle ?? 'Fill in your details to get started' }}">
                                    </div>

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