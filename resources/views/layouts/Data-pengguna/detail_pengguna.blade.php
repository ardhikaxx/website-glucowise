@extends('layouts.main')

@section('title', 'Detail Pengguna')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/Data-pengguna/detail-pengguna.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Detail Pengguna - Nomor Identitas: {{ $dataPengguna->nik }}</h1>
            </div>
        </div>

        <!-- Tabel Detail Pengguna -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-animated">
                            <tbody>
                                <tr class="table-row">
                                    <th>Nomor Identitas</th>
                                    <td>{{ $dataPengguna->nik ?? 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr class="table-row">
                                    <th>Email</th>
                                    <td>{{ $dataPengguna->email ?? 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr class="table-row">
                                    <th>Password</th>
                                    <td>Terenkripsi</td> <!-- Aman, tidak tampilkan password -->
                                </tr>
                                <tr class="table-row">
                                    <th>Nama Lengkap</th>
                                    <td>{{ $dataPengguna->nama_lengkap ?? 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr class="table-row">
                                    <th>Tempat Lahir</th>
                                    <td>{{ $dataPengguna->tempat_lahir ?? 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr class="table-row">
                                    <th>Tanggal Lahir</th>
                                    <td>
                                        @if ($dataPengguna->tanggal_lahir)
                                            {{ \Carbon\Carbon::parse($dataPengguna->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                                        @else
                                            Tidak Ada Data
                                        @endif
                                    </td>
                                </tr>
                                <tr class="table-row">
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $dataPengguna->jenis_kelamin ?? 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr class="table-row">
                                    <th>Alamat Lengkap</th>
                                    <td>{{ $dataPengguna->alamat_lengkap ?? 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr class="table-row">
                                    <th>Nomor Telepon</th>
                                    <td>{{ $dataPengguna->nomor_telepon ?? 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr class="table-row">
                                    <th>Nama Ibu Kandung</th>
                                    <td>{{ $dataPengguna->nama_ibu_kandung ?? 'Tidak Ada Data' }}</td>
                                </tr>
                            </tbody>

                        </table>

                        <a href="{{ route('dataPengguna.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Data-pengguna/detail-pengguna.js') }}"></script>
@endsection
