@extends('layouts.admin.layout')
@section('title', 'Edit Pendaftar')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-light rounded-circle me-3">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h5 class="fw-bold mb-0">Edit Data Pendaftar</h5>
                    </div>

                    <form action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $pendaftaran->nama) }}" required>
                            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $pendaftaran->email) }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">No. WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control"
                                value="{{ old('no_wa', $pendaftaran->no_wa) }}" required>
                            @error('no_wa') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Pembina</label>
                                <input type="text" name="nama_pembina" class="form-control"
                                    value="{{ old('nama_pembina', $pendaftaran->nama_pembina) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No. HP Pembina</label>
                                <input type="text" name="no_hp_pembina" class="form-control"
                                    value="{{ old('no_hp_pembina', $pendaftaran->no_hp_pembina) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Metode Pembayaran</label>
                                <select name="metode_pembayaran" class="form-select">
                                    <option value="transfer" {{ old('metode_pembayaran', $pendaftaran->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>TRANSFER</option>
                                    <option value="tunai" {{ old('metode_pembayaran', $pendaftaran->metode_pembayaran) == 'tunai' ? 'selected' : '' }}>TUNAI</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="pending" {{ old('status', $pendaftaran->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status', $pendaftaran->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="rejected" {{ old('status', $pendaftaran->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Lomba</label>
                            <select name="lomba_id" class="form-select" required>
                                @foreach($lombas as $l)
                                    <option value="{{ $l->id }}" {{ old('lomba_id', $pendaftaran->lomba_id) == $l->id ? 'selected' : '' }}>
                                        {{ $l->nama_lomba }} ({{ ucfirst($l->tipe_lomba) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if($pendaftaran->formulir_pendaftaran)
                            <div class="mb-4">
                                <label class="form-label d-block fw-semibold">File Formulir</label>
                                <a href="{{ asset('storage/' . $pendaftaran->formulir_pendaftaran) }}" target="_blank"
                                    class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-file-earmark-text me-1"></i> Lihat / Download Formulir
                                </a>
                            </div>
                        @endif

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection