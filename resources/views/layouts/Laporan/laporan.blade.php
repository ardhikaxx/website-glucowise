@extends('layouts.main')

@section('title', 'Laporan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">

    <!-- Include Select2 CSS (optional, if you want enhanced dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">
                    <i class="fa fa-clipboard-list me-1" style="color: #34B3A0;"></i>Laporan
                </h1>
            </div>
        </div>

        <!-- Tabel Riwayat Kesehatan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('rekammedis.search') }}" method="GET" class="search-form float-right">
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

                        <!-- Filter by Month Dropdown -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <!-- Month Filter Dropdown -->
                                    <div class="dropdown">
                                        <select id="monthFilter" class="form-control custom-month-dropdown" style="width: 200px;">
                                            <option value="">Filter by Month</option>
                                            @foreach ($months as $month)
                                                <option value="{{ $month->month }}" 
                                                    {{ request()->month == $month->month ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($month->month)->format('F') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <!-- Dropdown Icon -->
                                        <span class="dropdown-icon">
                                            <i class="fa fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
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
                                    @foreach ($riwayatKesehatan as $data)
                                        <tr class="table-row">
                                            <td>{{ $riwayatKesehatan->firstItem() + $loop->index }}</td>
                                            <td>{{ $data->dataKesehatan && $data->dataKesehatan->pengguna ? $data->dataKesehatan->pengguna->nama_lengkap : 'N/A' }}</td>
                                            <td>{{ $data->dataKesehatan ? $data->dataKesehatan->gula_darah : 'N/A' }}</td>
                                            <td>
                                                @if($data->dataKesehatan && $data->dataKesehatan->tanggal_pemeriksaan)
                                                    {{ \Carbon\Carbon::parse($data->dataKesehatan->tanggal_pemeriksaan)->format('d M Y') }}
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
                                                    <span class="badge badge-secondary p-2"><i class="fa fa-clock me-1"></i>Menunggu Proses</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('riwayatKesehatan.edit', $data->id_riwayat) }}" class="btn btn-warning">  <i class="fa fa-file-pdf me-1"></i> Export PDF                                                </a>
                                                <a href="{{ route('laporan.show', $data->dataKesehatan->nik) }}" class="btn btn-info"> <i class="fa fa-info-circle me-1"></i>Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $riwayatKesehatan->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $riwayatKesehatan->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    @foreach ($riwayatKesehatan->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $riwayatKesehatan->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ $riwayatKesehatan->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $riwayatKesehatan->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/Data-kesehatan/Data-kesehatan.js') }}"></script>

    <!-- Include Select2 JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        // Initialize Select2 for the month filter dropdown (optional)
        $(document).ready(function() {
            $('#monthFilter').select2({
                placeholder: 'Select a month',
                width: '100%'
            });
        });

        // Handle month filter change using AJAX
        document.getElementById('monthFilter').addEventListener('change', function() {
            var month = this.value;
            var url = window.location.href.split('?')[0];  // Get current URL without query string
            var newUrl = month ? url + '?month=' + month : url;  // Add month query param if selected
            window.location.href = newUrl;  // Reload page with the new URL
        });
    </script>

@endsection
