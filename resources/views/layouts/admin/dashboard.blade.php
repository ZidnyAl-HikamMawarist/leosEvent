<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f4f6fb;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #0b1220, #0f172a);
            color: white;
            display: flex;
            flex-direction: column;
            transition: .3s;
        }

        .sidebar-header {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            white-space: nowrap;
        }

        .sidebar-menu {
            padding: 12px;
            flex: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            transition: .25s;
            font-size: 15px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #2563eb;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, .1);
        }

        /* ===== CONTENT ===== */
        .content {
            margin-left: 240px;
            padding: 32px;
            transition: .3s;
        }

        .dashboard-wrapper {
            max-width: 1100px;
            margin: auto;
        }

        .dashboard-card {
            border-radius: 18px;
            border: none;
            text-align: center;
            padding: 24px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .06);
            transition: .3s;
        }

        .dashboard-card:hover {
            transform: translateY(-6px);
        }

        .card-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        /* ===== RESPONSIVE (TETAP ADA TEKS) ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 160px;
                /* diperkecil tapi bukan icon only */
            }

            .sidebar-header {
                font-size: 13px;
                padding: 0 6px;
                text-align: center;
            }

            .sidebar-menu a {
                font-size: 13px;
                gap: 8px;
                padding: 10px;
            }

            .content {
                margin-left: 160px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="sidebar-header">
            ADMIN PANEL
        </div>

        <div class="sidebar-menu">
            <a class="active" href="{{ url('admin/dashboard') }}">🏠 Dashboard</a>
            <a href="{{ url('admin/carousel') }}">🎪 Carousel</a>
            <a href="{{ url('admin/timeline') }}">📅 Timeline</a>
            <a href="{{ url('admin/lomba') }}">🏆 Lomba</a>
            <a href="{{ url('admin/galeri') }}">🖼 Galeri</a>
            <a href="{{ url('admin/faq') }}">❓ FAQ</a>
            <a href="{{ url('admin/settings') }}">⚙ Settings</a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <div class="dashboard-wrapper">

            <h2 class="fw-bold">Dashboard Admin</h2>
            <p class="text-muted mb-4">Selamat datang di panel admin</p>

            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card">
                        <div class="card-icon">🏆</div>
                        <h6>Total Lomba</h6>
                        <h3>{{ $totalLomba }}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card">
                        <div class="card-icon">🖼</div>
                        <h6>Galeri</h6>
                        <h3>{{ $totalGaleri }}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card">
                        <div class="card-icon">❓</div>
                        <h6>FAQ</h6>
                        <h3>{{ $totalFaq }}</h3>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="dashboard-card">
                        <div class="card-icon">👤</div>
                        <h6>User</h6>
                        <h3>{{ $totalUser }}</h3>
                    </div>
                </div>
            </div>

            <div class="card mt-5 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Status Lomba</h5>
                    <canvas id="lombaChart" height="120"></canvas>
                </div>
            </div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('lombaChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Aktif', 'Nonaktif'],
                datasets: [{
                    label: 'Jumlah Lomba',
                    data: [{{ $lombaAktif }}, {{ $lombaNon }}],
                    backgroundColor: ['#22c55e', '#ef4444'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>