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
                            <div
                                class="d-inline-flex bg-primary bg-opacity-10 p-4 rounded-circle mb-3 border border-primary border-opacity-25">
                                <i class="bi bi-intersect fs-1 text-primary"></i>
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

                        <form action="{{ route('pendaftaran.store') }}" method="POST" class="row g-4">
                            @csrf

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">Full Name</label>
                                    <input type="text" name="nama" class="form-control glass-input-field"
                                        placeholder="Enter your full name" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">Institution / Organization</label>
                                    <input type="text" name="sekolah" class="form-control glass-input-field"
                                        placeholder="e.g. University or School name" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="glass-input-group">
                                    <label class="form-label mb-2">Event Category</label>
                                    <select name="lomba_id" class="form-select glass-input-field" required>
                                        <option value="" disabled {{ !isset($selectedLomba) ? 'selected' : '' }}>-- Choose a
                                            category --</option>
                                        @foreach($lombas as $l)
                                            <option value="{{ $l->id }}" {{ (isset($selectedLomba) && $selectedLomba->id == $l->id) ? 'selected' : '' }} class="bg-white text-dark">
                                                {{ $l->nama_lomba }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-primary-custom w-100 py-3 fs-5 rounded-pill shadow-lg">
                                    Send Application <i class="bi bi-send-fill ms-2"></i>
                                </button>
                                <p class="text-center text-muted mt-4 small opacity-75">
                                    By submitting, you agree to our <a href="#"
                                        class="text-primary text-decoration-none">Terms and Conditions</a>.
                                </p>
                            </div>
                        </form>
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

        /* Essential for select options visibility */
        option {
            background-color: #fdf6f0 !important;
            color: #4a1b14 !important;
            padding: 10px;
        }
    </style>
@endsection