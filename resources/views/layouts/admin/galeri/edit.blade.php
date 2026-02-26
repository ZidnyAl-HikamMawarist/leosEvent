@extends('layouts.admin.layout')
@section('title', 'Edit Galeri')

@section('content')
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Edit Foto Galeri</h5>

                <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="form-label">Judul </label>
                    <input type="text" name="judul" class="form-control mb-3" value="{{ $galeri->judul }}" required>

                    <label class="form-label">Foto Baru (Opsional)</label>
                    <input type="file" name="gambar" class="form-control mb-2">
                    <small class="text-muted d-block mb-3">Biarkan kosong jika tidak ingin mengganti foto saat ini.</small>

                    @if($galeri->gambar)
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">Foto Saat Ini:</p>
                            <img src="{{ asset('storage/' . $galeri->gambar) }}" class="img-thumbnail"
                                style="max-height: 150px;">
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('galeri.index') }}" class="btn btn-secondary flex-grow-1">Batal</a>
                        <button type="submit" class="btn btn-primary flex-grow-1">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection