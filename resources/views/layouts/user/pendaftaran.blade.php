@extends('layouts.app')

@section('title', 'Pendaftaran')

@section('content')
    <section class="py-5 position-relative min-vh-100 d-flex align-items-center overflow-hidden">


        <div class="container position-relative z-1 py-5 mt-5">
            <div class="row align-items-center g-5 justify-content-center">
                <!-- Left Side: Info -->
                <div class="col-lg-5 col-xl-4 d-none d-lg-block" data-aos="fade-right">
                    <div class="registration-info">
                        <div
                            class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-4 border border-primary border-opacity-25 shadow-sm">
                            <i class="bi bi-person-plus-fill me-2"></i> {{ $setting->reg_tag ?? 'REGISTRATION OPEN' }}
                        </div>
                        <h1 class="display-4 fw-bold text-white mb-4 font-secondary">{{ $setting->reg_title ?? 'Begin Your Journey With Us.' }}</h1>
                        <p class="text-muted fs-5 mb-5">
                            {{ $setting->reg_subtitle ?? 'Secure your place at the premier event of the season. Join industry leaders and visionaries in a day of innovation.' }}
                        </p>

                        <div class="benefit-list">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div
                                    class="bg-glass p-2 rounded-3 text-primary border border-white border-opacity-10 shadow-sm">
                                    <i class="bi bi-shield-check fs-4"></i>
                                </div>
                                <span class="text-white-50">{{ $setting->reg_feature_1 ?? 'Secure and fast verification process.' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div
                                    class="bg-glass p-2 rounded-3 text-secondary border border-white border-opacity-10 shadow-sm">
                                    <i class="bi bi-envelope-paper fs-4"></i>
                                </div>
                                <span class="text-white-50">{{ $setting->reg_feature_2 ?? 'Instant confirmation via email.' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    class="bg-glass p-2 rounded-3 text-accent border border-white border-opacity-10 shadow-sm">
                                    <i class="bi bi-headset fs-4"></i>
                                </div>
                                <span class="text-white-50">{{ $setting->reg_feature_3 ?? '24/7 Priority support for attendees.' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Form -->
                <div class="col-lg-7 col-xl-6" data-aos="fade-left">
                    <div class="premium-card p-5 bg-glass border border-white border-opacity-10 shadow-2xl">
                        <div class="brand-badge text-center mb-5">
                            <div class="mb-3">
                                @if($setting && $setting->logo)
                                    {{-- Logo tampil penuh tanpa lingkaran pembungkus yang tebal --}}
                                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="img-fluid"
                                        style="max-height: 100px; width: auto; filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.1));">
                                @else
                                    {{-- Fallback jika logo tidak ada --}}
                                    <div
                                        class="d-inline-flex bg-primary bg-opacity-10 p-4 rounded-circle border border-primary border-opacity-25">
                                        <i class="bi bi-intersect fs-1 text-primary"></i>
                                    </div>
                                @endif
                            </div>

                            <h2 class="fw-bold text-white mb-1">{{ $setting->reg_form_title ?? 'Registration Form' }}</h2>
                            <p class="text-muted">{{ $setting->reg_form_subtitle ?? 'Fill in your details to get started' }}</p>
                        </div>





                        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="row g-4">
                            @csrf

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">Pilih Mata Lomba</label>
                                    <select name="lomba_id" id="lomba_select" class="form-select glass-input-field" required>
                                        <option value="" disabled {{ !isset($selectedLomba) ? 'selected' : '' }}>-- Pilih Lomba --</option>
                                        @foreach($lombas as $l)
                                            <option value="{{ $l->id }}" 
                                                data-tipe="{{ $l->tipe_lomba }}" 
                                                data-wa="{{ $l->whatsapp_panitia }}"
                                                data-grup="{{ $l->link_grup_wa }}"
                                                {{ (isset($selectedLomba) && $selectedLomba->id == $l->id) ? 'selected' : '' }} 
                                                class="bg-white text-dark">
                                                {{ $l->nama_lomba }} ({{ ucfirst($l->tipe_lomba) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2" id="label_nama">Nama Peserta</label>
                                    <input type="text" name="nama" class="form-control glass-input-field"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">Asal Sekolah</label>
                                    <input type="text" name="sekolah" class="form-control glass-input-field"
                                        placeholder="Contoh: SMP Negeri 1 Jakarta" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2" id="label_email">Email Peserta</label>
                                    <input type="email" name="email" class="form-control glass-input-field"
                                        placeholder="email@anda.com" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2" id="label_no_wa">No. HP / WhatsApp Peserta</label>
                                    <input type="text" name="no_wa" class="form-control glass-input-field"
                                        placeholder="Contoh: 08123456789" required>
                                </div>
                            </div>

                            <!-- Common Fields for both Solo and Kelompok -->
                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">Nama Pembina</label>
                                    <input type="text" name="nama_pembina" class="form-control glass-input-field"
                                        placeholder="Masukkan nama pembina" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">No. HP Pembina</label>
                                    <input type="text" name="no_hp_pembina" class="form-control glass-input-field"
                                        placeholder="Contoh: 08123456789" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="pembayaran_select" class="form-select glass-input-field" required>
                                        <option value="transfer">TRANSFER</option>
                                        <option value="tunai">TUNAI (Pada saat Technical Meeting)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 fs-5 rounded-pill shadow-lg">
                                    Daftar Sekarang <i class="bi bi-send-fill ms-2"></i>
                                </button>
                                <p class="text-center text-muted mt-4 small opacity-75">
                                    Pastikan data yang diisi sudah sesuai. <br>
                                    Setelah mendaftar, silakan hubungi panitia untuk validasi.
                                </p>
                            </div>
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const lombaSelect = document.getElementById('lomba_select');
                                const labelNama = document.getElementById('label_nama');
                                const labelEmail = document.getElementById('label_email');
                                const labelNoWa = document.getElementById('label_no_wa');

                                function updateForm() {
                                    const selectedOption = lombaSelect.options[lombaSelect.selectedIndex];

                                    if (!selectedOption || selectedOption.value === "") {
                                        return;
                                    }

                                    const tipe = selectedOption.getAttribute('data-tipe');

                                    // Update Labels
                                    if (tipe === 'kelompok') {
                                        labelNama.innerText = 'Nama Pemimpin Regu';
                                        labelEmail.innerText = 'Email Pemimpin Regu';
                                        labelNoWa.innerText = 'No. HP / WhatsApp Pemimpin Regu';
                                    } else {
                                        labelNama.innerText = 'Nama Peserta';
                                        labelEmail.innerText = 'Email Peserta';
                                        labelNoWa.innerText = 'No. HP / WhatsApp Peserta';
                                    }
                                }

                                if (lombaSelect) lombaSelect.addEventListener('change', updateForm);
                                const pSelect = document.getElementById('pembayaran_select');
                                if (pSelect) pSelect.addEventListener('change', updateForm);
                                
                                // Initial run
                                updateForm();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .glass-input-field {
            background: rgba(113, 47, 35, 0.05) !important;
            border: 1px solid rgba(197, 163, 83, 0.2) !important;
            color: #fdf6f0 !important;
            border-radius: 12px !important;
            padding: 0.8rem 1.2rem !important;
            font-size: 1rem !important;
            transition: all 0.3s ease;
        }

        .glass-input-field:focus {
            background: rgba(113, 47, 35, 0.1) !important;
            border-color: var(--secondary) !important;
            box-shadow: 0 0 15px rgba(197, 163, 83, 0.2) !important;
        }

        .glass-input-field::placeholder {
            color: rgba(212, 195, 188, 0.5) !important;
        }

        @media (max-width: 768px) {
            .glass-input-field {
                padding: 1rem 1.2rem !important;
                font-size: 1.05rem !important;
                border-radius: 14px !important;
            }
            .form-label {
                font-size: 0.95rem !important;
                margin-bottom: 0.5rem !important;
            }
        }

        /* Essential for select options visibility */
        option {
            background-color: #fdf6f0 !important;
            color: #4a1b14 !important;
            padding: 14px !important;
            font-size: 1rem !important;
        }

        /* Success Modal Styles */
        #successModal .modal-content {
            background: rgba(15, 9, 8, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(197, 163, 83, 0.3);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5);
        }
        
        .success-icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(25, 135, 84, 0.1);
            border: 1px solid rgba(25, 135, 84, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
    </style>

    @if(session('success'))
        <!-- Premium Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-5 p-2">
                    <div class="modal-header border-0 justify-content-end pb-0">
                        <button type="button" class="btn-close btn-close-white opacity-50" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center px-4 px-md-5 pt-0 pb-5">
                        <div class="success-icon-wrapper mb-4 shadow" data-aos="zoom-in" data-aos-delay="100">
                            <i class="bi bi-check-lg text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-3 font-secondary" data-aos="fade-up" data-aos-delay="200">Registrasi Berhasil!</h3>
                        <p class="text-white-50 mb-4" data-aos="fade-up" data-aos-delay="300">{{ session('success') }}</p>
                        
                        @if(session('link_grup') || (session('wa_panitia') && session('metode_pembayaran') == 'transfer'))
                            <div class="bg-black bg-opacity-25 rounded-4 p-4 border border-white border-opacity-10" data-aos="fade-up" data-aos-delay="400">
                                <p class="text-muted small mb-3">Langkah selanjutnya yang perlu Anda lakukan:</p>
                                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                                    
                                    @if(session('link_grup'))
                                        <a href="{{ session('link_grup') }}" target="_blank" class="btn btn-outline-primary rounded-pill px-4 py-2 fs-6 flex-grow-1">
                                            <i class="bi bi-people-fill me-2"></i> Grup Lomba
                                        </a>
                                    @endif

                                    @if(session('wa_panitia') && session('metode_pembayaran') == 'transfer')
                                        @php
                                            $wa = session('wa_panitia');
                                            $formattedWa = preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', trim($wa)));
                                            if (!str_starts_with($formattedWa, '62')) $formattedWa = '62' . $formattedWa;
                                            $encodedLomba = urlencode(session('nama_lomba'));
                                            $waLink = "https://api.whatsapp.com/send?phone={$formattedWa}&text=Halo%20Panitia%20Leos%20Event,%20saya%20ingin%20mengirimkan%20bukti%20transfer%20untuk%20pendaftaran%20lomba%20{$encodedLomba}.";
                                        @endphp
                                        <a href="{{ $waLink }}" target="_blank" class="btn btn-success rounded-pill px-4 py-2 fs-6 flex-grow-1 border-0 shadow" style="background: #25D366;">
                                            <i class="bi bi-whatsapp me-2"></i> Konfirmasi
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <button type="button" class="btn btn-outline-custom rounded-pill px-5 mt-2" data-bs-dismiss="modal">Tutup</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
                    keyboard: false
                });
                myModal.show();
            });
        </script>
    @endif
@endsection