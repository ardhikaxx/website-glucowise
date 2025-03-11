@extends('layouts.main')

@section('title', 'Detail Riwayat Kesehatan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Data-kesehatan/detail-kesehatan.css') }}">
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Detail Riwayat Kesehatan - NIK: {{ $data->nik }}</h1>
        </div>
    </div>

    <!-- Tabel Detail Riwayat Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-animated">
                        <tbody>
                            <tr class="table-row">
                                <th>NIK</th>
                                <td>{{ $data->nik }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nama Lengkap</th>
                                <td>{{ $data->pengguna->nama_lengkap }}</td> <!-- Nama lengkap diambil dari relasi pengguna -->
                            </tr>
                            <tr class="table-row">
                                <th>Tanggal Pemeriksaan</th>
                                <td>{{ $data->tanggal_pemeriksaan }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Riwayat Keluarga Diabetes</th>
                                <td>{{ $data->riwayat_keluarga_diabetes }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Umur</th>
                                <td>{{ $data->umur }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Tinggi Badan</th>
                                <td>{{ $data->tinggi_badan }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Berat Badan</th>
                                <td>{{ $data->berat_badan }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Gula Darah</th>
                                <td>{{ $data->gula_darah }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Lingkar Pinggang</th>
                                <td>{{ $data->lingkar_pinggang }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Tensi Darah</th>
                                <td>{{ $data->tensi_darah }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <a href="{{ route('dataKesehatan.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/Data-kesehatan/detail-kesehatan.js') }}"></script>
@endsection
