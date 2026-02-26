@extends('layouts.admin.layout')

@section('title', 'Edit Lomba')

@section('content')
    <div class="mb-4">
        <a href="{{ route('lomba.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
        </a>
        <h4 class="fw-bold mt-2">Edit Lomba: {{ $lomba->nama_lomba }}</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('lomba.update', $lomba->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lomba</label>
                            <input type="text" name="nama_lomba"
                                class="form-control @error('nama_lomba') is-invalid @enderror"
                                value="{{ old('nama_lomba', $lomba->nama_lomba) }}" required>
                            @error('nama_lomba') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal_pelaksanaan"
                                    class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                                    value="{{ old('tanggal_pelaksanaan', $lomba->tanggal_pelaksanaan) }}" required>
                                @error('tanggal_pelaksanaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Tipe Lomba</label>
                                <select name="tipe_lomba" class="form-select @error('tipe_lomba') is-invalid @enderror"
                                    required>
                                    <option value="solo" {{ old('tipe_lomba', $lomba->tipe_lomba) == 'solo' ? 'selected' : '' }}>Solo</option>
                                    <option value="kelompok" {{ old('tipe_lomba', $lomba->tipe_lomba) == 'kelompok' ? 'selected' : '' }}>Kelompok</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="aktif" {{ old('status', $lomba->status) == 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="nonaktif" {{ old('status', $lomba->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="5" required>{{ old('deskripsi', $lomba->deskripsi) }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Tahun Event</label>
                                <input type="number" name="event_year" class="form-control"
                                    value="{{ old('event_year', $lomba->event_year) }}" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control"
                                    value="{{ old('lokasi', $lomba->lokasi) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Juara 1</label>
                                <input type="text" name="juara_1" class="form-control"
                                    value="{{ old('juara_1', $lomba->juara_1) }}" placeholder="Nama Pemenang">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Juara 2</label>
                                <input type="text" name="juara_2" class="form-control"
                                    value="{{ old('juara_2', $lomba->juara_2) }}" placeholder="Nama Pemenang">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Juara 3</label>
                                <input type="text" name="juara_3" class="form-control"
                                    value="{{ old('juara_3', $lomba->juara_3) }}" placeholder="Nama Pemenang">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Poster Lomba Saat Ini</label>
                            <img src="{{ asset('storage/' . $lomba->poster) }}" class="img-fluid rounded-4 shadow-sm mb-3">
                            <div class="border rounded-4 p-3 text-center bg-light">
                                <input type="file" name="poster" class="form-control mb-2" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin ganti</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Tiket</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_tiket" class="form-control"
                                    value="{{ old('harga_tiket', $lomba->harga_tiket) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Juklak Juknis</label>
                            <input type="url" name="juklak_juknis_link" class="form-control"
                                value="{{ old('juklak_juknis_link', $lomba->juklak_juknis_link) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">WA Panitia</label>
                            <input type="text" name="whatsapp_panitia" class="form-control"
                                value="{{ old('whatsapp_panitia', $lomba->whatsapp_panitia) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Grup WA Peserta</label>
                            <input type="url" name="link_grup_wa" class="form-control"
                                value="{{ old('link_grup_wa', $lomba->link_grup_wa) }}">
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <hr>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save me-2"></i> Update Lomba
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection