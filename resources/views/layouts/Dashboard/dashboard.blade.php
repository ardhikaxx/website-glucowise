@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Dashboard Title -->
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">Dashboard</h1>
            </div>
        </div>

        <div class="row g-4">
            <!-- Card for Admin Count with adjusted size and font -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-3 p-3" style="background-color: #FFFBF0;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-5 text-muted">Jumlah Admin</h5>
                        <h2 class="text-dark" style="font-weight: bold; font-size: 50px;">{{ $totalAdmins }}</h2>
                    </div>
                </div>
            </div>


            <!-- Card for User Count -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-3 p-3" style="background-color: #FFFBF0;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-5 text-muted">Jumlah Pengguna</h5>
                        <h2 class="text-dark" style="font-weight: bold; font-size: 50px;">{{ $totalPengguna }}</h2>
                    </div>
                </div>
            </div>

            <!-- Card for Patients Checked Today -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-3 p-3" style="background-color: #FFFBF0;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-5 text-muted">Jumlah Pasien Pemeriksaan</h5>
                        <h2 class="text-dark" style="font-weight: bold; font-size: 50px;">{{ $totalPemeriksaan }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Section for Risk Graph (Diabetes) -->
            <div class="col-lg-8 col-md-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title fw-semibold text-muted" style="font-size: 20px;">Grafik Risiko Diabetes
                            </h5>
                            <select class="form-select w-auto" style="font-size: 14px;">
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                        {{ \Carbon\Carbon::now()->year }} <!-- Tambahkan tahun yang sesuai -->
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div id="risk-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Section for User Age Category (Doughnut Chart) -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body text-center">
                        <!-- Single title with same color as Dashboard -->
                        <h5 class="card-title fw-semibold text-muted" style="font-size: 20px; color: #34B3A0;">Kategori Usia
                            Pengguna</h5>
                        <canvas id="age-category-chart" style="width: 100%; height: 500px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        // JavaScript for rendering the Diabetes Risk Chart
        $(document).ready(function () {
            // Retrieve the risk data passed from the controller
            var chartData = @json($chartData);

            // Check if chartData exists
            if (chartData) {
                var weeks = chartData['weeks'];
                var riskData = chartData['data'];
                var categories = chartData['categories'];

                // Configure the Diabetes Risk Chart
                var riskOptions = {
                    chart: {
                        type: 'bar',
                        height: 300,
                    },
                    series: [
                        {
                            name: categories[0], // 'Rendah'
                            data: riskData['Rendah'], // Week data for 'Rendah'
                        },
                        {
                            name: categories[1], // 'Sedang'
                            data: riskData['Sedang'], // Week data for 'Sedang'
                        },
                        {
                            name: categories[2], // 'Tinggi'
                            data: riskData['Tinggi'], // Week data for 'Tinggi'
                        }
                    ],
                    xaxis: {
                        categories: weeks, // Week 1, Week 2, Week 3, Week 4
                        title: {
                            text: '',
                            style: {
                                fontSize: '16px'
                            }
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
                            columnWidth: '50%',
                        }
                    },
                    colors: ['#FFB85C', '#34B3A0', '#FF6161'], // Colors for categories
                };

                // Render the risk chart
                var riskChart = new ApexCharts(document.querySelector("#risk-chart"), riskOptions);
                riskChart.render();
            } else {
                // If no data is available for the selected month
                $('#risk-chart').html('<p>No data available for the selected month.</p>');
            }

            // Age Category Doughnut Chart Configuration
            const ageData = @json($ageData);  // Get the dynamic age data passed from the controller
            const ageCategoryData = {
                labels: ['0-18', '19-35', '36-50', '51+'],  // Age categories
                datasets: [{
                    data: [
                        ageData['0-18'],
                        ageData['19-35'],
                        ageData['36-50'],
                        ageData['51+']
                    ], // Dynamic data from controller
                    backgroundColor: ['#FFB85C', '#34B3A0', '#FF6161', '#FF7F50'],
                    borderWidth: 0
                }]
            };

            const ageCategoryConfig = {
                type: 'doughnut',
                data: ageCategoryData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 16
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    let total = 0;
                                    tooltipItem.chart.data.datasets[0].data.forEach(function (data) {
                                        total += data;
                                    });
                                    let percentage = Math.round((tooltipItem.raw / total) * 100);
                                    let value = tooltipItem.raw;
                                    return tooltipItem.label + ': ' + value + ' (' + percentage + '%)'; // Show value and percentage in tooltip
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            color: '#000',
                            formatter: function (value, ctx) {
                                let total = 0;
                                ctx.chart.data.datasets[0].data.forEach(function (data) {
                                    total += data;
                                });
                                let percentage = Math.round((value / total) * 100);
                                return value + ' (' + percentage + '%)'; // Show value and percentage inside each slice
                            },
                            font: {
                                size: 24,
                                weight: 'bold'
                            },
                            anchor: 'center', // Center the label inside each slice
                            align: 'center',
                        },
                    }
                },
            };

            // Render the age category chart
            var ageCategoryChart = new Chart(document.getElementById('age-category-chart'), ageCategoryConfig);

            // Handle the month selection change
            $('select').change(function () {
                var selectedMonth = $(this).val();
                // Update the page with the selected month data (you can add AJAX to reload the chart)
                window.location.href = "/?month=" + selectedMonth;
            });
        });
    </script>
    <!-- Tambahkan Bootstrap JS di bagian bawah sebelum </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection