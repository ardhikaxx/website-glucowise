@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
        </div>
    </div>
    
    <div class="row g-4">
        <!-- Card for Admin Count -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Jumlah Admin</h5>
                    <h2 class="display-3 text-primary">10</h2>
                </div>
            </div>
        </div>
        
        <!-- Card for User Count -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Jumlah Pengguna</h5>
                    <h2 class="display-3 text-success">10</h2>
                </div>
            </div>
        </div>

        <!-- Card for Patients Checked Today -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Jumlah Pasien yang Memeriksa Hari Ini</h5>
                    <h2 class="display-3 text-warning">5</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <!-- Section for Risk Graph (Diabetes) -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                        <h5 class="card-title fw-semibold">Grafik Risiko Diabetes</h5>
                        <select class="form-select w-auto">
                            <option value="1">Januari 2025</option>
                            <option value="2">Februari 2025</option>
                            <option value="3">Maret 2025</option>
                            <option value="4">April 2025</option>
                        </select>
                    </div>
                    <div id="risk-chart"></div>
                </div>
            </div>
        </div>

        <!-- Section for User Age Category (Large Circle) -->
        <div class="col-lg-4">
            <div class="card shadow-sm" style="height: 100%;">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold">Kategori Usia Pengguna</h5>
                    <!-- Large Circle for Age Category -->
                    <div id="age-category-chart" class="d-flex justify-content-center align-items-center" style="height: 100%;"></div>
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

<script>
// JavaScript for rendering charts
$(document).ready(function() {
    var ageCategoryOptions = {
        chart: {
            type: 'pie',
            height: '100%', // Set the height to match the Diabetes graph
        },
        series: [22, 33, 44],
        labels: ['18-25', '26-35', '36-45'],
        colors: ['#FFB85C', '#34B3A0', '#FF6161'],
    };
    var ageCategoryChart = new ApexCharts(document.querySelector("#age-category-chart"), ageCategoryOptions);
    ageCategoryChart.render();

    var riskOptions = {
        chart: {
            type: 'bar',
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
        },
        colors: ['#FFB85C', '#34B3A0', '#FF6161'],
    };
    var riskChart = new ApexCharts(document.querySelector("#risk-chart"), riskOptions);
    riskChart.render();
});
</script>

@endsection
