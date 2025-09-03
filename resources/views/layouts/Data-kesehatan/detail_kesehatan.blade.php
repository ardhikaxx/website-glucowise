@extends('layouts.main')

@section('title', 'Detail Riwayat Kesehatan')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/detail-kesehatan.css') }}">

    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center" style="color: #34B3A0; font-weight: 700;">Detail Data Kesehatan - NIK:
                    {{ $latestDataPerMonth->first()->nik }}</h1>
            </div>
        </div>
        @if (session('success'))
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
                                            <td>{{ $latestDataPerMonth->first()->nik }}</td>
                                        </tr>
                                        <tr class="table-row">
                                            <th>Nama Lengkap</th>
                                            <td>{{ $latestDataPerMonth->first()->pengguna->nama_lengkap }}</td>
                                        </tr>
                                        <tr class="table-row">
                                            <th>Alamat Lengkap</th>
                                            <td>{{ $latestDataPerMonth->first()->pengguna->alamat_lengkap }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-4">
                                <table class="table">
                                    <tbody>
                                        <tr class="table-row">
                                            <th>Umur</th>
                                        </tr>
                                        <tr class="table-row">
                                            <td class="text-center d-flex justify-content-center align-items-center gap-2">
                                                <span
                                                    style="font-size: 50px; font-weight: bold; color: #34B3A0;">{{ $umur }}</span>
                                                <span class="text-sm"
                                                    style="font-weight: bold; color: #34B3A0;">Tahun</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <h4 class="mt-4 text-center" style="color: #34B3A0; font-weight: 700;">Detail Kesehatan</h4>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pemeriksaan</th>
                                    <th>Riwayat Diabetes Keluarga</th>
                                    <th>Tinggi Badan</th>
                                    <th>Berat Badan</th>
                                    <th>Gula Darah</th>
                                    <th>Lingkar Pinggang</th>
                                    <th>Tensi Darah</th>
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
                                        <td>
                                            @if ($data->tanggal_pemeriksaan)
                                                {{ \Carbon\Carbon::parse($data->tanggal_pemeriksaan)->locale('id')->translatedFormat('d F Y') }}
                                            @else
                                                Tanggal tidak tersedia
                                            @endif
                                        </td>
                                        <td>{{ $data->riwayat_keluarga_diabetes }}</td>
                                        <td>{{ $data->tinggi_badan }}</td>
                                        <td>{{ $data->berat_badan }}</td>
                                        <td>{{ $data->gula_darah }}</td>
                                        <td>{{ $data->lingkar_pinggang }}</td>
                                        <td>{{ $data->tensi_darah }}</td>
                                        <!-- Edit Button -->
                                        <td><a href="{{ route('dataKesehatan.edit', ['nik' => $data->nik, 'tanggal_pemeriksaan' => $data->tanggal_pemeriksaan]) }}"
                                                class="btn btn-primary">Edit</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Button Kembali -->
                        <a href="{{ route('dataKesehatan.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/Data-kesehatan/detail-kesehatan.js') }}"></script>

@endsection

<style>
    /* Styling untuk halaman detail kesehatan */
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
        background-color: #F0F8FF;
        padding: 30px;
    }

    /* Table Styling */
    .table {
        background-color: #34B3A0;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #34B3A0;
        color: white;
        font-weight: bold;
    }

    .table td {
        background-color: #f9f9f9;
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
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
