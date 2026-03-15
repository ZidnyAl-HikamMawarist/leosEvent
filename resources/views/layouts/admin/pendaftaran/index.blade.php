@extends('layouts.admin.layout')
@section('title', 'Data Pendaftar')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Data Pendaftar</h5>
                <div class="d-flex gap-2 align-items-center">
                    @if($hasBatch)
                        <form action="{{ route('admin.participants.rollback') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan (Rollback) sesi import terakhir? Semua data dari sesi tersebut akan dihapus permanen.')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-arrow-counterclockwise"></i> Rollback Terakhir
                            </button>
                        </form>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="bi bi-file-earmark-arrow-up me-1"></i> Import
                    </button>
                    <a href="{{ route('admin.pendaftaran.export', ['type' => 'excel', 'lomba_id' => request('lomba_id')]) }}"
                        class="btn btn-success btn-sm">
                        <i class="bi bi-file-earmark-excel me-1"></i> CSV
                    </a>
                    <a href="{{ route('admin.pendaftaran.export', ['type' => 'pdf', 'lomba_id' => request('lomba_id')]) }}"
                        class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i> PDF
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
                <div class="alert alert-success mt-2 border-0 shadow-sm rounded-3">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-2 border-0 shadow-sm rounded-3">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mt-2 border-0 shadow-sm rounded-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li><i class="bi bi-exclamation-circle me-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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
                            <th>Pembina</th>
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
                                    <div class="small fw-bold text-dark">{{ $p->nama_pembina ?? '-' }}</div>
                                    <div class="small text-muted">{{ $p->no_hp_pembina ?? '-' }}</div>
                                </td>
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

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Peserta (CSV)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.participants.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-primary shadow-sm border-0 rounded-4 mb-4">
                            <div class="d-flex gap-3">
                                <div class="fs-3"><i class="bi bi-magic"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Smart Import Aktif!</h6>
                                    <p class="small mb-0 opacity-75">Sistem otomatis mendeteksi kolom (Nama, WA, Sekolah, dll) & Kategori Lomba. Mendukung format <strong>CSV, TXT,</strong> dan hasil copy-paste <strong>Tab</strong> dari Google Sheets.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small mb-1">Pilih File CSV/GForm</label>
                            <input type="file" name="file_csv" class="form-control rounded-3" accept=".csv,.txt" required>
                            <div class="form-text mt-2 small">
                                <i class="bi bi-info-circle me-1"></i> Pastikan baris pertama berisi nama kolom (Header).
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold small mb-1">Pilihan Mata Lomba (Fallback)</label>
                            <select name="lomba_id" class="form-select rounded-3">
                                <option value="" selected>-- Gunakan dari File (Auto) --</option>
                                @foreach($lombas as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_lomba }}</option>
                                @endforeach
                            </select>
                            <div class="form-text mt-2 small text-muted">
                                Pilih lomba di sini hanya jika file Anda tidak memiliki kolom "Mata Lomba".
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Mulai Import</button>
                    </div>
                </form>
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