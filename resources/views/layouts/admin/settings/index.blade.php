@extends('layouts.admin.layout')
@section('title', 'Pengaturan Umum & Tema')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="has_switches" value="1">

        <div class="row g-4">
            <div class="col-md-6">
                <!-- Website Info -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-gear text-primary me-2"></i>Pengaturan Website
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Event</label>
                            <input type="text" name="nama_event" class="form-control"
                                value="{{ $setting->nama_event ?? '' }}" placeholder="Contoh: LEOS EVENT 2024">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi Singkat (Footer)</label>
                            <textarea name="footer_description" class="form-control"
                                rows="3">{{ $setting->footer_description ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kontak (WhatsApp/Email)</label>
                            <input type="text" name="kontak" class="form-control" value="{{ $setting->kontak ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link Instagram Footer</label>
                            <input type="text" name="footer_ig_link" class="form-control"
                                value="{{ $setting->footer_ig_link ?? '' }}" placeholder="https://instagram.com/...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link Sematan Google Maps Footer</label>
                            <textarea name="footer_map_link" class="form-control" rows="3"
                                placeholder="Masukkan URL src peta di sini...">{{ $setting->footer_map_link ?? '' }}</textarea>
                            <small class="text-muted">Cari di Google Maps -> Bagikan -> Sematkan Peta -> Copy isi atribut
                                src="..." </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Footer Text (Copyright)</label>
                            <input type="text" name="footer_text" class="form-control"
                                value="{{ $setting->footer_text ?? '' }}"
                                placeholder="© 2024 Leos Event. All rights reserved.">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status Pendaftaran</label>
                            <select name="status_pendaftaran" class="form-select">
                                <option value="buka" {{ ($setting->status_pendaftaran ?? '') == 'buka' ? 'selected' : '' }}>
                                    Buka
                                </option>
                                <option value="tutup" {{ ($setting->status_pendaftaran ?? '') == 'tutup' ? 'selected' : '' }}>
                                    Tutup
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Timing Section -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-clock-history text-primary me-2"></i>Save The Date & Waktu Event
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Waktu Mulai Event</label>
                                <input type="text" name="event_start" class="form-control"
                                    value="{{ $setting && $setting->event_start ? \Carbon\Carbon::parse($setting->event_start)->format('Y-m-d H:i') : '' }}"
                                    placeholder="YYYY-MM-DD HH:mm">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Waktu Selesai Event</label>
                                <input type="text" name="event_end" class="form-control"
                                    value="{{ $setting && $setting->event_end ? \Carbon\Carbon::parse($setting->event_end)->format('Y-m-d H:i') : '' }}"
                                    placeholder="YYYY-MM-DD HH:mm">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status Event</label>
                            <select name="event_status" class="form-select">
                                <option value="upcoming" {{ ($setting->event_status ?? '') == 'upcoming' ? 'selected' : '' }}>
                                    Upcoming</option>
                                <option value="ongoing" {{ ($setting->event_status ?? '') == 'ongoing' ? 'selected' : '' }}>
                                    Ongoing</option>
                                <option value="finished" {{ ($setting->event_status ?? '') == 'finished' ? 'selected' : '' }}>
                                    Finished</option>
                            </select>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_save_the_date_active"
                                id="is_save_the_date_active" {{ ($setting->is_save_the_date_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_save_the_date_active">Aktifkan Section Save
                                The Date</label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="auto_update_status"
                                id="auto_update_status" {{ ($setting->auto_update_status ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="auto_update_status">Update Status
                                Otomatis</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Branding & Theme -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-palette text-primary me-2"></i>Branding & Tema
                        </h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Background Website</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="small text-muted mb-1">Warna</label>
                                    <input type="color" name="background_color"
                                        class="form-control form-control-color w-100"
                                        value="{{ $setting->background_color ?? '#0f0908' }}" style="height: 50px;">
                                </div>
                                <div class="col-md-8">
                                    <label class="small text-muted mb-1">Gambar Background</label>
                                    <input type="file" name="background_image" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-4">
                                <label class="form-label fw-semibold small">Primer</label>
                                <input type="color" name="primary_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->primary_color ?? '#712f23' }}" style="height: 40px;">
                                <input type="color" name="text_primary_color"
                                    class="form-control form-control-color w-100 mt-1"
                                    value="{{ $setting->text_primary_color ?? '#ffffff' }}" title="Warna teks di primer">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold small">Sekunder</label>
                                <input type="color" name="secondary_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->secondary_color ?? '#c5a353' }}" style="height: 40px;">
                                <input type="color" name="text_secondary_color"
                                    class="form-control form-control-color w-100 mt-1"
                                    value="{{ $setting->text_secondary_color ?? '#ffffff' }}"
                                    title="Warna teks di sekunder">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold small">Aksen</label>
                                <input type="color" name="accent_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->accent_color ?? '#d4af37' }}" style="height: 40px;">
                                <input type="color" name="body_text_color"
                                    class="form-control form-control-color w-100 mt-1"
                                    value="{{ $setting->body_text_color ?? '#fdf6f0' }}" title="Warna teks utama">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Google Font URL</label>
                            <input type="text" name="font_family_url" class="form-control"
                                value="{{ $setting->font_family_url ?? '' }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Template Tema</label>
                            <select name="theme_slug" class="form-select">
                                <option value="default" {{ ($setting->theme_slug ?? 'default') == 'default' ? 'selected' : '' }}>Default Premium</option>
                                <option value="modern" {{ ($setting->theme_slug ?? '') == 'modern' ? 'selected' : '' }}>Modern
                                    Clean</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Visual Elements -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-image text-primary me-2"></i>Elemen Visual & Navbar
                        </h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Logo Website</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Teks Dinamis Navbar</label>
                            <input type="text" name="navbar_element" class="form-control"
                                value="{{ $setting->navbar_element ?? '' }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small">Gambar Atas</label>
                                <input type="file" name="top_image" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small">Gambar Footer</label>
                                <input type="file" name="footer_image" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold small">Side Left (Atas)</label>
                                <input type="file" name="side_image_left" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold small">Side Right (Atas)</label>
                                <input type="file" name="side_image_right" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold small">Side Left (Bawah)</label>
                                <input type="file" name="side_image_left_bottom" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold small">Side Right (Bawah)</label>
                                <input type="file" name="side_image_right_bottom" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow">
                    <i class="bi bi-save me-2"></i> Simpan Pengaturan Umum
                </button>
            </div>
        </div>
    </form>
@endsection