@extends('layouts.admin.layout')
@section('title', 'Galeri')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5 class="fw-bold mb-0">Galeri Tahun Sebelumnya
                    <br><small class="text-muted fs-6 fw-normal">Slot Terisi: {{ $galeris->count() }} / {{ $maxAllowed }}
                        (Ditampilkan Utama: {{ $limit }})</small>
                </h5>
                @if($galeris->count() < $maxAllowed)
                    <a href="{{ route('galeri.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i> Tambah Foto
                    </a>
                @else
                    <button class="btn btn-secondary" disabled title="Slot Penuh. Hapus foto lama untuk menambah baru.">
                        <i class="bi bi-x-circle"></i> Slot Penuh
                    </button>
                @endif
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                @foreach($galeris as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top"
                                style="height:180px;object-fit:cover">

                            <div class="card-body px-3 py-3 d-flex justify-content-between align-items-center">
                                <p class="fw-semibold mb-0 pe-2 flex-grow-1 text-truncate" title="{{ $item->judul }}">
                                    {{ $item->judul }}
                                </p>

                                <div class="dropdown" style="margin-right: -10px;">
                                    <button
                                        class="btn btn-link text-muted px-2 py-1 text-decoration-none shadow-none focus-ring-0"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('galeri.edit', $item->id) }}">
                                                <i class="bi bi-pencil-square me-2 text-warning"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('galeri.destroy', $item->id) }}" method="POST" class="m-0">
                                                @csrf @method('DELETE')
                                                <button class="dropdown-item text-danger"
                                                    onclick="return confirm('Yakin ingin menghapus foto?')">
                                                    <i class="bi bi-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection