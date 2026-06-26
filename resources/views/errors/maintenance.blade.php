<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - Sedang Dalam Pengembangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #ec4899;
            --bg: #0f172a;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0;
        }

        .maintenance-container {
            text-align: center;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }

        .bg-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, rgba(15, 23, 42, 0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
        }

        .icon-box {
            font-size: 5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite ease-in-out;
        }

        h1 {
            font-weight: 700;
            letter-spacing: -0.025em;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        p {
            color: #94a3b8;
            font-size: 1.25rem;
            max-width: 600px;
            margin: 0 auto 2.5rem;
        }

        .badge-status {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            border: 1px solid rgba(79, 70, 229, 0.2);
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .dot {
            width: 8px;
            height: 8px;
            background-color: var(--primary);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px var(--primary);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(0.95); }
        }

        @media (max-width: 768px) {
            h1 { font-size: 2.25rem; }
            p { font-size: 1rem; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    <div class="maintenance-container">
        <div class="badge-status">
            <span class="dot"></span>
            System Status: Updating
        </div>

        <div class="icon-box">
            <i class="bi bi-rocket-takeoff-fill"></i>
        </div>

        <h1>Under Development</h1>
        <p>Mohon maaf atas ketidaknyamanannya. Saat ini kami sedang melakukan pembaharuan besar untuk memberikan pengalaman terbaik untuk Anda. Silakan kembali lagi nanti!</p>

        <div class="mt-4">
            <a href="/" class="btn btn-outline-light px-4 py-2 rounded-pill">
                <i class="bi bi-arrow-clockwise me-2"></i>Segarkan Halaman
            </a>
        </div>
        
        <div class="mt-5 small text-muted">
            &copy; {{ date('Y') }} {{ $setting->nama_event ?? 'Event Management System' }}. All rights reserved.
        </div>
    </div>
</body>
</html>
