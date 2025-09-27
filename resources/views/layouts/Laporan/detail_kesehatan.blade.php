@extends('layouts.main')

@section('title', 'Detail Riwayat Kesehatan')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/detail-kesehatan.css') }}">

    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row mb-5">
            <div class="col-md-12">
                <h1 class="page-title text-center" style="color: #34B3A0; font-weight: 700;">
                    Detail Laporan Rekam Medis - NIK: {{ $latestDataPerMonth->first()->nik }}
                </h1>
                <!-- Tombol Print PDF -->
            </div>
        </div>

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

                            <!-- Kolom Kanan (Umur) -->
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

                        <!-- Tabel Data Kesehatan Lainnya -->
                        <h4 class="mt-4 text-center" style="color: #34B3A0; font-weight: 700;">Detail Laporan Rekam Medis</h4>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pemeriksaan</th>
                                    <th>Tinggi Badan</th>
                                    <th>Berat Badan</th>
                                    <th>Gula Darah</th>
                                    <th>Lingkar Pinggang</th>
                                    <th>Tensi Darah</th>
                                    <th>Kategori Resiko</th>
                                    <th>Catatan</th>
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
                                        <td>{{ $data->tinggi_badan }}</td>
                                        <td>{{ $data->berat_badan }}</td>
                                        <td>{{ $data->gula_darah }}</td>
                                        <td>{{ $data->lingkar_pinggang }}</td>
                                        <td>{{ $data->tensi_darah }}</td>
                                        <td>{{ $data->kategori_risiko }}</td>
                                        <td>{{ $data->catatan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Button Kembali -->
                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/Data-kesehatan/detail-kesehatan.js') }}"></script>

@endsection
