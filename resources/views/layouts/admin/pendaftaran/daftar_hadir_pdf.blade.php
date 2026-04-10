<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir LEO'S 11</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0.5cm; /* Margin luar untuk frame */
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10pt; 
            margin: 0;
            padding: 0;
        }
        /* Bingkai terluar sesuai gambar */
        .outer-border {
            border: 1px solid #ccc;
            padding: 20px;
            min-height: 28cm;
        }
        /* Header / Kop Surat */
        .kop-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 2px;
        }
        .logos {
            display: flex;
            gap: 5px;
        }
        .logos img {
            height: 60px; /* Sesuaikan ukuran logo */
            width: auto;
        }
        .header-text {
            text-align: center;
            flex-grow: 1;
        }
        .header-text h1 { font-size: 14pt; margin: 0; font-weight: normal; }
        .header-text h2 { font-size: 16pt; margin: 0; }
        .header-text p { font-size: 8.5pt; margin: 2px 0; }
        .header-text a { color: blue; text-decoration: underline; }
        
        /* Garis Ganda di bawah Kop */
        .double-line {
            border-top: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 15px;
        }

        /* Judul & Info */
        .title-section {
            text-align: center;
            margin-bottom: 15px;
        }
        .title-section strong {
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .title-section h3 {
            font-size: 12pt;
            margin-top: 10px;
        }
        .info-acara {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #000;
            height: 22px; /* Tinggi baris agar pas 30 baris dalam satu halaman */
            padding: 2px 5px;
            vertical-align: middle;
        }
        th {
            background-color: #d3d3d3;
            font-size: 10pt;
        }
        .col-no { width: 6%; text-align: center; }
        .col-nama { width: 24%; }
        .col-asal { width: 18%; }
        .col-telp { width: 14%; }
        .col-lomba { width: 20%; }
        .col-ttd { width: 18%; }

        /* Tanda Tangan Zig-zag dengan Nomor */
        .ttd-cell {
            position: relative;
            font-size: 8pt;
            padding: 0 !important;
        }
        .ttd-num {
            position: absolute;
            top: 2px;
        }
        .left-num { left: 5px; }
        .right-num { left: 50%; }

    </style>
</head>
<body>
    <div class="outer-border">
        <!-- HEADER -->
        <div class="kop-container">
            <div class="logos">
                <img src="logo1.png" alt="Logo">
                <img src="logo2.png" alt="Logo">
            </div>
            <div class="header-text">
                <h1>LEO'S 11 COMPETITION</h1>
                <h2>OSIS SMKN 1 CIAMIS</h2>
                <p>Jl. Jendral Sudirman, Cibereum No. 209, Sindangrasa, Kab Ciamis</p>
                <p>e-mail: <a href="mailto:smkn1ciamis@gmail.com">smkn1ciamis@gmail.com</a> website: <a href="http://smkn1ciamis.com">www.smkn1ciamis.com</a></p>
                <p>Telp/Fax: (0265)7777719</p>
            </div>
            <div class="logos">
                <img src="logo3.png" alt="Logo">
                <img src="logo4.png" alt="Logo">
            </div>
        </div>
        <div class="double-line"></div>

        <!-- JUDUL -->
        <div class="title-section">
            <strong>DAFTAR HADIR PESERTA TECHNICAL MEETING</strong><br>
            <strong>MATA LOMBA {{ strtoupper($lombaTitle) }}</strong>
        </div>

        <!-- INFO -->
        <div class="info-acara">
            <table style="border: none; width: auto;">
                <tr style="border: none;"><td style="border: none; padding: 0;">Hari/tanggal</td><td style="border: none; padding: 0;">: Sabtu, 11 April 2026</td></tr>
                <tr style="border: none;"><td style="border: none; padding: 0;">Waktu</td><td style="border: none; padding: 0;">: 07.00 s.d. Selesai</td></tr>
                <tr style="border: none;"><td style="border: none; padding: 0;">Tempat</td><td style="border: none; padding: 0;">: GOR SMKN 1 Ciamis</td></tr>
            </table>
        </div>

        <!-- TABEL -->
        <table>
            <thead>
                <tr>
                    <th class="col-no">No.</th>
                    <th class="col-nama">Nama Peserta</th>
                    <th class="col-asal">Asal Sekolah</th>
                    <th class="col-telp" style="text-align: center;">Status</th>
                    <th class="col-lomba">Mata Lomba</th>
                    <th class="col-ttd">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
@foreach($data as $p)
                    @php 
                        $i = $loop->iteration;
                        $isOdd = $i % 2 == 1;
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $i }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->sekolah }}</td>
                        <td style="font-size: 9pt; text-align: center;">{{ strtoupper($p->status) }}</td>
                        <td style="font-size: 9pt;">{{ $p->lomba->nama_lomba }}</td>
                        <td class="ttd-cell {{ $isOdd ? 'left-num' : 'right-num' }}">
                            <span class="ttd-num">{{ $i }}</span>
                        </td>
                    </tr>
                @endforeach
                @php $emptyCount = $jumlah_baris - $data->count(); @endphp
                @for($i = 1; $i <= $emptyCount; $i++)
                    @php $isOdd = ($data->count() + $i) % 2 == 1; @endphp
                    <tr>
                        <td style="text-align: center;">{{ $data->count() + $i }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="ttd-cell {{ $isOdd ? 'left-num' : 'right-num' }}">
                            <span class="ttd-num">{{ $data->count() + $i }}</span>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</body>
</html>
