@extends('layouts.admin.layout')
@section('title', 'Edit Timeline')

@section('content')
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Timeline</h5>

                <form action="{{ route('timeline.update', $timeline->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">JUDUL KEGIATAN</label>
                        <input type="text" name="judul" class="form-control" value="{{ $timeline->judul }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">TANGGAL</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $timeline->tanggal }}"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">URUTAN</label>
                            <input type="number" name="urutan" class="form-control" value="{{ $timeline->urutan }}"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">STATUS</label>
                            <select name="status" class="form-select">
                                <option value="aktif" {{ $timeline->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $timeline->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">DESKRIPSI SINGKAT</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ $timeline->deskripsi }}</textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Update
                            Data</button>
                        <a href="{{ route('timeline.index') }}" class="btn btn-light px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection