@extends('layouts.admin.layout')
@section('title', 'Kustomisasi Teks About')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4 justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-info-circle text-primary me-2"></i>Kustomisasi Teks Bagian "About"
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-4 pt-2">
                            <h6 class="fw-bold border-bottom pb-2 mb-3">Teks Utama</h6>
                            <div class="mb-3">
                                <label class="form-label small">About Tag (Teks kecil di atas judul)</label>
                                <input type="text" name="about_tag" class="form-control"
                                    value="{{ $setting->about_tag ?? '✨ Discover Our Mission' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">About Title (Judul Besar)</label>
                                <input type="text" name="about_title" class="form-control"
                                    value="{{ $setting->about_title ?? 'Experience the Evolution of Professional Growth' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Deskripsi Event Utama</label>
                                <textarea name="deskripsi_event" class="form-control" rows="5"
                                    placeholder="Jelaskan tentang event ini...">{{ $setting->deskripsi_event ?? '' }}</textarea>
                                <small class="text-muted">Teks ini muncul di samping foto About.</small>
                            </div>
                        </div>

                        <div class="mb-4 pt-2">
                            <h6 class="fw-bold border-bottom pb-2 mb-3">Kartu Informasi Melayang</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Label Pengalaman (Angka/Judul)</label>
                                    <input type="text" name="about_experience_label" class="form-control"
                                        value="{{ $setting->about_experience_label ?? 'Live Experiences' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Sub-label (Penjelasan kecil)</label>
                                    <input type="text" name="about_experience_sublabel" class="form-control"
                                        value="{{ $setting->about_experience_sublabel ?? 'Physical & Virtual Access' }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Utama About</label>
                            @if($setting && $setting->about_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $setting->about_image) }}"
                                        class="rounded shadow-sm img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="about_image" class="form-control">
                            <small class="text-muted">Rekomendasi: 600x800px (format potret).</small>
                        </div>

                        <div class="mb-4 pt-4 border-top">
                            <h6 class="fw-bold pb-2 mb-3">About Features (4 Kotak Bawah)</h6>
                            <div class="row bg-light rounded-3 p-3 mx-1 mb-3">
                                <h6 class="fw-semibold text-primary mb-3">Feature 1</h6>
                                <div class="col-md-4 mb-2">
                                    <label class="small">Judul</label>
                                    <input type="text" name="about_feature1_title" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature1_title ?? 'Global Speakers' }}">
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label class="small">Deskripsi</label>
                                    <input type="text" name="about_feature1_desc" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature1_desc ?? 'Learn from world-class industry pioneers.' }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="small">Ikon</label>
                                    <input type="text" name="about_feature1_icon" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature1_icon ?? 'bi-person-badge' }}">
                                </div>
                            </div>
                            <div class="row bg-light rounded-3 p-3 mx-1 mb-3">
                                <h6 class="fw-semibold text-primary mb-3">Feature 2</h6>
                                <div class="col-md-4 mb-2">
                                    <label class="small">Judul</label>
                                    <input type="text" name="about_feature2_title" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature2_title ?? 'Elite Networking' }}">
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label class="small">Deskripsi</label>
                                    <input type="text" name="about_feature2_desc" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature2_desc ?? 'Connect with influential professionals.' }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="small">Ikon</label>
                                    <input type="text" name="about_feature2_icon" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature2_icon ?? 'bi-people' }}">
                                </div>
                            </div>
                            <div class="row bg-light rounded-3 p-3 mx-1 mb-3">
                                <h6 class="fw-semibold text-primary mb-3">Feature 3</h6>
                                <div class="col-md-4 mb-2">
                                    <label class="small">Judul</label>
                                    <input type="text" name="about_feature3_title" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature3_title ?? 'Modern Workshops' }}">
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label class="small">Deskripsi</label>
                                    <input type="text" name="about_feature3_desc" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature3_desc ?? 'Hands-on learning with latest tools.' }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="small">Ikon</label>
                                    <input type="text" name="about_feature3_icon" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature3_icon ?? 'bi-cpu' }}">
                                </div>
                            </div>
                            <div class="row bg-light rounded-3 p-3 mx-1 mb-3">
                                <h6 class="fw-semibold text-primary mb-3">Feature 4</h6>
                                <div class="col-md-4 mb-2">
                                    <label class="small">Judul</label>
                                    <input type="text" name="about_feature4_title" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature4_title ?? 'Verified Certificate' }}">
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label class="small">Deskripsi</label>
                                    <input type="text" name="about_feature4_desc" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature4_desc ?? 'Boost your professional portfolio.' }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="small">Ikon</label>
                                    <input type="text" name="about_feature4_icon" class="form-control form-control-sm"
                                        value="{{ $setting->about_feature4_icon ?? 'bi-patch-check' }}">
                                </div>
                            </div>

                            <h6 class="fw-bold border-bottom mt-4 pb-2 mb-3">Tombol Aksi Bawah</h6>
                            <div class="mb-3">
                                <label class="form-label small">Teks Tombol (Start Your Journey)</label>
                                <input type="text" name="about_btn_text" class="form-control"
                                    value="{{ $setting->about_btn_text ?? 'Start Your Journey' }}">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow">
                                    <i class="bi bi-save me-2"></i> Simpan Teks About
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection