@extends('admin.dashboard')

@section('admin')
    <div class="page-wrapper">

        <div class="page-breadcrumb">
            <div class="row">

                <div class="col-12 col-md-7 align-self-center">

                    @php
                        $hour = now()->format('H');

                        $greeting = match (true) {
                            $hour >= 5 && $hour < 11 => 'Selamat Pagi',
                            $hour >= 11 && $hour < 15 => 'Selamat Siang',
                            $hour >= 15 && $hour < 18 => 'Selamat Sore',
                            default => 'Selamat Malam',
                        };
                    @endphp

                    <h3 class="page-title text-dark font-weight-medium mb-1">
                        {{ $greeting }}, {{ Auth::guard('admin')->user()->name }} 👋
                    </h3>

                </div>

            </div>
        </div>



        <div class="container-fluid">

            <!-- ================= CARD ================= -->

            <div class="row">

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">Users</h6>
                                    <h2 class="fw-bold text-dark mb-0">{{ $totalUsers }}</h2>
                                </div>

                                <div class="bg-primary text-white rounded-circle p-3">
                                    <i data-feather="users"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">TTE</h6>
                                    <h2 class="fw-bold text-dark mb-0">{{ $totalTte }}</h2>
                                </div>

                                <div class="bg-success text-white rounded-circle p-3">
                                    <i data-feather="file-text"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">IKASANDI</h6>
                                    <h2 class="fw-bold text-dark mb-0">{{ $totalIkasandi }}</h2>
                                </div>

                                <div class="bg-warning text-white rounded-circle p-3">
                                    <i data-feather="shield"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1">
                                    <h6 class="text-muted mb-1">Berita</h6>
                                    <h2 class="fw-bold text-dark mb-0">{{ $totalBerita }}</h2>
                                </div>

                                <div class="bg-danger text-white rounded-circle p-3">
                                    <i data-feather="file-text"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>



            <!-- ================= GRAFIK ================= -->

            <div class="row mt-4">

                <!-- ================= CHART TTE ================= -->

                <div class="col-lg-6">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <h4 class="card-title">
                                    Statistik Layanan TTE
                                </h4>

                                <select id="filterTahunTte" class="form-control w-auto">

                                    @for ($i = 2025; $i <= 2030; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor

                                </select>

                            </div>


                            <div class="d-flex align-items-center flex-wrap mb-3" style="gap:20px">

                                <div class="d-flex align-items-center">
                                    <span
                                        style="width:10px;height:10px;background:#008FFB;border-radius:50%;margin-right:6px"></span>
                                    <span style="font-size:13px">Permohonan</span>
                                </div>

                                <div class="d-flex align-items-center">
                                    <span
                                        style="width:10px;height:10px;background:#FFC107;border-radius:50%;margin-right:6px"></span>
                                    <span style="font-size:13px">Lupa Passphrase</span>
                                </div>

                                <div class="d-flex align-items-center">
                                    <span
                                        style="width:10px;height:10px;background:#28a745;border-radius:50%;margin-right:6px"></span>
                                    <span style="font-size:13px">Pembaharuan</span>
                                </div>

                            </div>

                            <div id="chartTte"></div>

                        </div>

                    </div>

                </div>



                <!-- ================= CHART BERITA ================= -->

                <div class="col-lg-6">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-3">

                                <h4 class="card-title">
                                    Statistik Berita Berklasifikasi
                                </h4>

                                <select id="filterTahunBerita" class="form-control w-auto">

                                    @for ($i = 2025; $i <= 2030; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor

                                </select>

                            </div>

                            <div id="chartBerita"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        let bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];


        /* ================= CHART TTE ================= */

        var chartTte = new ApexCharts(document.querySelector("#chartTte"), {

            chart: {
                type: 'bar',
                height: 260,
                toolbar: {
                    show: false
                }
            },

            dataLabels: {
                enabled: false
            },

            plotOptions: {
                bar: {
                    columnWidth: '35%',
                    borderRadius: 4
                }
            },

            series: [{
                    name: 'Permohonan',
                    data: []
                },
                {
                    name: 'Lupa Passphrase',
                    data: []
                },
                {
                    name: 'Pembaharuan',
                    data: []
                }
            ],

            colors: ['#008FFB', '#FFC107', '#28a745'],

            xaxis: {
                categories: bulan
            },

            yaxis: {
                min: 0,
                tickAmount: 2,
                forceNiceScale: false,
                labels: {
                    formatter: function(val) {
                        return Number.isInteger(val) ? val : '';
                    }
                }
            },

            legend: {
                position: 'top'
            }

        });

        chartTte.render();



        /* ================= CHART BERITA ================= */

        var chartBerita = new ApexCharts(document.querySelector("#chartBerita"), {

            chart: {
                type: 'area',
                height: 260,
                toolbar: {
                    show: false
                }
            },

            series: [{
                name: 'Jumlah Berita',
                data: []
            }],

            colors: ['#4e79a7'],

            stroke: {
                curve: 'smooth',
                width: 3
            },

            markers: {
                size: 5,
                strokeWidth: 2
            },

            dataLabels: {
                enabled: true,
                offsetY: -10
            },

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },

            xaxis: {
                categories: bulan
            },

            yaxis: {
                min: 0,
                title: {
                    text: 'Jumlah Berita'
                },
                labels: {
                    formatter: function(val) {
                        return Number.isInteger(val) ? val : '';
                    }
                }
            },

            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " berita";
                    }
                }
            }

        });

        chartBerita.render();



        /* ================= LOAD CHART TTE ================= */

        function loadChart(tahun) {

            fetch('/admin/chart-tte?tahun=' + tahun)

                .then(res => res.json())

                .then(data => {

                    let maxValue = Math.max(
                        ...data.baru,
                        ...data.lupa,
                        ...data.expired
                    );

                    if (maxValue == 0) {
                        maxValue = 1;
                    }

                    chartTte.updateOptions({
                        yaxis: {
                            min: 0,
                            max: maxValue,
                            tickAmount: maxValue
                        }
                    });

                    chartTte.updateSeries([{
                            name: 'Permohonan',
                            data: data.baru
                        },
                        {
                            name: 'Lupa Passphrase',
                            data: data.lupa
                        },
                        {
                            name: 'Pembaharuan',
                            data: data.expired
                        }
                    ]);

                });

        }



        /* ================= LOAD CHART BERITA ================= */

        function loadChartBerita(tahun) {

            fetch('/admin/chart-berita?tahun=' + tahun)

                .then(res => res.json())

                .then(data => {

                    let maxValue = Math.max(...data.berita);

                    if (maxValue == 0) {
                        maxValue = 1;
                    }

                    chartBerita.updateOptions({
                        yaxis: {
                            min: 0,
                            max: maxValue,
                            tickAmount: maxValue
                        }
                    });

                    chartBerita.updateSeries([{
                        name: 'Jumlah Berita',
                        data: data.berita
                    }]);

                });

        }



        let tahunSekarang = new Date().getFullYear();

        loadChart(tahunSekarang);
        loadChartBerita(tahunSekarang);



        document.getElementById('filterTahunTte')
            .addEventListener('change', function() {
                loadChart(this.value);
            });


        document.getElementById('filterTahunBerita')
            .addEventListener('change', function() {
                loadChartBerita(this.value);
            });
    </script>
@endpush
