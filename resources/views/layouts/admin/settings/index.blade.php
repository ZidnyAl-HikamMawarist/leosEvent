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
                        <h1 class="h5 fw-bold mb-4">
                            <i class="bi bi-gear text-primary me-2"></i>Pengaturan Website
                        </h1>

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

                        @if(auth()->user()->isSuperAdmin())
                            <div class="border-top pt-3 mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_maintenance"
                                        id="is_maintenance" {{ ($setting->is_maintenance ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-danger" for="is_maintenance">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> AKTIFKAN MAINTENANCE MODE
                                    </label>
                                </div>
                <!-- Visual Elements -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-image text-primary me-2"></i>Elemen Visual & Navbar
                        </h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Logo Event</label>
                                <input type="file" name="logo" class="form-control">
                                @if($setting && $setting->logo)
                                    <div class="mt-2 p-2 bg-light rounded d-inline-block border">
                                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo Event" class="rounded"
                                            style="max-height: 45px;">
                                        <small class="text-muted d-block mt-1" style="font-size: 11px;">Logo event saat ini</small>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Logo Sekolah (Footer)</label>
                                <input type="file" name="school_logo" class="form-control">
                                @if($setting && $setting->school_logo)
                                    <div class="mt-2 p-2 bg-light rounded d-inline-block border">
                                        <img src="{{ asset('storage/' . $setting->school_logo) }}" alt="Logo Sekolah"
                                            class="rounded" style="max-height: 45px;">
                                        <small class="text-muted d-block mt-1" style="font-size: 11px;">Logo sekolah saat ini</small>
                                    </div>
                                @endif
                                <small class="text-muted d-block mt-1" style="font-size: 11px;">Tampil di footer website.</small>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Sekolah</label>
                                <input type="text" name="nama_sekolah" class="form-control"
                                    value="{{ $setting->nama_sekolah ?? '' }}" placeholder="Contoh: SMKN 1 Ciamis">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Teks Penyelenggara</label>
                                <input type="text" name="organizer_text" class="form-control"
                                    value="{{ $setting->organizer_text ?? '' }}" placeholder="Contoh: Diselenggarakan di">
                                <small class="text-muted" style="font-size: 11px;">Teks sebelum nama sekolah di footer.</small>
                            </div>
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

@php
    $themePresets = [
        'royal-maroon' => [
            'name' => 'Royal Maroon & Gold',
            'desc' => 'Hangat, Mewah & Elegan (Default Resmi)',
            'badge' => 'Default Resmi',
            'badge_class' => 'bg-danger text-white',
            'bg' => '#0f0908',
            'primary' => '#712f23',
            'text_primary' => '#ffffff',
            'secondary' => '#c5a353',
            'text_secondary' => '#ffffff',
            'accent' => '#d4af37',
            'body_text' => '#fdf6f0',
        ],
        'midnight-navy' => [
            'name' => 'Midnight Navy & Sapphire',
            'desc' => 'Teknologi Modern, Bersih & Profesional',
            'badge' => 'Modern Tech',
            'badge_class' => 'bg-primary text-white',
            'bg' => '#070b14',
            'primary' => '#1d4ed8',
            'text_primary' => '#ffffff',
            'secondary' => '#38bdf8',
            'text_secondary' => '#0f172a',
            'accent' => '#60a5fa',
            'body_text' => '#f1f5f9',
        ],
        'emerald-forest' => [
            'name' => 'Emerald Forest & Mint',
            'desc' => 'Prestisius, Segar, Sejuk & Alami',
            'badge' => 'Fresh & Prestige',
            'badge_class' => 'bg-success text-white',
            'bg' => '#06120e',
            'primary' => '#047857',
            'text_primary' => '#ffffff',
            'secondary' => '#34d399',
            'text_secondary' => '#022c22',
            'accent' => '#10b981',
            'body_text' => '#f0fdf4',
        ],
        'cyber-violet' => [
            'name' => 'Cyberpunk Violet & Pink',
            'desc' => 'Futuristik, Dinamis, Kreatif & Berani',
            'badge' => 'Futuristic',
            'badge_class' => 'bg-info text-dark',
            'bg' => '#0d0814',
            'primary' => '#7c3aed',
            'text_primary' => '#ffffff',
            'secondary' => '#ec4899',
            'text_secondary' => '#ffffff',
            'accent' => '#a855f7',
            'body_text' => '#faf5ff',
        ],
        'sunset-amber' => [
            'name' => 'Sunset Amber & Flame',
            'desc' => 'Energik, Hangat, Semangat & Membara',
            'badge' => 'Warm Energy',
            'badge_class' => 'bg-warning text-dark',
            'bg' => '#140905',
            'primary' => '#c2410c',
            'text_primary' => '#ffffff',
            'secondary' => '#f59e0b',
            'text_secondary' => '#1c1917',
            'accent' => '#fb923c',
            'body_text' => '#fff7ed',
        ],
        'obsidian-silver' => [
            'name' => 'Obsidian & Platinum Silver',
            'desc' => 'Monokrom Eksklusif, Mewah & Minimalis',
            'badge' => 'Luxury Slate',
            'badge_class' => 'bg-secondary text-white',
            'bg' => '#0b0c10',
            'primary' => '#334155',
            'text_primary' => '#ffffff',
            'secondary' => '#94a3b8',
            'text_secondary' => '#0f172a',
            'accent' => '#cbd5e1',
            'body_text' => '#f8fafc',
        ],
        'crimson-ruby' => [
            'name' => 'Deep Crimson & Rose Ruby',
            'desc' => 'Kuat, Megah, Penuh Semangat & Memukau',
            'badge' => 'Bold Crimson',
            'badge_class' => 'bg-danger text-white',
            'bg' => '#120507',
            'primary' => '#991b1b',
            'text_primary' => '#ffffff',
            'secondary' => '#f43f5e',
            'text_secondary' => '#ffffff',
            'accent' => '#fb7185',
            'body_text' => '#fff1f2',
        ],
    ];

    $currentBg = strtolower($setting->background_color ?? '#0f0908');
    $currentPrimary = strtolower($setting->primary_color ?? '#712f23');
    $matchedSlug = 'custom';

    foreach ($themePresets as $slug => $preset) {
        if (strtolower($preset['bg']) === $currentBg && strtolower($preset['primary']) === $currentPrimary) {
            $matchedSlug = $slug;
            break;
        }
    }
@endphp

            <div class="col-md-6">
                <!-- Branding & Theme -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-palette text-primary me-2"></i>Template & Palet Warna
                            </h2>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill small fw-semibold">
                                7 Pilihan + 1 Kustom
                            </span>
                        </div>
                        <p class="text-muted small mb-4">
                            Pilih salah satu template siap pakai yang sudah dipadukan serasi antara warna background, tombol, aksen, dan teks. Anda tidak perlu menghafal kode hex warna.
                        </p>
                        <!-- Hidden input to save active theme slug -->
                        <input type="hidden" name="theme_slug" id="selected_theme_slug" value="{{ $setting->theme_slug ?? $matchedSlug }}">

                        <!-- 1. WARNA BACKGROUND (Diletakkan di Atas Template) -->
                        <div class="border rounded-3 p-3 bg-body mb-4 shadow-xs">
                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom flex-wrap gap-2">
                                <label class="form-label fw-bold small text-uppercase letter-spacing-1 text-dark mb-0">
                                    <i class="bi bi-paint-bucket text-primary me-1"></i>WARNA BACKGROUND
                                </label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="lockBgOnPreset" checked>
                                    <label class="form-check-label small text-muted" for="lockBgOnPreset" style="font-size: 11px;">Pertahankan background saat klik template</label>
                                </div>
                            </div>
                            
                            <div class="row g-2 pt-1">
                                <div class="col-md-5">
                                    <label for="color_background" class="small text-muted mb-1 d-block">Warna Solid</label>
                                    <div class="input-group input-group-sm">
                                        <input type="color" id="color_background" name="background_color"
                                            class="form-control form-control-color"
                                            value="{{ $setting->background_color ?? '#0f0908' }}" style="height: 38px; width: 45px;">
                                        <input type="text" id="hex_background" class="form-control font-monospace" value="{{ $setting->background_color ?? '#0f0908' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <label for="file_background_image" class="small text-muted mb-1 d-block">Foto / Gambar Background (Opsional)</label>
                                    <input type="file" id="file_background_image" name="background_image" class="form-control form-control-sm">
                                </div>
                            </div>

                            @if($setting && $setting->background_image)
                                <div class="alert alert-warning py-2 px-3 mt-2 mb-0 d-flex align-items-center justify-content-between small">
                                    <div>
                                        <i class="bi bi-image me-1"></i><strong>Gambar background aktif terpasang.</strong>
                                        <div class="text-muted" style="font-size: 11px;">Gambar menutupi warna solid di atas.</div>
                                    </div>
                                    <div class="form-check form-switch ms-2">
                                        <input class="form-check-input" type="checkbox" name="delete_background_image" id="delete_background_image" value="1">
                                        <label class="form-check-label text-danger fw-semibold small" for="delete_background_image">Hapus Gambar</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- 2. Template Presets Grid -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase letter-spacing-1 text-muted mb-2">
                                <i class="bi bi-stars text-warning me-1"></i>PILIH TEMPLATE TEMA
                            </label>
                            
                            <div class="row g-2" id="presetThemeContainer">
                                @foreach($themePresets as $slug => $preset)
                                    @php $isActive = ($matchedSlug === $slug); @endphp
                                    <div class="col-12">
                                        <div class="theme-preset-card p-3 rounded-3 border transition-all cursor-pointer {{ $isActive ? 'border-primary shadow-sm bg-primary-subtle bg-opacity-10' : 'border-secondary-subtle bg-body' }}"
                                             data-slug="{{ $slug }}"
                                             data-bg="{{ $preset['bg'] }}"
                                             data-primary="{{ $preset['primary'] }}"
                                             data-text-primary="{{ $preset['text_primary'] }}"
                                             data-secondary="{{ $preset['secondary'] }}"
                                             data-text-secondary="{{ $preset['text_secondary'] }}"
                                             data-accent="{{ $preset['accent'] }}"
                                             data-body-text="{{ $preset['body_text'] }}"
                                             style="cursor: pointer;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="preset-indicator rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; border: 2px solid {{ $isActive ? 'var(--primary, #712f23)' : '#cbd5e1' }};">
                                                        <span class="preset-dot rounded-circle {{ $isActive ? 'bg-primary' : 'bg-transparent' }}" style="width: 10px; height: 10px;"></span>
                                                    </span>
                                                    <div>
                                                        <div class="fw-bold small mb-0">{{ $preset['name'] }}</div>
                                                        <div class="text-muted" style="font-size: 11px;">{{ $preset['desc'] }}</div>
                                                    </div>
                                                </div>

                                                <!-- Mini Color Swatches -->
                                                <div class="d-flex align-items-center gap-1 ms-2">
                                                    <span class="rounded-circle border border-dark border-opacity-25" style="width: 20px; height: 20px; background-color: {{ $preset['bg'] }};" title="Background: {{ $preset['bg'] }}"></span>
                                                    <span class="rounded-circle shadow-sm" style="width: 20px; height: 20px; background-color: {{ $preset['primary'] }};" title="Tombol Utama: {{ $preset['primary'] }}"></span>
                                                    <span class="rounded-circle shadow-sm" style="width: 20px; height: 20px; background-color: {{ $preset['secondary'] }};" title="Sekunder: {{ $preset['secondary'] }}"></span>
                                                    <span class="rounded-circle shadow-sm" style="width: 20px; height: 20px; background-color: {{ $preset['accent'] }};" title="Aksen: {{ $preset['accent'] }}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Custom Preset Option -->
                                <div class="col-12">
                                    <div class="theme-preset-card p-3 rounded-3 border transition-all cursor-pointer {{ $matchedSlug === 'custom' ? 'border-primary shadow-sm bg-primary-subtle bg-opacity-10' : 'border-secondary-subtle bg-body' }}"
                                         data-slug="custom"
                                         style="cursor: pointer;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="preset-indicator rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; border: 2px solid {{ $matchedSlug === 'custom' ? 'var(--primary, #712f23)' : '#cbd5e1' }};">
                                                    <span class="preset-dot rounded-circle {{ $matchedSlug === 'custom' ? 'bg-primary' : 'bg-transparent' }}" style="width: 10px; height: 10px;"></span>
                                                </span>
                                                <div>
                                                    <div class="fw-bold small mb-0"><i class="bi bi-sliders2 me-1 text-primary"></i>Kustom Sendiri (Custom)</div>
                                                    <div class="text-muted" style="font-size: 11px;">Sesuaikan kombinasi warna tombol & teks manual di bawah</div>
                                                </div>
                                            </div>
                                            <span class="badge bg-secondary-subtle text-secondary small">Manual</span>
                                        </div>
                                    </div>

                                    <!-- Collapsible Manual Colors directly under Kustom Sendiri -->
                                    <div class="collapse mt-2 {{ $matchedSlug === 'custom' ? 'show' : '' }}" id="customColorsCollapse">
                                        <div class="border rounded-3 p-3 bg-body shadow-sm">
                                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                                <h6 class="fw-bold mb-0 small text-primary"><i class="bi bi-palette-fill me-1"></i>Atur Warna Tombol & Aksen Manual</h6>
                                                <small class="text-muted" style="font-size: 11px;">Klik kotak warna untuk mengganti</small>
                                            </div>

                                            <!-- Palette Colors 3 Columns -->
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    <label for="color_primary" class="form-label fw-semibold small mb-1">Primer (Tombol)</label>
                                                    <input type="color" id="color_primary" name="primary_color" class="form-control form-control-color w-100 mb-1"
                                                        value="{{ $setting->primary_color ?? '#712f23' }}" style="height: 35px;" title="Warna Tombol & Badge Utama">
                                                    <input type="color" id="color_text_primary" name="text_primary_color"
                                                        class="form-control form-control-color w-100"
                                                        value="{{ $setting->text_primary_color ?? '#ffffff' }}" style="height: 28px;" title="Warna Teks di Tombol Primer">
                                                    <small class="text-muted d-block mt-1" style="font-size: 10px;">Tombol & Teks</small>
                                                </div>
                                                <div class="col-4">
                                                    <label for="color_secondary" class="form-label fw-semibold small mb-1">Sekunder</label>
                                                    <input type="color" id="color_secondary" name="secondary_color" class="form-control form-control-color w-100 mb-1"
                                                        value="{{ $setting->secondary_color ?? '#c5a353' }}" style="height: 35px;" title="Warna Tombol Sekunder & Link">
                                                    <input type="color" id="color_text_secondary" name="text_secondary_color"
                                                        class="form-control form-control-color w-100"
                                                        value="{{ $setting->text_secondary_color ?? '#ffffff' }}" style="height: 28px;" title="Warna Teks di Tombol Sekunder">
                                                    <small class="text-muted d-block mt-1" style="font-size: 10px;">Sekunder & Teks</small>
                                                </div>
                                                <div class="col-4">
                                                    <label for="color_accent" class="form-label fw-semibold small mb-1">Aksen & Teks</label>
                                                    <input type="color" id="color_accent" name="accent_color" class="form-control form-control-color w-100 mb-1"
                                                        value="{{ $setting->accent_color ?? '#d4af37' }}" style="height: 35px;" title="Warna Aksen & Highlight">
                                                    <input type="color" id="color_body_text" name="body_text_color"
                                                        class="form-control form-control-color w-100"
                                                        value="{{ $setting->body_text_color ?? '#fdf6f0' }}" style="height: 28px;" title="Warna Teks Paragraf Website">
                                                    <small class="text-muted d-block mt-1" style="font-size: 10px;">Aksen & Teks Body</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Live Component Preview -->
                        <div class="mb-2">
                            <label class="form-label fw-bold small text-uppercase letter-spacing-1 text-muted mb-2">
                                <i class="bi bi-eye text-primary me-1"></i>PRATINJAU LANGSUNG KOMPONEN WEBSITE
                            </label>
                            <div id="themeLivePreviewBox" class="p-3 rounded-4 border position-relative overflow-hidden shadow-sm" style="transition: all 0.3s ease;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge rounded-pill" id="previewAccentBadge" style="font-size: 10px;">CONTOH BADGE EVENT</span>
                                    <small class="text-muted" style="font-size: 11px;"><i class="bi bi-display me-1"></i>Live Preview</small>
                                </div>
                                <h6 class="fw-bold mb-1" id="previewHeading" style="font-size: 14px;">Mulai Perjalanan Kompetisimu</h6>
                                <p class="mb-3" id="previewBodyText" style="font-size: 12px; line-height: 1.4;">
                                    Teks konten dan tombol akan tampil dengan kombinasi warna serasi ini di website pengunjung.
                                </p>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm px-3 py-1 fw-semibold shadow-sm" id="previewBtnPrimary" style="font-size: 12px;">
                                        <i class="bi bi-pencil-square me-1"></i>Daftar Lomba
                                    </button>
                                    <button type="button" class="btn btn-sm px-3 py-1 fw-semibold" id="previewBtnSecondary" style="font-size: 12px;">
                                        <i class="bi bi-info-circle me-1"></i>Panduan
                                    </button>
                                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const presetCards = document.querySelectorAll('.theme-preset-card');
            const themeSlugInput = document.getElementById('selected_theme_slug');

            const colorBg = document.getElementById('color_background');
            const hexBg = document.getElementById('hex_background');
            const colorPrimary = document.getElementById('color_primary');
            const colorTextPrimary = document.getElementById('color_text_primary');
            const colorSecondary = document.getElementById('color_secondary');
            const colorTextSecondary = document.getElementById('color_text_secondary');
            const colorAccent = document.getElementById('color_accent');
            const colorBodyText = document.getElementById('color_body_text');

            const previewBox = document.getElementById('themeLivePreviewBox');
            const previewAccentBadge = document.getElementById('previewAccentBadge');
            const previewHeading = document.getElementById('previewHeading');
            const previewBodyText = document.getElementById('previewBodyText');
            const previewBtnPrimary = document.getElementById('previewBtnPrimary');
            const previewBtnSecondary = document.getElementById('previewBtnSecondary');

            function getLuminance(hex) {
                if (!hex) return 0;
                hex = hex.replace('#', '');
                if (hex.length === 3) hex = hex.split('').map(c => c + c).join('');
                const r = parseInt(hex.substr(0, 2), 16) || 0;
                const g = parseInt(hex.substr(2, 2), 16) || 0;
                const b = parseInt(hex.substr(4, 2), 16) || 0;
                return (0.299 * r + 0.587 * g + 0.114 * b) / 255;
            }

            function updateLivePreview() {
                if (!previewBox) return;

                const bg = colorBg ? colorBg.value : '#0f0908';
                const isLight = getLuminance(bg) > 0.55;

                const primary = colorPrimary ? colorPrimary.value : '#712f23';
                const textPrimary = colorTextPrimary ? colorTextPrimary.value : '#ffffff';
                const secondary = colorSecondary ? colorSecondary.value : '#c5a353';
                const textSecondary = colorTextSecondary ? colorTextSecondary.value : '#ffffff';
                const accent = colorAccent ? colorAccent.value : '#d4af37';
                
                // Adaptive Body Text Color for Light vs Dark background
                let bodyText = colorBodyText ? colorBodyText.value : (isLight ? '#334155' : '#fdf6f0');
                if (isLight && (bodyText === '#fdf6f0' || bodyText === '#f1f5f9' || bodyText === '#ffffff' || getLuminance(bodyText) > 0.6)) {
                    bodyText = '#334155';
                    if (colorBodyText) colorBodyText.value = '#334155';
                } else if (!isLight && (bodyText === '#334155' || bodyText === '#1e293b' || bodyText === '#0f172a' || getLuminance(bodyText) < 0.4)) {
                    bodyText = '#fdf6f0';
                    if (colorBodyText) colorBodyText.value = '#fdf6f0';
                }

                if (hexBg) hexBg.value = bg.toUpperCase();

                // Apply styles to Live Preview Box
                previewBox.style.backgroundColor = bg;
                previewBox.style.borderColor = isLight ? 'rgba(0, 0, 0, 0.12)' : (accent + '40');
                previewBox.style.boxShadow = isLight ? '0 10px 30px rgba(0,0,0,0.06)' : 'none';
                
                if (previewAccentBadge) {
                    previewAccentBadge.style.backgroundColor = isLight ? (primary + '18') : (accent + '25');
                    previewAccentBadge.style.color = isLight ? primary : accent;
                    previewAccentBadge.style.border = '1px solid ' + (isLight ? (primary + '40') : (accent + '50'));
                }

                if (previewHeading) {
                    previewHeading.style.color = isLight ? '#0f172a' : accent;
                }

                if (previewBodyText) {
                    previewBodyText.style.color = bodyText;
                }

                if (previewBtnPrimary) {
                    previewBtnPrimary.style.backgroundColor = primary;
                    previewBtnPrimary.style.color = textPrimary;
                    previewBtnPrimary.style.borderColor = primary;
                }

                if (previewBtnSecondary) {
                    previewBtnSecondary.style.backgroundColor = secondary;
                    previewBtnSecondary.style.color = textSecondary;
                    previewBtnSecondary.style.borderColor = secondary;
                }
            }

            const customColorsCollapseElem = document.getElementById('customColorsCollapse');
            const customCollapseIcon = document.getElementById('customCollapseIcon');

            if (customColorsCollapseElem && customCollapseIcon) {
                customColorsCollapseElem.addEventListener('show.bs.collapse', function () {
                    customCollapseIcon.style.transform = 'rotate(180deg)';
                });
                customColorsCollapseElem.addEventListener('hide.bs.collapse', function () {
                    customCollapseIcon.style.transform = 'rotate(0deg)';
                });
                if (customColorsCollapseElem.classList.contains('show')) {
                    customCollapseIcon.style.transform = 'rotate(180deg)';
                }
            }

            const lockBgOnPreset = document.getElementById('lockBgOnPreset');

            function selectPreset(card, forceChangeBg = false) {
                const slug = card.getAttribute('data-slug');
                if (themeSlugInput) themeSlugInput.value = slug;

                if (slug !== 'custom') {
                    const keepBg = lockBgOnPreset ? lockBgOnPreset.checked : false;

                    // If keepBg is NOT checked or forceChangeBg is true, update the background to the preset's bg
                    if (!keepBg || forceChangeBg) {
                        if (colorBg) colorBg.value = card.getAttribute('data-bg');
                        if (hexBg) hexBg.value = card.getAttribute('data-bg').toUpperCase();
                    }

                    if (colorPrimary) colorPrimary.value = card.getAttribute('data-primary');
                    if (colorTextPrimary) colorTextPrimary.value = card.getAttribute('data-text-primary');
                    if (colorSecondary) colorSecondary.value = card.getAttribute('data-secondary');
                    if (colorTextSecondary) colorTextSecondary.value = card.getAttribute('data-text-secondary');
                    if (colorAccent) colorAccent.value = card.getAttribute('data-accent');
                    if (colorBodyText) colorBodyText.value = card.getAttribute('data-body-text');

                    // If user selects ready-made preset, collapse the manual details
                    if (customColorsCollapseElem && typeof bootstrap !== 'undefined') {
                        const bsCollapse = bootstrap.Collapse.getInstance(customColorsCollapseElem);
                        if (bsCollapse && customColorsCollapseElem.classList.contains('show')) {
                            bsCollapse.hide();
                        }
                    }
                } else {
                    // If user selects custom, auto-expand the manual details
                    if (customColorsCollapseElem && typeof bootstrap !== 'undefined') {
                        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(customColorsCollapseElem);
                        bsCollapse.show();
                    }
                }

                // Update active classes on cards
                presetCards.forEach(c => {
                    const isTarget = (c === card);
                    c.classList.toggle('border-primary', isTarget);
                    c.classList.toggle('shadow-sm', isTarget);
                    c.classList.toggle('bg-primary-subtle', isTarget);
                    c.classList.toggle('bg-opacity-10', isTarget);
                    c.classList.toggle('border-secondary-subtle', !isTarget);
                    
                    const indicator = c.querySelector('.preset-indicator');
                    const dot = c.querySelector('.preset-dot');
                    if (indicator) {
                        indicator.style.borderColor = isTarget ? 'var(--primary, #712f23)' : '#cbd5e1';
                    }
                    if (dot) {
                        dot.classList.toggle('bg-primary', isTarget);
                        dot.classList.toggle('bg-transparent', !isTarget);
                    }
                });

                updateLivePreview();
            }

            presetCards.forEach(card => {
                card.addEventListener('click', function() {
                    selectPreset(this);
                });
            });

            // Listen to manual background color input changes
            if (colorBg) {
                colorBg.addEventListener('input', function() {
                    if (hexBg) hexBg.value = this.value.toUpperCase();
                    updateLivePreview();
                });
            }

            // Listen to manual button & text color changes
            [colorPrimary, colorTextPrimary, colorSecondary, colorTextSecondary, colorAccent, colorBodyText].forEach(input => {
                if (input) {
                    input.addEventListener('input', function() {
                        const customCard = document.querySelector('.theme-preset-card[data-slug="custom"]');
                        if (customCard && themeSlugInput && themeSlugInput.value !== 'custom') {
                            selectPreset(customCard);
                        }
                        updateLivePreview();
                    });
                }
            });

            // Initial render
            updateLivePreview();
        });
    </script>
@endsection