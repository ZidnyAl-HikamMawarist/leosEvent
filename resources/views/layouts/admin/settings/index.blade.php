@extends('layouts.admin.layout')
@section('title', 'Pengaturan Website')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Pengaturan Website</h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Event</label>
                        <input type="text" name="nama_event" class="form-control" value="{{ $setting->nama_event ?? '' }}"
                            placeholder="Contoh: LEOS EVENT 2024">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi Event (About)</label>
                        <textarea name="deskripsi_event" class="form-control" rows="4"
                            placeholder="Jelaskan tentang event ini...">{{ $setting->deskripsi_event ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto About</label>
                        @if($setting && $setting->about_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->about_image) }}" class="rounded shadow-sm"
                                    style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" name="about_image" class="form-control">
                        <small class="text-muted">Rekomendasi ukuran: 600x800px atau aspek rasio potret.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Pendaftaran (Opsional)</label>
                        <input type="text" name="link_pendaftaran" class="form-control"
                            value="{{ $setting->link_pendaftaran ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kontak (WhatsApp/Email)</label>
                        <input type="text" name="kontak" class="form-control" value="{{ $setting->kontak ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Footer Text</label>
                        <input type="text" name="footer_text" class="form-control" value="{{ $setting->footer_text ?? '' }}"
                            placeholder="© 2024 Leos Event. All rights reserved.">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Pendaftaran</label>
                        <select name="status_pendaftaran" class="form-select">
                            <option value="buka" {{ ($setting->status_pendaftaran ?? '') == 'buka' ? 'selected' : '' }}>
                                Buka
                            </option>
                            <option value="tutup" {{ ($setting->status_pendaftaran ?? '') == 'tutup' ? 'selected' : '' }}>
                                Tutup
                            </option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100 py-2">
                        <i class="bi bi-save me-1"></i> Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection