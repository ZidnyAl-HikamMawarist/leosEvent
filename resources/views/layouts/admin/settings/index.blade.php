@extends('layouts.admin.layout')
@section('title', 'Pengaturan Website')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
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

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Event</label>
                            <input type="text" name="nama_event" class="form-control"
                                value="{{ $setting->nama_event ?? '' }}" placeholder="Contoh: LEOS EVENT 2024">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi Event (About)</label>
                            <textarea name="deskripsi_event" class="form-control" rows="4"
                                placeholder="Jelaskan tentang event ini...">{{ $setting->deskripsi_event ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto About</label>
                            @if($setting && $setting->about_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $setting->about_image) }}"
                                        class="rounded shadow-sm img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="about_image" class="form-control">
                            <small class="text-muted">Rekomendasi: 600x800px (aspek potret)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link Pendaftaran (Opsional)</label>
                            <input type="text" name="link_pendaftaran" class="form-control"
                                value="{{ $setting->link_pendaftaran ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kontak (WhatsApp/Email)</label>
                            <input type="text" name="kontak" class="form-control" value="{{ $setting->kontak ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Footer Text</label>
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

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-clock-history text-primary me-2"></i>Save The Date & Waktu Event
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Waktu Mulai Event (24 Jam / WIB)</label>
                                <input type="text" name="event_start" class="form-control"
                                    value="{{ $setting && $setting->event_start ? \Carbon\Carbon::parse($setting->event_start)->format('Y-m-d H:i') : '' }}"
                                    placeholder="YYYY-MM-DD HH:mm (Contoh: 2024-08-17 08:00)"
                                    pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}"
                                    title="Format: YYYY-MM-DD HH:mm (Contoh: 2024-08-17 08:00)">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Waktu Selesai Event (24 Jam / WIB)</label>
                                <input type="text" name="event_end" class="form-control"
                                    value="{{ $setting && $setting->event_end ? \Carbon\Carbon::parse($setting->event_end)->format('Y-m-d H:i') : '' }}"
                                    placeholder="YYYY-MM-DD HH:mm (Contoh: 2024-08-17 17:00)"
                                    pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}"
                                    title="Format: YYYY-MM-DD HH:mm (Contoh: 2024-08-17 17:00)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status Event</label>
                            <select name="event_status" class="form-select">
                                <option value="upcoming" {{ ($setting->event_status ?? '') == 'upcoming' ? 'selected' : '' }}>
                                    Upcoming (Tampil Countdown)</option>
                                <option value="ongoing" {{ ($setting->event_status ?? '') == 'ongoing' ? 'selected' : '' }}>
                                    Ongoing (Sedang Berlangsung)</option>
                                <option value="finished" {{ ($setting->event_status ?? '') == 'finished' ? 'selected' : '' }}>
                                    Finished (Countdown Hilang)</option>
                            </select>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_save_the_date_active"
                                id="is_save_the_date_active" {{ ($setting->is_save_the_date_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_save_the_date_active">Aktifkan Save The Date
                                Section</label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="auto_update_status"
                                id="auto_update_status" {{ ($setting->auto_update_status ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="auto_update_status">Update Status Otomatis
                                Berdasarkan Waktu</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-palette text-primary me-2"></i>Branding & Tema
                        </h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Background Website</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="small text-muted mb-1">Warna Background Utama</label>
                                    <input type="color" name="background_color"
                                        class="form-control form-control-color w-100"
                                        value="{{ $setting->background_color ?? '#0f0908' }}"
                                        title="Pilih warna background utama" style="height: 50px;">
                                </div>
                                <div class="col-md-8">
                                    <label class="small text-muted mb-1">Gambar Background (Opsional)</label>
                                    @if($setting && $setting->background_image)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $setting->background_image) }}"
                                                class="rounded shadow-sm img-thumbnail" style="max-height: 80px;">
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="delete_background_image"
                                                    id="delBg">
                                                <label class="form-check-label text-danger small" for="delBg">Hapus Gambar
                                                    Background</label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="background_image" class="form-control">
                                    <small class="text-muted d-block mt-1">Jika diisi, akan menimpa warna
                                        background.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-4">
                                <label class="form-label fw-semibold small">Warna Primer</label>
                                <input type="color" name="primary_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->primary_color ?? '#712f23' }}" title="Pilih warna primer"
                                    style="height: 50px;">
                                <label class="form-label fw-semibold small mt-2">Teks di Primer</label>
                                <input type="color" name="text_primary_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->text_primary_color ?? '#ffffff' }}"
                                    title="Warna teks pada background primer">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold small">Warna Sekunder</label>
                                <input type="color" name="secondary_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->secondary_color ?? '#c5a353' }}" title="Pilih warna sekunder"
                                    style="height: 50px;">
                                <label class="form-label fw-semibold small mt-2">Teks di Sekunder</label>
                                <input type="color" name="text_secondary_color"
                                    class="form-control form-control-color w-100"
                                    value="{{ $setting->text_secondary_color ?? '#ffffff' }}"
                                    title="Warna teks pada background sekunder">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold small">Warna Aksen</label>
                                <input type="color" name="accent_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->accent_color ?? '#d4af37' }}" title="Pilih warna aksen"
                                    style="height: 50px;">
                                <label class="form-label fw-semibold small mt-2">Warna Teks Utama</label>
                                <input type="color" name="body_text_color" class="form-control form-control-color w-100"
                                    value="{{ $setting->body_text_color ?? '#fdf6f0' }}" title="Warna teks utama website">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Google Font URL</label>
                            <input type="text" name="font_family_url" class="form-control"
                                value="{{ $setting->font_family_url ?? 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap' }}"
                                placeholder="Masukkan URL Google Fonts">
                            <small class="text-muted">Tempel link "Standard" dari Google Fonts.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Template Tema</label>
                            <select name="theme_slug" class="form-select">
                                <option value="default" {{ ($setting->theme_slug ?? 'default') == 'default' ? 'selected' : '' }}>
                                    Default Premium</option>
                                <option value="modern" {{ ($setting->theme_slug ?? '') == 'modern' ? 'selected' : '' }}>Modern
                                    Clean</option>
                            </select>
                            <small class="text-muted">Pilih layout dasar yang ingin digunakan.</small>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-image text-primary me-2"></i>Elemen Visual & Navbar
                        </h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Logo Website (Pojok Kiri Atas)</label>
                            @if($setting && $setting->logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $setting->logo) }}" class="rounded shadow-sm img-thumbnail"
                                        style="max-height: 80px;">
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control">
                            <small class="text-muted">Format: PNG transparan disarankan.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Elemen Dinamis Navbar (Teks)</label>
                            <input type="text" name="navbar_element" class="form-control"
                                value="{{ $setting->navbar_element ?? '' }}" placeholder="Contoh: Info Penting / Promo">
                            <small class="text-muted">Akan muncul di area menu navbar.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Atas (Dekat Navbar)</label>
                            @if($setting && $setting->top_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $setting->top_image) }}"
                                        class="rounded shadow-sm img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="top_image" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gambar Samping Kiri (Atas)</label>
                                @if($setting && $setting->side_image_left)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $setting->side_image_left) }}"
                                            class="rounded shadow-sm img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="side_image_left" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gambar Samping Kanan (Atas)</label>
                                @if($setting && $setting->side_image_right)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $setting->side_image_right) }}"
                                            class="rounded shadow-sm img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="side_image_right" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gambar Samping Kiri (Bawah)</label>
                                @if($setting && $setting->side_image_left_bottom)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $setting->side_image_left_bottom) }}"
                                            class="rounded shadow-sm img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="side_image_left_bottom" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gambar Samping Kanan (Bawah)</label>
                                @if($setting && $setting->side_image_right_bottom)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $setting->side_image_right_bottom) }}"
                                            class="rounded shadow-sm img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="side_image_right_bottom" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Footer</label>
                            @if($setting && $setting->footer_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $setting->footer_image) }}"
                                        class="rounded shadow-sm img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="footer_image" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-lg w-100 py-3">
                    <i class="bi bi-save me-2"></i> Simpan Semua Pengaturan
                </button>
            </div>
        </div>
    </form>
@endsection