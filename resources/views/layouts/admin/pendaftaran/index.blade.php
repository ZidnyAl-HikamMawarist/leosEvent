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
                    <a href="{{ route('admin.pendaftaran.export', ['type' => 'pdf', 'lomba_id' => request('lomba_id')]) }}"
                        class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="d-flex gap-2">
                        <select name="lomba_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Mata Lomba</option>
                            @foreach($lombas as $l)
                                <option value="{{ $l->id }}" {{ $lomba_id == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_lomba }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, sekolah..."
                                value="{{ $search }}">
                            <button type="submit" class="btn btn-secondary">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. WhatsApp</th>
                            <th>Sekolah</th>
                            <th>Mata Lomba</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftarans as $p)
                            <tr>
                                <td>{{ ($pendaftarans->currentPage() - 1) * $pendaftarans->perPage() + $loop->iteration }}</td>
                                <td class="fw-bold">{{ $p->nama }}</td>
                                <td>{{ $p->email ?? '-' }}</td>
                                <td>{{ $p->no_wa ?? '-' }}</td>
                                <td>{{ $p->sekolah }}</td>
                                <td>
                                    <span class="fw-bold">{{ $p->lomba->nama_lomba ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                        {{ ucfirst($p->lomba->tipe_lomba ?? '-') }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($p->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                <td class="text-start pe-3">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle border shadow-sm" type="button"
                                            id="dropdown{{ $p->id }}" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="width: 32px; height: 32px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border"
                                            aria-labelledby="dropdown{{ $p->id }}">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center py-2"
                                                    href="{{ route('admin.pendaftaran.edit', $p->id) }}">
                                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider opacity-50">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="dropdown-item d-flex align-items-center py-2 text-danger">
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
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-people display-4 d-block mb-3 opacity-25"></i>
                                    Belum ada pendaftar yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
                <div class="text-muted small">
                    Showing {{ $pendaftarans->firstItem() }} to {{ $pendaftarans->lastItem() }} of
                    {{ $pendaftarans->total() }} entries
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="pagination-input d-flex align-items-center gap-2">
                        <span class="small text-muted">Page</span>
                        <input type="number" id="manual-page" class="form-control form-control-sm text-center"
                            value="{{ $pendaftarans->currentPage() }}" min="1" max="{{ $pendaftarans->lastPage() }}"
                            style="width: 60px;">
                        <span class="small text-muted">of {{ $pendaftarans->lastPage() }}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="goToPage()">Go</button>
                    </div>
                    {{ $pendaftarans->appends(['search' => $search, 'lomba_id' => $lomba_id])->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <script>
                function goToPage() {
                    const page = document.getElementById('manual-page').value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('page', page);
                    window.location.href = url.toString();
                }
            </script>
        </div>
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