@extends('layouts.admin.layout')
@section('title', 'Edit Lomba')

@section('content')
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Data Lomba</h5>

                <form action="{{ route('lomba.update', $lomba->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">NAMA LOMBA</label>
                        <input type="text" name="nama_lomba" class="form-control" value="{{ $lomba->nama_lomba }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">KATEGORI</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Akademik" {{ $lomba->kategori == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Non-Akademik" {{ $lomba->kategori == 'Non-Akademik' ? 'selected' : '' }}>
                                Non-Akademik</option>
                            <option value="Seni" {{ $lomba->kategori == 'Seni' ? 'selected' : '' }}>Seni</option>
                            <option value="Olahraga" {{ $lomba->kategori == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">DESKRIPSI</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ $lomba->deskripsi }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">TANGGAL PELAKSANAAN</label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control"
                                value="{{ $lomba->tanggal_pelaksanaan }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">STATUS</label>
                            <select name="status" class="form-select">
                                <option value="aktif" {{ $lomba->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $lomba->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold">GANTI POSTER (Opsional)</label>
                        <input type="file" name="poster" class="form-control">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah poster.</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Update
                            Data</button>
                        <a href="{{ route('lomba.index') }}" class="btn btn-secondary px-4"><i
                                class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection