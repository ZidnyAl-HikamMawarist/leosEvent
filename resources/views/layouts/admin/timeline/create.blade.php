@extends('layouts.admin.layout')
@section('title', 'Tambah Timeline')

@section('content')
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-calendar-event me-2"></i>Tambah Timeline</h5>

                <form action="{{ route('timeline.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">JUDUL KEGIATAN</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Technical Meeting"
                            required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">TANGGAL</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">URUTAN TAMPIL</label>
                            <input type="number" name="urutan" class="form-control" placeholder="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">DESKRIPSI SINGKAT</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan</button>
                        <a href="{{ route('timeline.index') }}" class="btn btn-light px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection