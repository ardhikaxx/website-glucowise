@extends('layouts.main')

@section('title', 'Data Kesehatan')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">

    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;"><i
                        class="fa fa-notes-medical me-3" style="color: #34B3A0;"></i>Data Kesehatan</h1>
            </div>
        </div>

        <!-- Tabel Data Kesehatan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('dataKesehatan.search') }}" method="GET"
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

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nomor Telepon</th>
                                        <th>Umur</th>
                                        <th>Gula Darah (mg/dl)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataKesehatan->count() > 0)
                                        @foreach ($dataKesehatan as $data)
                                            <tr class="table-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->nama_lengkap }}</td> 
                                                <td>{{ $data->nomor_telepon }}</td>
                                                <td>{{ $data->umur }}</td> 
                                                <td>{{ $data->gula_darah }}</td>
                                                <td>
                                                    <a class="btn btn-info"
                                                        href="{{ route('dataKesehatan.show', $data->nik) }}"><i
                                                            class="fa fa-info-circle me-1"></i>Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="no-data-message">
                                                    <i class="fa fa-heartbeat fa-3x mb-3" style="color: #34B3A0;"></i>
                                                    <h4 style="color: #34B3A0;">Tidak Ada Data Kesehatan</h4>
                                                    @if (request()->search)
                                                        <p>Pencarian untuk "<strong>{{ request()->search }}</strong>" tidak
                                                            ditemukan.</p>
                                                        <a href="{{ route('dataKesehatan.index') }}"
                                                            class="btn btn-primary mt-2">
                                                            <i class="fa fa-arrow-left me-1"></i>Kembali ke Semua Data
                                                        </a>
                                                    @else
                                                        <p>Belum ada data kesehatan yang tersedia dalam sistem.</p>
                                                        <p class="small text-muted">Data kesehatan akan muncul setelah
                                                            pengguna melakukan pemeriksaan kesehatan.</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination - Hanya tampilkan jika ada data -->
                        @if ($dataKesehatan->count() > 0)
                            <div class="pagination-container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <!-- Previous Button -->
                                        <li class="page-item {{ $dataKesehatan->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $dataKesehatan->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>

                                        <!-- Loop through the pagination links -->
                                        @foreach ($dataKesehatan->links()->elements[0] as $page => $url)
                                            <li
                                                class="page-item {{ $dataKesehatan->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Next Button -->
                                        <li class="page-item {{ $dataKesehatan->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $dataKesehatan->nextPageUrl() }}"
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

@endsection
