@extends('layouts.admin.layout')

@section('title', 'Edit Agenda Timeline')

@section('content')
    <div class="mb-4">
        <a href="{{ route('timeline.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
        </a>
        <h4 class="fw-bold mt-2">Edit Agenda: {{ $timeline->judul }}</h4>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('timeline.update', $timeline->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Agenda</label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $timeline->judul) }}" required>
                            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" name="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', $timeline->tanggal) }}" required>
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Urutan</label>
                                <input type="number" name="urutan" class="form-control"
                                    value="{{ old('urutan', $timeline->urutan) }}" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="aktif" {{ old('status', $timeline->status) == 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="nonaktif" {{ old('status', $timeline->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control"
                                rows="3">{{ old('deskripsi', $timeline->deskripsi) }}</textarea>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow">
                                <i class="bi bi-save me-2"></i> Update Agenda
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection