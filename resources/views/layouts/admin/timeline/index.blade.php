@extends('layouts.admin.layout')

@section('title', 'Manajemen Timeline')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-calendar-event me-2 text-primary"></i>Daftar Timeline Event</h4>
        <a href="{{ route('timeline.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i> Tambah Agenda
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
                            <th class="ps-4" style="width: 80px;">Urutan</th>
                            <th>Agenda</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($timelines as $item)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-secondary rounded-pill">{{ $item->urutan }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $item->judul }}</div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                <td><small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small></td>
                                <td>
                                    <span
                                        class="badge {{ $item->status === 'aktif' ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('timeline.edit', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('timeline.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus agenda ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted"> Belum ada agenda timeline. </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection