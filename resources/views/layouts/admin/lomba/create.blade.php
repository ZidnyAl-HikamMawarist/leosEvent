@extends('layouts.admin.layout')

@section('title', 'Tambah Lomba')

@section('content')
    <div class="mb-4">
        <a href="{{ route('lomba.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
        </a>
        <h4 class="fw-bold mt-2">Tambah Lomba Baru</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('lomba.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lomba</label>
                            <input type="text" name="nama_lomba"
                                class="form-control @error('nama_lomba') is-invalid @enderror"
                                value="{{ old('nama_lomba') }}" required>
                            @error('nama_lomba') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal_pelaksanaan"
                                    class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                                    value="{{ old('tanggal_pelaksanaan') }}" required>
                                @error('tanggal_pelaksanaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Lomba</label>
                                <select name="tipe_lomba" class="form-select @error('tipe_lomba') is-invalid @enderror"
                                    required>
                                    <option value="solo" {{ old('tipe_lomba') == 'solo' ? 'selected' : '' }}>Solo / Individu
                                    </option>
                                    <option value="kelompok" {{ old('tipe_lomba') == 'kelompok' ? 'selected' : '' }}>Kelompok
                                        / Regu</option>
                                </select>
                                @error('tipe_lomba') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="5" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Tahun Event</label>
                                <input type="number" name="event_year" class="form-control"
                                    value="{{ old('event_year', date('Y')) }}" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}"
                                    placeholder="Contoh: Gedung Serbaguna">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Waktu Mulai</label>
                                <input type="time" name="event_start" class="form-control"
                                    value="{{ old('event_start', '08:00') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Waktu Selesai</label>
                                <input type="time" name="event_end" class="form-control"
                                    value="{{ old('event_end', '16:00') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Poster Lomba</label>
                            <div class="border rounded-4 p-3 text-center bg-light">
                                <input type="file" name="poster" class="form-control mb-2" accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Tiket</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga_tiket" class="form-control"
                                    value="{{ old('harga_tiket', 0) }}">
                            </div>
                            <small class="text-muted">Isi 0 jika gratis</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Juklak Juknis</label>
                            <input type="url" name="juklak_juknis_link" class="form-control"
                                value="{{ old('juklak_juknis_link') }}" placeholder="https://drive.google.com/...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">WA Panitia</label>
                            <input type="text" name="whatsapp_panitia" class="form-control"
                                value="{{ old('whatsapp_panitia') }}" placeholder="62812xxx">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Grup WA Peserta</label>
                            <input type="url" name="link_grup_wa" class="form-control" value="{{ old('link_grup_wa') }}"
                                placeholder="https://chat.whatsapp.com/...">
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <hr>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save me-2"></i> Simpan Lomba
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection