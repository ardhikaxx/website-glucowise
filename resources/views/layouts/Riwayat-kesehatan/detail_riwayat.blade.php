@extends('layouts.main')

@section('title', 'Detail Riwayat Kesehatan')

@section('content')
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

<style>
    /* Styling untuk Badge (Status Risiko) */
.badge {
    font-size: 14px;
    font-weight: bold;
    padding: 8px 16px;
    border-radius: 20px;
    text-align: center;
    display: inline-block;
}

.badge-success {
    background-color: #4CAF50; /* Hijau untuk 'Rendah' */
    color: white;
}

.badge-warning {
    background-color: #FFC107; /* Kuning untuk 'Sedang' */
    color: white;
}

.badge-danger {
    background-color: #F44336; /* Merah untuk 'Tinggi' */
    color: white;
}

.badge-secondary {
    background-color: #6C757D; /* Abu-abu untuk 'Tidak Tersedia' */
    color: white;
}

/* Tambahkan efek hover untuk Badge */
.badge:hover {
    transform: scale(1.05);
    transition: all 0.3s ease;
}

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
