@extends('layouts.main')

@section('title', 'Detail Data Kesehatan')

@section('content')
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Detail Data Kesehatan - Nomor KK: {{ $data->nomor_kk }}</h1>
        </div>
    </div>

    <!-- Tabel Detail Data Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-animated">
                        <tbody>
                            <tr class="table-row">
                                <th>Nomor KK</th>
                                <td>{{ $data->nomor_kk }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nama Ibu</th>
                                <td>{{ $data->ibu }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nama Ayah</th>
                                <td>{{ $data->ayah }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nomor Telepon</th>
                                <td>{{ $data->telepon }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nama Anak 1</th>
                                <td>{{ $data->anak_1 }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Nama Anak 2</th>
                                <td>{{ $data->anak_2 }}</td>
                            </tr>
                            <tr class="table-row">
                                <th>Alamat</th>
                                <td>{{ $data->alamat }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <a href="{{ route('dataKesehatan.index') }}" class="btn btn-secondary btn-animated">Kembali</a>
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

    /* Animasi untuk tombol */
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
        // Menambahkan kelas 'visible' untuk animasi pada card
        let card = document.querySelector('.card');
        card.classList.add('visible');

        // Menambahkan kelas 'visible' untuk baris tabel secara bertahap
        let rows = document.querySelectorAll('.table-row');
        rows.forEach(function(row, index) {
            setTimeout(function() {
                row.classList.add('visible');
            }, index * 200); // Delay untuk setiap baris tabel muncul
        });

        // Menambahkan animasi pada tombol Kembali
        let button = document.querySelector('.btn-animated');
        setTimeout(function() {
            button.classList.add('visible');
        }, 1000); // Delay untuk tombol muncul setelah tabel
    });
</script>
@endsection
