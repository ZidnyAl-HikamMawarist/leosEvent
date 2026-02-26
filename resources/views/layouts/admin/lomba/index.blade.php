@extends('layouts.admin.layout')

@section('title', 'Manajemen Lomba')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-trophy me-2 text-primary"></i>Daftar Lomba</h4>
        <a href="{{ route('lomba.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i> Tambah Lomba
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Poster</th>
                            <th>Nama Lomba</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Pendaftar</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lombas as $lomba)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ asset('storage/' . $lomba->poster) }}" class="rounded shadow-sm"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $lomba->nama_lomba }}</div>
                                    <small class="text-muted">{{ $lomba->tipe_lomba }}</small>
                                </td>
                                <td>{{ $lomba->event_year }}</td>
                                <td>
                                    <span
                                        class="badge {{ $lomba->status === 'aktif' ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                        {{ ucfirst($lomba->status) }}
                                    </span>
                                </td>
                                <td>{{ $lomba->pendaftarans_count ?? 0 }} Peserta</td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-link text-muted px-2 py-1 text-decoration-none shadow-none focus-ring-0"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('lomba.edit', $lomba->id) }}">
                                                    <i class="bi bi-pencil-square me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('lomba.destroy', $lomba->id) }}" method="POST"
                                                    class="m-0">
                                                    @csrf @method('DELETE')
                                                    <button class="dropdown-item text-danger"
                                                        onclick="return confirm('Yakin ingin menghapus lomba ini?')">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted"> Belum ada data lomba. </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($lombas->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $lombas->links() }}
            </div>
        @endif
    </div>
@endsection