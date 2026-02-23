<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .header {
            background: #712f23;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            padding: 30px;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #c5a353;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
        }

        .details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: bold;
            color: #712f23;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>LEOS EVENT</h1>
        </div>
        <div class="content">
            <h2>Halo, {{ $pendaftaran->nama }}!</h2>
            <p>Ini adalah pengingat otomatis bahwa mata lomba <strong>{{ $lomba->nama_lomba }}</strong> yang Anda ikuti
                akan segera dimulai dalam waktu dekat.</p>

            <div class="details">
                <div class="detail-item">
                    <span class="detail-label">📍 Lokasi:</span> {{ $lomba->lokasi ?? 'TBA' }}
                </div>
                <div class="detail-item">
                    <span class="detail-label">⏰ Waktu:</span>
                    {{ \Carbon\Carbon::parse($lomba->event_start)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($lomba->event_end)->format('H:i') }} WIB
                </div>
                <div class="detail-item">
                    <span class="detail-label">📅 Tanggal:</span>
                    {{ \Carbon\Carbon::parse($lomba->tanggal_pelaksanaan)->format('d F Y') }}
                </div>
            </div>

            <p style="margin-top: 30px;">Pastikan Anda sudah berada di lokasi 15 menit sebelum waktu mulai untuk
                registrasi ulang.</p>

            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ url('/') }}" class="button">Kunjungi Website</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Leos Event. Seluruh hak cipta dilindungi.<br>
            Jangan membalas email otomatis ini.
        </div>
    </div>
</body>

</html>