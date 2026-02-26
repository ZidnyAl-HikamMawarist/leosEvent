<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export PDF - Data Pendaftar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            background-color: white;
            color: black;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        p {
            margin: 0;
            padding: 0;
        }

        h2,
        h4 {
            margin: 5px 0;
            padding: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN DATA PENDAFTAR</h2>
        @if(request('lomba_id'))
            <h4>Mata Lomba: {{ $data->first()->lomba->nama_lomba ?? 'Semua Lomba' }}</h4>
        @else
            <h4>Semua Mata Lomba</h4>
        @endif
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. WA</th>
                <th>Sekolah</th>
                <th>Mata Lomba</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Pembina / No HP</th>
                <th>Pembayaran</th>
                <th>Waktu Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->email ?? '-' }}</td>
                    <td>{{ $p->no_wa ?? '-' }}</td>
                    <td>{{ $p->sekolah }}</td>
                    <td>{{ $p->lomba->nama_lomba ?? 'N/A' }}</td>
                    <td>{{ ucfirst($p->lomba->tipe_lomba ?? '-') }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>
                        {{ $p->nama_pembina ?? '-' }} <br>
                        <small>{{ $p->no_hp_pembina ?? '' }}</small>
                    </td>
                    <td>{{ strtoupper($p->metode_pembayaran) }}</td>
                    <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align:center;">Belum ada data pendaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>