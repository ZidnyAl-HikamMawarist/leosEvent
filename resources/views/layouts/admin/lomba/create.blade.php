@extends('layouts.admin.layout')
@section('title', 'Tambah Lomba')

@section('content')
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-trophy me-2"></i>Tambah Data Lomba</h5>

                <form action="{{ route('lomba.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">NAMA LOMBA</label>
                        <input type="text" name="nama_lomba" class="form-control" placeholder="Masukan nama lomba" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">KATEGORI</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Non-Akademik">Non-Akademik</option>
                            <option value="Seni">Seni</option>
                            <option value="Olahraga">Olahraga</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">DESKRIPSI</label>
                        <textarea name="deskripsi" class="form-control" rows="4"
                            placeholder="Masukan deskripsi lomba"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">TANGGAL PELAKSANAAN</label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">POSTER</label>
                            <input type="file" name="poster" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan
                            Data</button>
                        <a href="{{ route('lomba.index') }}" class="btn btn-secondary px-4"><i
                                class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection