@extends('layouts.admin.layout')
@section('title', 'Data Pendaftar')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Data Pendaftar</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pendaftaran.export', ['type' => 'excel', 'lomba_id' => request('lomba_id')]) }}"
                        class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export CSV
                    </a>
                    <button onclick="window.print()" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Print / PDF
                    </button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="d-flex gap-2">
                        <select name="lomba_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Mata Lomba</option>
                            @foreach($lombas as $l)
                                <option value="{{ $l->id }}" {{ request('lomba_id') == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_lomba }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Mata Lomba</th>
                            <th>Tanggal Daftar</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->sekolah }}</td>
                                <td>
                                    <span class="badge bg-primary opacity-75">{{ $p->lomba->nama_lomba ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada pendaftar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .btn,
            .form-select,
            .sidebar,
            .navbar {
                display: none !important;
            }

            .card {
                border: none !important;
            }

            .table-responsive {
                overflow: visible !important;
            }
        }
    </style>
@endsection