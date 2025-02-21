@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Admin</h5>
                    <p class="card-text">Pantau dan kelola informasi admin secara efisien untuk memastikan operasional sistem tetap berjalan dengan lancar.</p>
                    <a href="#" class="btn btn-primary">Cek Data Admin</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Pengguna</h5>
                    <p class="card-text">Dapatkan insight mengenai pengguna, aktivitas mereka, dan statistik terkait untuk analisis yang lebih akurat.</p>
                    <a href="#" class="btn btn-primary">Cek Data Pegguna</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Kesehatan</h5>
                    <p class="card-text">Lihat data kesehatan yang relevan untuk memantau kondisi dan meningkatkan kualitas layanan.</p>
                    <a href="#" class="btn btn-primary">Cek Data Kesehatan</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                        <h5 class="card-title fw-semibold">Visualisasi Data</h5>
                        <select class="form-select w-auto">
                            <option value="1">Januari 2025</option>
                            <option value="2">Februari 2025</option>
                            <option value="3">Maret 2025</option>
                            <option value="4">April 2025</option>
                        </select>
                    </div>
                    <div id="chart"></div>
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

@endsection