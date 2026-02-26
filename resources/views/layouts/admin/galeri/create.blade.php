@extends('layouts.admin.layout')
@section('title', 'Tambah Galeri')

@section('content')
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Tambah Foto Galeri</h5>

                <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">Judul </label>
                    <input type="text" name="judul" class="form-control mb-3" required>

                    <label class="form-label">Foto</label>
                    <input type="file" name="gambar" class="form-control mb-3" required>

                    <button class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection