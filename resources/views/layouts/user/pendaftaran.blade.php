@extends('layouts.app')

@section('content')
    <section class="py-5 position-relative min-vh-100 d-flex align-items-center overflow-hidden">


        <div class="container position-relative z-1 py-5 mt-5">
            <div class="row align-items-center g-5 justify-content-center">
                <!-- Left Side: Info -->
                <div class="col-lg-5 col-xl-4 d-none d-lg-block" data-aos="fade-right">
                    <div class="registration-info">
                        <div
                            class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-4 border border-primary border-opacity-25 shadow-sm">
                            <i class="bi bi-person-plus-fill me-2"></i> REGISTRATION OPEN
                        </div>
                        <h1 class="display-4 fw-bold text-white mb-4 font-secondary">Begin Your <span
                                class="text-gradient">Journey</span> With Us.</h1>
                        <p class="text-muted fs-5 mb-5">
                            Secure your place at the premier event of the season. Join industry leaders and visionaries in a
                            day of innovation.
                        </p>

                        <div class="benefit-list">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div
                                    class="bg-glass p-2 rounded-3 text-primary border border-white border-opacity-10 shadow-sm">
                                    <i class="bi bi-shield-check fs-4"></i>
                                </div>
                                <span class="text-white-50">Secure and fast verification process.</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div
                                    class="bg-glass p-2 rounded-3 text-secondary border border-white border-opacity-10 shadow-sm">
                                    <i class="bi bi-envelope-paper fs-4"></i>
                                </div>
                                <span class="text-white-50">Instant confirmation via email.</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    class="bg-glass p-2 rounded-3 text-accent border border-white border-opacity-10 shadow-sm">
                                    <i class="bi bi-headset fs-4"></i>
                                </div>
                                <span class="text-white-50">24/7 Priority support for attendees.</span>
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

                            <h2 class="fw-bold text-white mb-1">Registration Form</h2>
                            <p class="text-muted">Fill in your details to get started</p>
                        </div>



                        @if(session('success'))
                            <div class="alert alert-success border-0 bg-success bg-opacity-20 text-white p-4 rounded-4 mb-4"
                                data-aos="zoom-in">
                                <i class="bi bi-check2-circle me-2 fs-4"></i> {{ session('success') }}
                            </div>
                        @endif

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

                            <div class="col-12 mt-4" id="wa_panitia_container" style="display: none;">
                                <div class="p-4 rounded-4 bg-glass border border-white border-opacity-10 text-center">
                                    <p class="text-white-50 small mb-3">Untuk konfirmasi & bukti transfer, hubungi panitia:</p>
                                    <a href="" id="wa_panitia_link" target="_blank" class="btn btn-outline-success rounded-pill px-4">
                                        <i class="bi bi-whatsapp me-2"></i> Chat Panitia via WhatsApp
                                    </a>
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
                                const waContainer = document.getElementById('wa_panitia_container');
                                const waLink = document.getElementById('wa_panitia_link');

                                function updateForm() {
                                    const selectedOption = lombaSelect.options[lombaSelect.selectedIndex];
                                    const paymentSelect = document.getElementById('pembayaran_select');
                                    const paymentMethod = paymentSelect ? paymentSelect.value : 'transfer';

                                    console.log('Selected Lomba:', selectedOption ? selectedOption.text : 'None');
                                    console.log('Payment Method:', paymentMethod);

                                    if (!selectedOption || selectedOption.value === "") {
                                        waContainer.style.display = 'none';
                                        return;
                                    }

                                    const tipe = selectedOption.getAttribute('data-tipe');
                                    let wa = selectedOption.getAttribute('data-wa') || '';

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

                                    // Show WA button logic
                                    if (wa.trim() !== '' && paymentMethod === 'transfer') {
                                        waContainer.style.display = 'block';
                                        
                                        // Format WA number (remove 0 at start, ensure it starts with 62)
                                        let formattedWa = wa.trim().replace(/^0/, '62').replace(/[^\d]/g, '');
                                        if (!formattedWa.startsWith('62')) formattedWa = '62' + formattedWa;

                                        waLink.href = `https://api.whatsapp.com/send?phone=${formattedWa}&text=Halo%20Panitia%20Leos%20Event,%20saya%20ingin%20mengirimkan%20bukti%20transfer%20untuk%20pendaftaran%20lomba%20${encodeURIComponent(selectedOption.text)}.`;
                                    } else {
                                        waContainer.style.display = 'none';
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
    </style>
@endsection