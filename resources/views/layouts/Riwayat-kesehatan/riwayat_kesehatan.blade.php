@extends('layouts.main')

@section('title', 'Riwayat Kesehatan')

@section('content')
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
            <h1 class="page-title">Riwayat Kesehatan</h1>
        </div>
    </div>
     <!-- Menampilkan Flash Message -->
                    @if(session('success'))
                        <script>
                            Swal.fire({
                                title: 'Berhasil!',
                                text: "{{ session('success') }}",
                                icon: 'success',
                                confirmButtonColor: '#199A8E'
                            });
                        </script>
                    @endif


    <!-- Tabel Riwayat Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card visible">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="{{ route('riwayatKesehatan.search') }}" method="GET" class="search-form float-right">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control search-input" placeholder="Cari Riwayat Kesehatan" value="{{ request()->search }}">
                                    <button type="submit" class="btn btn-search">
                                        <i class="fa fa-search"></i> Cari
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
                                        <td>{{ $data->id_riwayat }}</td>
                                        <td>{{ $data->dataKesehatan && $data->dataKesehatan->pengguna ? $data->dataKesehatan->pengguna->nama_lengkap : 'N/A' }}</td>
                                        <td>{{ $data->dataKesehatan ? $data->dataKesehatan->gula_darah : 'N/A' }}</td>
                                        
                                        <td>{{ $data->dataKesehatan ? $data->dataKesehatan->tanggal_pemeriksaan : 'Tanggal tidak tersedia' }}</td>
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
                                        <td>
                                            <a href="{{ route('riwayatKesehatan.edit', $data->id_riwayat) }}" class="btn btn-warning">Edit</a>
                                            <a href="{{ route('riwayatKesehatan.show', $data->dataKesehatan->nik) }}" class="btn btn-info">Detail</a>
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
@endsection
