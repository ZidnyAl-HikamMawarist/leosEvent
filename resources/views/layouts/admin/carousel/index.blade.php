@extends('layouts.admin.layout')
@section('title', 'Carousel Event')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5 class="fw-bold m-0">Pengaturan Carousel</h5>
                <a href="{{ route('carousel.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah Slide
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                @foreach ($carousels as $item)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top"
                                style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $item->judul }}</h6>
                                <p class="text-muted small mb-3 text-truncate">{{ $item->deskripsi }}</p>
                                <div class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }} mb-3">
                                    {{ ucfirst($item->status) }}
                                </div>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('carousel.destroy', $item->id) }}" method="POST" class="w-100"
                                        onsubmit="return confirm('Hapus slide ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm w-100">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if($carousels->isEmpty())
                    <div class="col-12 text-center text-muted py-5">
                        Belum ada data carousel
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection