@extends('layouts.main')

@section('title', 'Data Kesehatan')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">

<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Menampilkan Pesan jika Data Tidak Ditemukan -->
    @if(isset($message) && $message != '')
    <div class="alert alert-warning">
        {{ $message }}
    </div>
    @endif

    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;"><i class="fa fa-notes-medical me-1" style="color: #34B3A0;"></i>Data Kesehatan</h1>
        </div>
    </div>
    
    <!-- Tabel Data Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card visible">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="{{ route('dataKesehatan.search') }}" method="GET" class="search-form float-right">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control search-input" placeholder="Cari Data Kesehatan" value="{{ request()->search }}">
                                    <button type="submit" class="btn btn-search">
                                        <i class="fa fa-search me-1"></i>Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pemeriksaan</th>
                                    <th>Nama Lengkap</th>
                                    <th>Gula Darah (mg/dl)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKesehatan->take(10) as $data)
                                <tr class="table-row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                    <td>{{ $data->pengguna->nama_lengkap }}</td> <!-- Menampilkan Nama Lengkap Pengguna -->
                                    <td>{{ $data->gula_darah }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('dataKesehatan.edit', $data->nik) }}"><i class="fa fa-edit me-1"></i>Edit</a>
                                        <a class="btn btn-info" href="{{ route('dataKesehatan.show', $data->nik) }}"><i class="fa fa-info-circle me-1"></i></i>Detail</a>
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
                                <!-- Previous Button -->
                                <li class="page-item {{ $dataKesehatan->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $dataKesehatan->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                <!-- Loop through the pagination links -->
                                @foreach ($dataKesehatan->links()->elements[0] as $page => $url)
                                <li class="page-item {{ $dataKesehatan->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                <!-- Next Button -->
                                <li class="page-item {{ $dataKesehatan->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $dataKesehatan->nextPageUrl() }}" aria-label="Next">
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

@endsection
