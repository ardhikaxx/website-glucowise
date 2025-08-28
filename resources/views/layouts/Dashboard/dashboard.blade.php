@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @php
        $totalAll = $totalAdmins + $totalPengguna + $totalPemeriksaan;

        $percentAdmin = $totalAll > 0 ? ($totalAdmins / $totalAll) * 100 : 0;
        $percentPengguna = $totalAll > 0 ? ($totalPengguna / $totalAll) * 100 : 0;
        $percentPemeriksaan = $totalAll > 0 ? ($totalPemeriksaan / $totalAll) * 100 : 0;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Dashboard Title -->
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">
                    <i class="fa fa-chart-line me-1" style="color: #34B3A0;"></i> Dashboard
                </h1>
            </div>
        </div>

        <div class="row g-4">
            <!-- Card for Admin Count -->
            <div class="col-lg-4 col-md-6 grid-margin stretch-card">
                <div class="card border-0 shadow-l">
                    <div class="card-body d-flex justify-content-start align-items-center gap-3">
                        <div class="icon icon-box-primary bg-primary text-white p-3 rounded-3">
                            <span class="mdi mdi-shield-account mdi-36px"></span>
                        </div>
                        <div>
                            <h4 class="font-weight-normal mb-2 text-primary" style="font-weight: bold;">Data Admin</h4>
                            <h2 class="text-primary mb-0">{{ $totalAdmins }}</h2>
                        </div>
                    </div>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <!-- Card for User Count -->
            <div class="col-lg-4 col-md-6 grid-margin stretch-card">
                <div class="card border-0 shadow-l">
                    <div class="card-body d-flex justify-content-start align-items-center gap-3">
                        <div class="icon icon-box-danger bg-danger text-white p-3 rounded-3">
                            <span class="mdi mdi-account-circle mdi-36px"></span>
                        </div>
                        <div>
                            <h4 class="font-weight-normal mb-2 text-danger" style="font-weight: bold;">Data Pengguna</h4>
                            <h2 class="text-danger mb-0">{{ $totalPengguna }}</h2>
                        </div>
                    </div>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="60"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <!-- Card for Patients Checked Today -->
            <div class="col-lg-4 col-md-6 grid-margin stretch-card">
                <div class="card border-0 shadow-l">
                    <div class="card-body d-flex justify-content-start align-items-center gap-3">
                        <div class="icon icon-box-success bg-success text-white p-3 rounded-3">
                            <span class="mdi mdi-medical-bag mdi-36px"></span>
                        </div>
                        <div>
                            <h4 class="font-weight-normal mb-2 text-success" style="font-weight: bold">Data Pemeriksaan</h4>
                            <h2 class="text-success mb-0">{{ $totalPemeriksaan }}</h2>
                        </div>
                    </div>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <!-- Section for Risk Graph (Diabetes) -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-l border-0 rounded-lg">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title fw-semibold text-muted" style="font-size: 20px;">Grafik Risiko Diabetes
                            </h5>
                            <select class="form-select w-auto mt-2" style="font-size: 14px;" id="year-selector">
                                @foreach ($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Grafik Risiko -->
                        <div id="risk-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Table for Latest Pemeriksaan -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-l border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold text-muted" style="font-size: 20px;">Data Pemeriksaan Terkini</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Umur</th>
                                        <th>Gula Darah</th>
                                        <th>Kategori Risiko</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestPemeriksaan as $key => $pemeriksaan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $pemeriksaan->pengguna->nama_lengkap ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d M Y') }}
                                            </td>
                                            <td>{{ $pemeriksaan->umur }}</td>
                                            <td>{{ $pemeriksaan->gula_darah }} mg/dL</td>
                                            <td>
                                                @php
                                                    $risiko = $pemeriksaan->riwayatKesehatan->kategori_risiko ?? 'N/A';
                                                    $badgeClass = match ($risiko) {
                                                        'Rendah' => 'bg-success text-white',
                                                        'Sedang' => 'bg-warning text-dark',
                                                        'Tinggi' => 'bg-danger text-white',
                                                        default => 'bg-secondary text-white',
                                                    };
                                                    $icon = match ($risiko) {
                                                        'Rendah' => 'fa-shield-heart',
                                                        'Sedang' => 'fa-triangle-exclamation',
                                                        'Tinggi' => 'fa-circle-xmark',
                                                        default => 'fa-circle-question',
                                                    };
                                                @endphp
                                                <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2">
                                                    <i class="fa {{ $icon }} me-1"></i> {{ $risiko }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS untuk render Grafik Risiko Diabetes -->
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var chartData = @json($chartData);

            if (chartData) {
                var months = chartData['months'];
                var riskData = chartData['data'];
                var categories = chartData['categories'];

                var riskOptions = {
                    chart: {
                        type: 'line',
                        height: 300,
                        width:'100%'
                    },
                    series: [{
                            name: categories[0],
                            data: riskData['Rendah']
                        },
                        {
                            name: categories[1],
                            data: riskData['Sedang']
                        },
                        {
                            name: categories[2],
                            data: riskData['Tinggi']
                        }
                    ],
                    xaxis: {
                        categories: months,
                        title: {
                            text: 'Bulan',
                            style: {
                                fontSize: '16px',
                                fontWeight: 'bold',
                                color: '#333'
                            },
                            offsetY: 180
                        },
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: 'bold',
                                colors: '#333'
                            },
                            offsetY: 10,
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Risiko',
                            style: {
                                fontSize: '16px'
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 5,
                            columnWidth: '100%',
                            innerWidth: '50%',
                        }
                    },
                    colors: ['#FFB85C', '#34B3A0', '#FF6161'],
                };

                var riskChart = new ApexCharts(document.querySelector("#risk-chart"), riskOptions);
                riskChart.render();
            }

            $('#year-selector').change(function() {
                var selectedYear = $('#year-selector').val();
                window.location.href = "{{ url()->current() }}?year=" + selectedYear;
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
