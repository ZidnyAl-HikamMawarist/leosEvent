@extends('layouts.admin.layout')
@section('title', 'Data Lomba')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h5 class="fw-bold">Data Lomba</h5>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('lomba.create') }}" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Lomba
                    </a>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="{{ route('lomba.index') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0"
                                placeholder="Cari nama lomba..." value="{{ $search }}">
                        </div>
                        <button type="submit" class="btn btn-secondary px-4">Cari</button>
                        @if($search)
                            <a href="{{ route('lomba.index') }}"
                                class="btn btn-light border border-secondary p-2 d-flex align-items-center justify-content-center">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" width="50">#</th>
                            <th>Poster</th>
                            <th>Nama Lomba</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th>Tahun</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lombas as $lomba)
                            <tr>
                                <td class="ps-3">{{ ($lombas->currentPage() - 1) * $lombas->perPage() + $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $lomba->poster) }}" class="rounded shadow-sm"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $lomba->nama_lomba }}</div>
                                    <small class="text-muted">{{ $lomba->tingkat }}</small>
                                </td>
                                <td><span class="badge bg-light text-primary border">{{ $lomba->kategori }}</span></td>
                                <td>
                                    @if($lomba->tipe_lomba == 'kelompok')
                                        <span class="badge bg-info">Kelompok</span>
                                    @else
                                        <span class="badge bg-secondary">Solo</span>
                                    @endif
                                </td>
                                <td>{{ $lomba->event_year }}</td>
                                <td class="text-end pe-3">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle border shadow-sm" type="button"
                                            id="dropdown{{ $lomba->id }}" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="width: 32px; height: 32px; padding: 0;">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border"
                                            aria-labelledby="dropdown{{ $lomba->id }}">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center py-2"
                                                    href="{{ route('lomba.edit', $lomba) }}">
                                                    <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider opacity-50">
                                            </li>
                                            <li>
                                                <form action="{{ route('lomba.destroy', $lomba) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus lomba {{ $lomba->nama_lomba }}?')">
                                                    @csrf @method('DELETE')
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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                    Data lomba tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
                <div class="text-muted small">
                    Showing {{ $lombas->firstItem() }} to {{ $lombas->lastItem() }} of {{ $lombas->total() }} entries
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="pagination-input d-flex align-items-center gap-2">
                        <span class="small text-muted">Page</span>
                        <input type="number" id="manual-page" class="form-control form-control-sm text-center"
                            value="{{ $lombas->currentPage() }}" min="1" max="{{ $lombas->lastPage() }}"
                            style="width: 60px;">
                        <span class="small text-muted">of {{ $lombas->lastPage() }}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="goToPage()">Go</button>
                    </div>
                    {{ $lombas->appends(['search' => $search])->links('pagination::bootstrap-5') }}
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
@endsection