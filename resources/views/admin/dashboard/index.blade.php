@extends('admin.dashboard')

@section('admin')
    <style>
        /* ================= DASHBOARD GENERAL ================= */
        .dashboard-content {
            padding: 18px;
        }

        /* ================= HERO SECTION ================= */
        .dashboard-hero {
            background: linear-gradient(135deg, #0b3d2e 0%, #0f5132 35%, #146c43 75%, #198754 100%);
            border-radius: 16px;
            padding: 18px 28px;
            margin-bottom: 18px;
            position: relative;
            overflow: hidden;
            color: white;
            min-height: 100px;
            display: flex;
            align-items: center;
            box-shadow: 0 8px 24px rgba(15, 81, 50, .25);
        }

        .dashboard-hero::before {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            top: -60px;
            right: -40px;
        }

        .dashboard-hero::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            bottom: -40px;
            left: -20px;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .hero-subtitle {
            font-size: 12px;
            opacity: .9;
            line-height: 1.4;
            max-width: 450px;
        }

        .hero-icon {
            font-size: 42px;
            opacity: .12;
        }

        /* ================= METRIC CARDS ================= */
        .metric-card {
            padding: 14px;
            border-radius: 16px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            transition: .35s;
            min-height: 110px;
            height: 100%;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .04);
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(15, 23, 42, .08);
        }

        .metric-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            border-radius: 10px 0 0 10px;
        }

        /* SINKRONISASI WARNA CARD */
        .metric-primary::before { background: #2563eb; }
        .metric-primary .metric-icon { color: #2563eb; }

        .metric-success::before { background: #10b981; }
        .metric-success .metric-icon { color: #10b981; }

        .metric-warning::before { background: #f59e0b; }
        .metric-warning .metric-icon { color: #f59e0b; }

        .metric-danger::before { background: #ef4444; }
        .metric-danger .metric-icon { color: #ef4444; }

        .metric-primary, .metric-success, .metric-warning, .metric-danger {
            background: #fff;
        }

        .metric-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .metric-label {
            font-size: 10px;
            font-weight: 600;
            color: #94a3b8;
            letter-spacing: .5px;
        }

        .metric-value {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 4px;
        }

        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .metric-meta {
            font-size: 11px;
            color: #64748b;
        }

        /* ================= FILTER FORM STYLING ================= */
        .filter-select {
            font-size: 13px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 5px 10px;
            background-color: #f8fafc;
            color: #334155;
            font-weight: 600;
            cursor: pointer;
            outline: none;
        }
        .filter-select:focus {
            border-color: #10b981;
        }

        /* ================= RESPONSIVE DESIGN ================= */
        @media(max-width:768px) {
            .hero-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .hero-icon {
                display: none;
            }
        }

        /* ================= DARK MODE PARAMETERS ================= */
        [data-theme="dark"] .metric-card,
        [data-theme="dark"] .chart-card {
            background: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, .05) !important;
        }
        [data-theme="dark"] .metric-value,
        [data-theme="dark"] h6 {
            color: white !important;
        }
        [data-theme="dark"] .metric-icon,
        [data-theme="dark"] .filter-select {
            background: rgba(255, 255, 255, .05) !important;
            border-color: rgba(255, 255, 255, .05) !important;
            color: white !important;
        }
    </style>

    <div class="dashboard-content">

        <div class="dashboard-hero">
            <div class="hero-content">
                <div>
                    <h1 class="hero-title">Selamat Datang Admin 👋</h1>
                    <p class="hero-subtitle">
                        Sistem Informasi Layanan Publik dan Monitoring Percakapan Chatbot WhatsApp (SILAPU)
                    </p>
                </div>
                <div class="hero-icon">
                    <i class="bi bi-robot"></i>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-2">
            <div class="col">
                <div class="metric-card metric-danger">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">LAYANAN</div>
                            <div class="metric-value">{{ $totallayanan ?? 0 }}</div>
                        </div>
                        <div class="metric-icon">
                            <i class="bi bi-grid"></i>
                        </div>
                    </div>
                    <div class="metric-meta">Total layanan aktif</div>
                </div>
            </div>

            <div class="col">
                <div class="metric-card metric-warning">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">FAQ</div>
                            <div class="metric-value">{{ $totalFaq ?? 0 }}</div>
                        </div>
                        <div class="metric-icon">
                            <i class="bi bi-question-circle"></i>
                        </div>
                    </div>
                    <div class="metric-meta">Total FAQ tersedia</div>
                </div>
            </div>

            <div class="col">
                <div class="metric-card metric-success">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">PERCAKAPAN</div>
                            <div class="metric-value">{{ $totalPesan ?? 0 }}</div>
                        </div>
                        <div class="metric-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                    </div>
                    <div class="metric-meta">Total percakapan chatbot</div>
                </div>
            </div>

            <div class="col">
                <div class="metric-card metric-primary">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">PENGGUNA</div>
                            <div class="metric-value">{{ $totalUsers ?? 0 }}</div>
                        </div>
                        <div class="metric-icon">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="metric-meta">Total warga/pengguna terdaftar</div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-2">

            <div class="col-lg-8">
                <div class="card p-3 chart-card" style="border-radius: 16px; border: 1px solid #e2e8f0; background: #fff;">

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-3">
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Tren Aktivitas Chatbot</h6>
                            <small class="text-muted" style="font-size: 11px;">Grafik harian dalam bulan terpilih</small>
                        </div>

                        <form id="filterForm" method="GET" action="{{ url()->current() }}" class="d-flex gap-2">
                            <select name="month" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $selectedMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>

                            <select name="year" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div style="height: 280px; position: relative;">
                        <canvas id="chatbotTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-3 chart-card" style="border-radius: 16px; border: 1px solid #e2e8f0; background: #fff;">
                    <h6 class="mb-3 fw-bold text-dark">Proporsi Fitur Pelayanan</h6>
                    <div style="height: 280px; position: relative;" class="d-flex align-items-center justify-content-center">
                        <canvas id="featureDistributionChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // --- 1. TREN PERCAKAPAN (LINE CHART PER BULAN) ---
            const ctxTrend = document.getElementById('chatbotTrendChart').getContext('2d');
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!}, // Berisi angka tanggal 01 sampai 30/31
                    datasets: [{
                        label: 'Pesan Masuk',
                        data: {!! json_encode($chartChats) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#10b981'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5] },
                            ticks: { precision: 0 }
                        },
                        x: {
                            grid: { display: false },
                            title: {
                                display: true,
                                text: 'Tanggal',
                                font: { size: 10, weight: 'bold' }
                            }
                        }
                    }
                }
            });

            // --- 2. PROPORSI FITUR (DOUGHNUT CHART) ---
            const ctxFeature = document.getElementById('featureDistributionChart').getContext('2d');
            new Chart(ctxFeature, {
                type: 'doughnut',
                data: {
                    labels: ['Layanan', 'FAQ'],
                    datasets: [{
                        data: [{{ $totallayanan }}, {{ $totalFaq }}],
                        backgroundColor: ['#ef4444', '#f59e0b'],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 15, font: { size: 11, weight: '600' } }
                        }
                    },
                    cutout: '72%'
                }
            });
        });
    </script>
@endsection
