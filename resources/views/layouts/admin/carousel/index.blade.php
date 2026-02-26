@extends('layouts.admin.layout')
@section('title', 'Carousel Event')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5 class="fw-bold m-0">Pengaturan Carousel
                    <br><small class="text-muted fs-6 fw-normal">Slot Terisi: {{ $carousels->count() }} / {{ $maxAllowed }}
                        (Mengikuti Total Lomba Aktif)</small>
                </h5>
                @if($carousels->count() < $maxAllowed)
                    <a href="{{ route('carousel.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Tambah Slide
                    </a>
                @else
                    <button class="btn btn-secondary" disabled
                        title="Slot Penuh. Sesuai jumlah lomba, harap hapus banner lama untuk menambah baru.">
                        <i class="bi bi-x-circle"></i> Slot Penuh
                    </button>
                @endif
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4">
                @foreach ($carousels as $item)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top"
                                style="height: 150px; object-fit: cover;">
                            <div class="card-body px-3 py-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-primary mb-0">Slide {{ $loop->iteration }}</h6>

                                    <div class="dropdown" style="margin-right: -10px; margin-top: -5px;">
                                        <button
                                            class="btn btn-link text-muted px-2 py-1 text-decoration-none shadow-none focus-ring-0"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('carousel.edit', $item->id) }}">
                                                    <i class="bi bi-pencil-square me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('carousel.destroy', $item->id) }}" method="POST"
                                                    class="m-0">
                                                    @csrf @method('DELETE')
                                                    <button class="dropdown-item text-danger"
                                                        onclick="return confirm('Hapus slide ini?')">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }} mb-2">
                                    {{ ucfirst($item->status) }}
                                </div>
                                <p class="text-muted small mb-0"
                                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3em;">
                                    {{ $item->keterangan ?? 'Tanpa keterangan' }}
                                </p>
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