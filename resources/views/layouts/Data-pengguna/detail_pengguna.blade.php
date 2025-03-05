@extends('layouts.main')

@section('title', 'Detail Pengguna')

@section('content')
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
                                <td>{{ $dataPengguna->nik }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Email</th>
                                <td>{{ $dataPengguna->email }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Password</th>
                                <td>{{ $dataPengguna->password }}</td> <!-- For security, you may not want to display password -->
                            </tr>
                            <tr class="table-row">
                                <th>Nama Lengkap</th>
                                <td>{{ $dataPengguna->nama_lengkap }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Tempat Lahir</th>
                                <td>{{ $dataPengguna->tempat_lahir }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Tanggal Lahir</th>
                                <td>{{ $dataPengguna->tanggal_lahir }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Jenis Kelamin</th>
                                <td>{{ $dataPengguna->jenis_kelamin }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Alamat Lengkap</th>
                                <td>{{ $dataPengguna->alamat_lengkap }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nomor Telepon</th>
                                <td>{{ $dataPengguna->nomor_telepon }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nama Ibu Kandung</th>
                                <td>{{ $dataPengguna->nama_ibu_kandung }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <a href="{{ route('dataPengguna.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-title {
        color: #199A8E;
        font-weight: 600;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .table th, .table td {
        padding: 15px;
        text-align: left;
        font-size: 15px;
    }

    .table th {
        background-color: #199A8E;
        color: white;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .table td {
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-row {
        border-radius: 10px;
        opacity: 0;
        transform: translateX(-20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .table-row.visible {
        opacity: 1;
        transform: translateX(0);
    }

    .btn-secondary {
        background-color: #f2f6f9;
        color: #199A8E;
        border: 1px solid #199A8E;
        border-radius: 50px;
        padding: 10px 20px;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #e6f7f3;
        transform: scale(1.05);
    }

    .btn-animated {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .btn-animated.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let card = document.querySelector('.card');
        card.classList.add('visible');

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
