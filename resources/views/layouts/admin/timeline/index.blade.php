@extends('layouts.admin.layout')
@section('title', 'Timeline Event')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5 class="fw-bold m-0">Timeline Event</h5>
                <a href="{{ route('timeline.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Tambah Timeline
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="40">No</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timelines as $item)
                            <tr>
                                <td>{{ $item->urutan }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                <td>
                                    @if($item->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                            <li>
                                                <a class="dropdown-item py-2" href="{{ route('timeline.edit', $item->id) }}">
                                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider opacity-50">
                                            </li>
                                            <li>
                                                <form action="{{ route('timeline.destroy', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Hapus timeline ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($timelines->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data timeline</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection