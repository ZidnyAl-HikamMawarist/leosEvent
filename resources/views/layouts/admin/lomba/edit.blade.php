@extends('layouts.admin.layout')
@section('title', 'Edit Lomba')

@section('content')
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Data Lomba</h5>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('lomba.update', $lomba->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">NAMA LOMBA <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nama_lomba" class="form-control" value="{{ $lomba->nama_lomba }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">KATEGORI <span
                                class="text-danger">*</span></label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Akademik" {{ $lomba->kategori == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Non-Akademik" {{ $lomba->kategori == 'Non-Akademik' ? 'selected' : '' }}>
                                Non-Akademik</option>
                            <option value="Seni" {{ $lomba->kategori == 'Seni' ? 'selected' : '' }}>Seni</option>
                            <option value="Olahraga" {{ $lomba->kategori == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">DESKRIPSI <span
                                class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="4" required>{{ $lomba->deskripsi }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">TINGKAT <span
                                    class="text-danger">*</span></label>
                            <select name="tingkat" class="form-select" required>
                                <option value="SD" {{ $lomba->tingkat == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ $lomba->tingkat == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ $lomba->tingkat == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="Umum" {{ $lomba->tingkat == 'Umum' ? 'selected' : '' }}>Umum</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">TIPE LOMBA <span
                                    class="text-danger">*</span></label>
                            <select name="tipe_lomba" class="form-select" required>
                                <option value="solo" {{ $lomba->tipe_lomba == 'solo' ? 'selected' : '' }}>Solo / Individu
                                </option>
                                <option value="kelompok" {{ $lomba->tipe_lomba == 'kelompok' ? 'selected' : '' }}>Kelompok /
                                    Regu</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">TANGGAL PELAKSANAAN <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control"
                                value="{{ $lomba->tanggal_pelaksanaan }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">JAM MULAI (24 Jam / WIB)</label>
                            <input type="text" name="event_start" class="form-control"
                                value="{{ $lomba->event_start ? \Carbon\Carbon::parse($lomba->event_start)->format('H:i') : '' }}"
                                placeholder="08:00" pattern="[0-9]{2}:[0-9]{2}" title="Format: HH:mm (Contoh: 14:00)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">JAM SELESAI (24 Jam / WIB)</label>
                            <input type="text" name="event_end" class="form-control"
                                value="{{ $lomba->event_end ? \Carbon\Carbon::parse($lomba->event_end)->format('H:i') : '' }}"
                                placeholder="17:00" pattern="[0-9]{2}:[0-9]{2}" title="Format: HH:mm (Contoh: 17:00)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">STATUS</label>
                        <select name="status" class="form-select">
                            <option value="aktif" {{ $lomba->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $lomba->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small fw-bold">GANTI POSTER (Opsional)</label>
                        <input type="file" name="poster" class="form-control">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah poster.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">TAHUN EVENT <span
                                    class="text-danger">*</span></label>
                            <!-- Tambahkan $lomba->event_year -->
                            <input type="number" name="event_year" class="form-control" value="{{ $lomba->event_year }}"
                                required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">LOKASI (Opsional)</label>
                            <!-- Tambahkan $lomba->lokasi -->
                            <input type="text" name="lokasi" class="form-control" value="{{ $lomba->lokasi }}"
                                placeholder="Contoh: GOR Sekolah">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-secondary small fw-bold">HARGA TIKET (Rp) (Opsional)</label>
                            <!-- Tambahkan $lomba->harga_tiket -->
                            <input type="number" name="harga_tiket" class="form-control" value="{{ $lomba->harga_tiket }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">LINK JUKLAK & JUKNIS (Opsional)</label>
                            <input type="url" name="juklak_juknis_link" class="form-control"
                                value="{{ $lomba->juklak_juknis_link }}" placeholder="https://drive.google.com/...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small fw-bold">WA PANITIA (Format: 628...)</label>
                            <input type="text" name="whatsapp_panitia" class="form-control"
                                value="{{ $lomba->whatsapp_panitia }}" placeholder="628123456789">
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-4 mb-4 border">
                        <label class="form-label text-primary fw-bold mb-3"><i class="bi bi-trophy me-2"></i>PENGUMUMAN
                            PEMENANG (Opsional)</label>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-secondary small fw-bold">JUARA 1</label>
                                <input type="text" name="juara_1" class="form-control border-primary-subtle"
                                    value="{{ $lomba->juara_1 }}" placeholder="Nama Pemenang">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-secondary small fw-bold">JUARA 2</label>
                                <input type="text" name="juara_2" class="form-control border-primary-subtle"
                                    value="{{ $lomba->juara_2 }}" placeholder="Nama Pemenang">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-secondary small fw-bold">JUARA 3</label>
                                <input type="text" name="juara_3" class="form-control border-primary-subtle"
                                    value="{{ $lomba->juara_3 }}" placeholder="Nama Pemenang">
                            </div>
                        </div>
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Isi nama pemenang jika lomba sudah
                            selesai.</small>
                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i>Update
                            Data</button>
                        <a href="{{ route('lomba.index') }}" class="btn btn-secondary px-4"><i
                                class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelector('input[name="nama_lomba"]').addEventListener('input', function (e) {
            const name = e.target.value;
            const feedback = document.getElementById('name-feedback');
            if (!feedback) {
                const div = document.createElement('div');
                div.id = 'name-feedback';
                div.className = 'small mt-1';
                e.target.parentNode.appendChild(div);
            }

            if (name.length < 3) {
                document.getElementById('name-feedback').innerHTML = '';
                return;
            }

            fetch(`{{ route('admin.lomba.checkName') }}?name=${encodeURIComponent(name)}&exclude_id={{ $lomba->id }}`)
                .then(res => res.json())
                .then(data => {
                    const feedback = document.getElementById('name-feedback');
                    if (data.exists) {
                        feedback.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>Nama lomba sudah ada!</span>';
                        e.target.classList.add('is-invalid');
                    } else {
                        feedback.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>Nama tersedia</span>';
                        e.target.classList.remove('is-invalid');
                        e.target.classList.add('is-valid');
                    }
                });
        });
    </script>
@endsection