@extends('layouts.admin.layout')
@section('title', 'Edit Carousel')

@section('content')
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Carousel</h5>

                <form action="{{ route('carousel.update', $carousel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">KETERANGAN </label>
                        <textarea name="keterangan" class="form-control" rows="2"
                            placeholder="Masukan keterangan kecil di bawah tombol...">{{ $carousel->keterangan }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">LINK CTA (Opsional)</label>
                        <input type="text" name="link_url" class="form-control" value="{{ $carousel->link_url }}"
                            placeholder="Contoh: /pendaftaran atau https://...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">GAMBAR CAROUSEL</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $carousel->gambar) }}" class="img-thumbnail"
                                style="max-height: 150px">
                        </div>
                        <input type="file" name="gambar" class="form-control">
                        <small class="text-muted">Format: JPG, PNG, JPEG. Ukuran maks: 5MB. Biarkan kosong jika tidak ingin
                            mengubah gambar.</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Simpan
                            Perubahan</button>
                        <a href="{{ route('carousel.index') }}" class="btn btn-light px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection