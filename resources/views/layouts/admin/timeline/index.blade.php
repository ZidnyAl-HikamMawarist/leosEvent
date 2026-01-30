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

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="80">Urutan</th>
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
                                <a href="{{ route('timeline.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('timeline.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus timeline ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
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
@endsection