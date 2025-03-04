@extends('layouts.main')

@section('title', 'Riwayat Kesehatan')


@section('content')
<link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Riwayat Kesehatan</h1> <!-- Mengubah dari Data Kesehatan menjadi Riwayat Kesehatan -->
            </div>
        </div>
        
        <!-- Tabel Riwayat Kesehatan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('riwayatKesehatan.search') }}" method="GET" class="search-form float-right"> <!-- Mengubah route search sesuai dengan model baru -->
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control search-input" placeholder="Cari Riwayat Kesehatan" value="{{ request()->search }}">
                                        <button type="submit" class="btn btn-search">
                                            <i class="fa fa-search"></i>Cari
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
                                        <th>Nomor KK</th>
                                        <th>Nama Ibu</th>
                                        <th>Nama Ayah</th>
                                        <th>Telepon</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatKesehatan->take(10) as $data)  <!-- Mengubah dari dataKesehatan menjadi riwayatKesehatan -->
                                        <tr class="table-row">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nomor_kk }}</td>
                                            <td>{{ $data->ibu }}</td>
                                            <td>{{ $data->ayah }}</td>
                                            <td>{{ $data->telepon }}</td>
                                            <td>
                                                <a href="{{ route('riwayatKesehatan.edit', $data->nomor_kk) }}" class="btn btn-warning">Edit</a <!-- Mengubah route sesuai dengan model baru -->
                                                <a class="btn btn-info" href="{{ route('riwayatKesehatan.show', $data->nomor_kk) }}">Action</a> <!-- Mengubah route sesuai dengan model baru -->
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
                                    <li class="page-item {{ $riwayatKesehatan->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $riwayatKesehatan->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <!-- Loop through the pagination links -->
                                    @foreach ($riwayatKesehatan->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $riwayatKesehatan->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Next Button -->
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
    <!-- Custom styles and script remain unchanged -->
 

