@extends('layouts.main')

@section('title', 'Laporan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">
                    <i class="fa fa-clipboard-list me-3" style="color: #34B3A0;"></i>Laporan Rekam Medis
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('rekammedis.search') }}" method="GET"
                                    class="search-form float-right">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control search-input"
                                            placeholder="Cari Data Kesehatan" value="{{ request()->search }}">
                                        <button type="submit" class="btn btn-search">
                                            <i class="fa fa-search me-1"></i>Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="dropdown">
                                        <select id="monthFilter" class="form-control custom-month-dropdown"
                                            style="width: 200px;">
                                            <option value="">Filter Bulan</option>
                                            @foreach ($months as $month)
                                                <option value="{{ $month->month }}"
                                                    {{ request()->month == $month->month ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($month->month)->locale('id')->translatedFormat('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="dropdown-icon">
                                            <i class="fa fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Gula Darah(mg/dl)</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($riwayatKesehatan->count() > 0)
                                        @foreach ($riwayatKesehatan as $data)
                                            <tr class="table-row">
                                                <td>{{ $riwayatKesehatan->firstItem() + $loop->index }}</td>
                                                <td>{{ $data->dataKesehatan && $data->dataKesehatan->pengguna ? $data->dataKesehatan->pengguna->nama_lengkap : 'N/A' }}
                                                </td>
                                                <td>{{ $data->dataKesehatan ? $data->dataKesehatan->gula_darah : 'N/A' }}
                                                    mg/dl</td>
                                                <td>
                                                    @if ($data->dataKesehatan && $data->dataKesehatan->tanggal_pemeriksaan)
                                                        {{ \Carbon\Carbon::parse($data->dataKesehatan->tanggal_pemeriksaan)->locale('id')->translatedFormat('d F Y') }}
                                                    @else
                                                        Tanggal tidak tersedia
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->kategori_risiko == 'Rendah')
                                                        <span class="badge badge-success p-2">Rendah</span>
                                                    @elseif ($data->kategori_risiko == 'Sedang')
                                                        <span class="badge badge-warning p-2">Sedang</span>
                                                    @elseif ($data->kategori_risiko == 'Tinggi')
                                                        <span class="badge badge-danger p-2">Tinggi</span>
                                                    @else
                                                        <span class="badge badge-secondary p-2"><i
                                                                class="fa fa-clock me-1"></i>Menunggu Proses</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center gap-2">
                                                        <a href="{{ route('laporan.printPdf', $data->dataKesehatan->nik) }}"
                                                            class="btn btn-warning" target="_blank"> <i
                                                                class="fa fa-file-pdf me-1"></i> Export PDF</a>
                                                        <a href="{{ route('laporan.show', $data->dataKesehatan->nik) }}"
                                                            class="btn btn-info"> <i
                                                                class="fa fa-info-circle me-1"></i>Detail</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="no-data-message">
                                                    <i class="fa fa-file-medical-alt fa-3x mb-3"
                                                        style="color: #34B3A0;"></i>
                                                    <h4 style="color: #34B3A0;">Tidak Ada Data Laporan</h4>
                                                    @if (request()->search || request()->month)
                                                        <p>
                                                            @if (request()->search)
                                                                Pencarian untuk "<strong>{{ request()->search }}</strong>"
                                                            @endif
                                                            @if (request()->search && request()->month)
                                                                dan
                                                            @endif
                                                            @if (request()->month)
                                                                filter bulan
                                                                <strong>{{ \Carbon\Carbon::create()->month(request()->month)->format('F') }}</strong>
                                                            @endif
                                                            tidak ditemukan.
                                                        </p>
                                                        <a href="{{ route('rekammedis.search') }}"
                                                            class="btn btn-primary mt-2">
                                                            <i class="fa fa-arrow-left me-1"></i>Kembali ke Semua Data
                                                        </a>
                                                    @else
                                                        <p>Belum ada data laporan yang tersedia dalam sistem.</p>
                                                        <p class="small text-muted">Data laporan akan muncul setelah
                                                            pengguna melakukan pemeriksaan kesehatan dan data diproses.</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if ($riwayatKesehatan->count() > 0)
                            <div class="pagination-container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item {{ $riwayatKesehatan->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $riwayatKesehatan->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        @foreach ($riwayatKesehatan->links()->elements[0] as $page => $url)
                                            <li
                                                class="page-item {{ $riwayatKesehatan->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <li class="page-item {{ $riwayatKesehatan->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $riwayatKesehatan->nextPageUrl() }}"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/Data-kesehatan/Data-kesehatan.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#monthFilter').select2({
                placeholder: 'Select a month',
                width: '100%'
            });
        });

        document.getElementById('monthFilter').addEventListener('change', function() {
            var month = this.value;
            var url = window.location.href.split('?')[0];
            var newUrl = month ? url + '?month=' + month : url;
            window.location.href = newUrl;
        });
    </script>

    <style>
        .custom-month-dropdown option:hover {
            background-color: #199A8E;
            color: #fff;
        }

        .custom-month-dropdown option:checked {
            background-color: #199A8E;
            color: #fff;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #199A8E;
            color: #fff;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #199A8E;
            color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #199A8E;
            font-weight: bold;
        }

        .no-data-message {
            padding: 40px 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .no-data-message h4 {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .no-data-message p {
            color: #6c757d;
            margin-bottom: 15px;
        }

        .no-data-message .small {
            font-size: 0.875rem;
        }
    </style>

@endsection
