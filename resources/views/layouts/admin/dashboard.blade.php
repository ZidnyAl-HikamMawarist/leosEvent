@extends('layouts.admin.layout')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong></p>
            </div>
            <div class="text-end">
                <small class="text-muted">Last updated: {{ now()->format('d M Y, H:i') }}</small>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card stat-primary">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Total Lomba</p>
                            <h2 class="mb-0 fw-bold">{{ $totalLomba }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card stat-success">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Pendaftar</p>
                            <h2 class="mb-0 fw-bold">{{ $totalPendaftaran }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card stat-warning">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Galeri</p>
                            <h2 class="mb-0 fw-bold">{{ $totalGaleri }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-image-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card stat-info">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">Timeline Events</p>
                            <h2 class="mb-0 fw-bold">{{ $totalTimeline }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="row g-4">
        {{-- Chart Section --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i>Statistik Pendaftar Lomba
                        </h5>
                    </div>
                    <!-- Mengatur tinggi chart agar lebih nyaman dibaca saat lebar -->
                    <div style="position: relative; height: 185px;">
                        <canvas id="lombaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Grid (Recent Registrations & Top Lombas) --}}
    <div class="row mt-5 g-4">
        {{-- Recent Registrations --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-clock-history text-primary me-2"></i>Pendaftar Terbaru
                    </h5>
                    @if($recentRegistrations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">Email</th>
                                        <th class="border-0">Lomba</th>
                                        <th class="border-0">WhatsApp</th>
                                        <th class="border-0">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRegistrations as $reg)
                                        <tr>
                                            <td class="fw-semibold">{{ $reg->nama }}</td>
                                            <td class="text-muted small">{{ $reg->email }}</td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary">
                                                    {{ $reg->lomba->nama_lomba ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-muted small">{{ $reg->no_wa }}</td>
                                            <td class="text-muted small">
                                                {{ $reg->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            <small>Belum ada pendaftar</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Top Lombas Section --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-star-fill text-warning me-2"></i>Top Lomba
                    </h5>
                    @if($topLombas->count() > 0)
                        <div class="top-items-list">
                            @foreach($topLombas as $index => $lomba)
                                <div class="top-item d-flex align-items-center mb-3 pb-3 {{ $loop->last ? '' : 'border-bottom' }}">
                                    <div class="rank-badge me-3">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="mb-1 fw-semibold text-truncate" title="{{ $lomba->nama_lomba }}">
                                            {{ $lomba->nama_lomba }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-person-check me-1"></i>{{ $lomba->pendaftarans_count }} pendaftar
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $lomba->status == 'aktif' ? 'success' : 'secondary' }} ms-2">
                                        {{ ucfirst($lomba->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            <small>Belum ada lomba</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Stat Cards with Colors */
        .stat-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }

        .stat-card .stat-icon {
            font-size: 3rem;
            opacity: 0.15;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .stat-primary .stat-icon {
            color: #3b82f6;
        }

        .stat-success .stat-icon {
            color: #22c55e;
        }

        .stat-warning .stat-icon {
            color: #f59e0b;
        }

        .stat-info .stat-icon {
            color: #06b6d4;
        }

        .stat-primary:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .stat-success:hover {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
        }

        .stat-warning:hover {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .stat-info:hover {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white;
        }

        .stat-card:hover .text-muted {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        /* Top Items List */
        .rank-badge {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #1f2937;
            font-size: 14px;
        }

        .top-item:nth-child(1) .rank-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }

        .top-item:nth-child(2) .rank-badge {
            background: linear-gradient(135deg, #d1d5db 0%, #9ca3af 100%);
            color: white;
        }

        .top-item:nth-child(3) .rank-badge {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
        }

        /* Table Hover Effect */
        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let lombaChart;
        const ctx = document.getElementById('lombaChart').getContext('2d');

        // Data dari Laravel
        const labels = {!! json_encode($chartLabels) !!};
        const dataValues = {!! json_encode($chartData) !!};

        function renderChart() {
            if (lombaChart) {
                lombaChart.destroy();
            }

            lombaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: dataValues,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 2,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function (context) {
                                    return labels[context[0].dataIndex]; // Menampilkan nama lomba full saat di-hover
                                },
                                label: function (context) {
                                    return context.parsed.y + ' Peserta';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxRotation: 0, // Mencegah teks nyerong/miring
                                minRotation: 0,
                                font: {
                                    size: 11
                                },
                                callback: function (value) {
                                    let label = this.getLabelForValue(value);
                                    // Potong teks jika kepanjangan (di atas 12 huruf) dan tambah titik-titik
                                    if (label && label.length > 12) {
                                        return label.substring(0, 12) + '...';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        renderChart();
    </script>

@endsection