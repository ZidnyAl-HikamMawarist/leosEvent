@extends('layouts.admin.layout')
@section('title', 'Tambah Carousel')

@section('content')
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-images me-2"></i>Tambah Carousel</h5>

                <form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">JUDUL (Opsional)</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukan judul carousel">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">GAMBAR CAROUSEL</label>
                        <input type="file" name="gambar" class="form-control" required>
                        <small class="text-muted">Format: JPG, PNG, JPEG. Ukuran maks: 2MB</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan</button>
                        <a href="{{ route('carousel.index') }}" class="btn btn-light px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection