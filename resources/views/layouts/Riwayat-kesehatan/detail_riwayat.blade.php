@extends('layouts.main')

@section('title', 'Detail Riwayat Kesehatan')

@section('content')
<style>
    /* Styling untuk halaman detail riwayat kesehatan */
    .page-title {
        color: #34B3A0;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .card {
        border-radius: 15px;
        margin-top: 30px;
    }

    .card-body {
        background-color: #ffffff;
        padding: 30px;
    }

    /* Table Styling */
    .table {
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #34B3A0;
        color: white;
        font-weight: bold;
    }

    .table td {
        background-color: #ffffff;
        color: #333;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: #e6f7f3;
    }

    /* Button Styling */
    .btn-animated {
        background-color: #34B3A0;
        color: white;
        border-radius: 25px;
        padding: 12px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn-animated:hover {
        background-color: #199A8E;
        transform: scale(1.05);
    }

    /* Table Row Animation */
    .table-row {
        background-color: #199A8E;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.5s ease;
    }

    .table-row.visible {
        background-color: #199A8E;
        opacity: 1;
        transform: translateY(0);
    }

    /* Button Animations */
    .btn-animated {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .btn-animated.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Skor Risiko Animation */
    .skor-risiko {
        opacity: 0;
        transform: scale(0.5);
        transition: opacity 1s ease, transform 1s ease;
    }

    .skor-risiko.visible {
        opacity: 1;
        transform: scale(1);
    }
</style>
<link rel="stylesheet" href="{{ asset('css/riwayat-kesehatan/detail-riwayat.css') }}">

<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title text-center" style="color: #34B3A0; font-weight: 700;">Detail Rekam Medis - NIK: {{ $latestDataPerMonth->first()->dataKesehatan->nik }}</h1>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <!-- Tabel Detail Riwayat Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri (NIK, Nama Lengkap, Alamat) -->
                        <div class="col-md-8">
                            <table class="table">
                                <tbody>
                                    <tr class="table-row">
                                        <th>NIK</th>
                                        <td>{{ $latestDataPerMonth->first()->dataKesehatan->nik }}</td>
                                    </tr>
                                    <tr class="table-row">
                                        <th>Nama Lengkap</th>
                                        <td>{{ $latestDataPerMonth->first()->dataKesehatan->pengguna->nama_lengkap }}</td>
                                    </tr>
                                    <tr class="table-row">
                                        <th>Alamat Lengkap</th>
                                        <td>{{ $latestDataPerMonth->first()->dataKesehatan->pengguna->alamat_lengkap }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Kolom Kanan (Kategori Risiko dan Umur) -->
                        <div class="col-md-4">
                            <table class="table">
                                <tbody>
                                    <tr class="table-row">
                                        <th>Umur</th>
                                    </tr>
                                    <tr class="table-row">
                                        <td class="text-center" style="font-size: 50px; font-weight: bold; color: #34B3A0;">
                                            {{ $umur }} <!-- Menampilkan Umur -->
                                        </td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tabel Data Riwayat Kesehatan -->
                    <h4 class="mt-4 text-center" style="color: #34B3A0; font-weight: 700;">Riwayat Kesehatan</h4>
                    <!-- Menambahkan table-responsive agar tabel menjadi responsif -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pemeriksaan</th>
                                    <th>Gula Darah</th>
                                    <th>Status Risiko</th>
                                    <th>Catatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $counter = 1; // Initialize a counter for automatic numbering
                                @endphp
                                @foreach ($latestDataPerMonth as $index => $data)
                                    <tr class="table-row">
                                        <td>{{ $counter++ }}</td> <!-- Automatically increment the counter --> 
                                        <td>{{ $data->dataKesehatan->tanggal_pemeriksaan }}</td> <!-- Tanggal Pemeriksaan -->
                                        <td>{{ $data->dataKesehatan->gula_darah }}</td> <!-- Gula Darah -->
                                        <td>
                                            @if ($data->kategori_risiko == 'Rendah')
                                                <span class="badge badge-success p-2">Rendah</span>
                                            @elseif ($data->kategori_risiko == 'Sedang')
                                                <span class="badge badge-warning p-2">Sedang</span>
                                            @elseif ($data->kategori_risiko == 'Tinggi')
                                                <span class="badge badge-danger p-2">Tinggi</span>
                                            @else
                                                <span class="badge badge-secondary p-2">Menunggu Respon</span>
                                            @endif
                                        </td>
                                        <td>{{ $data->catatan }}</td> <!-- Display catatan (notes) -->
                                        <td>
                                            <!-- Action Buttons -->
                                            <a href="{{ route('riwayatKesehatan.edit', $data->id_riwayat) }}" class="btn btn-primary btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Button Kembali -->
                    <a href="{{ route('riwayatKesehatan.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/riwayat-kesehatan/detail-riwayat.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Animasi untuk tabel dan tombol
        let rows = document.querySelectorAll('.table-row');
        rows.forEach(function(row, index) {
            setTimeout(function() {
                row.classList.add('visible');
            }, index * 200);
        });

        let button = document.querySelector('.btn-animated');
        setTimeout(function() {
            button.classList.add('visible');
        }, 1000);
    });
</script>
@endsection