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
                    <h2 class="display-4 text-dark" style="font-weight: bold; font-size: 56px;">10</h2>
                </div>
            </div>
        </div>
        
        <!-- Card for User Count -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-3 p-3" style="background-color: #FFFBF0;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold fs-5 text-muted">Jumlah Pengguna</h5>
                    <h2 class="display-4 text-dark" style="font-weight: bold; font-size: 56px;">10</h2>
                </div>
            </div>
        </div>

        <!-- Card for Patients Checked Today -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm border-0 rounded-3 p-3" style="background-color: #FFFBF0;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold fs-5 text-muted">Jumlah Pasien Pemeriksaan</h5>
                    <h2 class="display-4 text-dark" style="font-weight: bold; font-size: 56px;">5</h2>
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
                        <h5 class="card-title fw-semibold text-muted" style="font-size: 20px;">Grafik Risiko Diabetes</h5>
                        <select class="form-select w-auto" style="font-size: 14px;">
                            <option value="1">Januari 2025</option>
                            <option value="2">Februari 2025</option>
                            <option value="3">Maret 2025</option>
                            <option value="4">April 2025</option>
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
                    <h5 class="card-title fw-semibold text-muted" style="font-size: 20px; color: #34B3A0;">Kategori Usia Pengguna</h5>
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
    $(document).ready(function() {
        var riskOptions = {
            chart: {
                type: 'bar',
                height: 300,
            },
            series: [{
                name: '2023',
                data: [50, 60, 70, 80],
            }, {
                name: '2024',
                data: [40, 50, 60, 70],
            }, {
                name: '2025',
                data: [60, 70, 80, 90],
            }],
            xaxis: {
                categories: ['January', 'February', 'March', 'April'],
                title: {
                    text: 'Bulan',
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
            colors: ['#FFB85C', '#34B3A0', '#FF6161'],
        };
        var riskChart = new ApexCharts(document.querySelector("#risk-chart"), riskOptions);
        riskChart.render();
    
        // Age Category Doughnut Chart Configuration
        const ageCategoryData = {
            labels: ['18-25', '26-35', '36-45'],
            datasets: [{
                data: [22, 33, 44],
                backgroundColor: ['#FFB85C', '#34B3A0', '#FF6161'],
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
                            label: function(tooltipItem) {
                                let total = 0;
                                tooltipItem.chart.data.datasets[0].data.forEach(function(data) {
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
                        formatter: function(value, ctx) {
                            let total = 0;
                            ctx.chart.data.datasets[0].data.forEach(function(data) {
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

        var ageCategoryChart = new Chart(document.getElementById('age-category-chart'), ageCategoryConfig);

    });
</script>

    

@endsection
