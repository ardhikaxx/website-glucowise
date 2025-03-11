@extends('layouts.main')

@section('title', 'Detail Riwayat Kesehatan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/riwayat-kesehatan/detail-riwayat.css') }}">
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Detail Riwayat Kesehatan - NIK: {{ $data->dataKesehatan->nik }}</h1>
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
                                <td>{{ $data->dataKesehatan->nik }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nama Lengkap</th>
                                <td>{{ $data->dataKesehatan->pengguna->nama_lengkap }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Tinggi Badan</th>
                                <td>{{ $data->dataKesehatan->tinggi_badan }} cm</td>
                            </tr>
                            <tr class="table-row">
                                <th>Berat Badan</th>
                                <td>{{ $data->dataKesehatan->berat_badan }} kg</td>
                            </tr>
                            <tr class="table-row">
                                <th>Gula Darah</th>
                                <td>{{ $data->dataKesehatan->gula_darah }} mg/dl</td>
                            </tr>
                            <tr class="table-row">
                                <th>Tekanan Darah</th>
                                <td>{{ $data->dataKesehatan->tensi_darah }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Status Risiko</th>
                                <td>
                                    @if ($data->kategori_risiko == 'Rendah')
                                        <span class="badge badge-success p-2">Rendah</span>
                                    @elseif ($data->kategori_risiko == 'Sedang')
                                        <span class="badge badge-warning p-2">Sedang</span>
                                    @elseif ($data->kategori_risiko == 'Tinggi')
                                        <span class="badge badge-danger p-2">Tinggi</span>
                                    @else
                                        <span class="badge badge-secondary p-2">Tidak Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="table-row">
                                <th>Catatan</th>
                                <td>{{ $data->catatan }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <a href="{{ route('riwayatKesehatan.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/riwayat-kesehatan/detail-riwayat.js') }}"></script>

@endsection
