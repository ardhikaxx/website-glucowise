@extends('layouts.main')

@section('title', 'Data Pengguna')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;"><i class="fa fa-user me-1" style="color: #34B3A0;"></i>Data Pengguna</h1>
        </div>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="row">
        <div class="col-md-12">
            <div class="card visible">
                <div class="card-body">
                    <!-- Form Pencarian dan Filter Jenis Kelamin di sebelah kanan -->
                    <form action="{{ route('dataPengguna.search') }}" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-input" placeholder="Cari Data Pengguna" value="{{ request()->search }}">

                            <!-- Filter Jenis Kelamin -->
                            <select name="jenis_kelamin" class="form-control search-input">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ request()->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ request()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>

                            <button type="submit" class="btn btn-search">
                                <i class="fa fa-search me-1"></i>Cari
                            </button>
                        </div>
                    </form>

                    <!-- Pesan jika data tidak ditemukan -->
                    @if ($message)
                        <div class="alert alert-warning" role="alert">
                            {{ $message }}
                        </div>
                    @endif

                    <!-- Tabel -->
                    <div class="table-wrapper">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nomor Identitas</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataPengguna as $data)
                                    <tr class="table-row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_lengkap ?? 'Tidak Ada Data' }}</td>
                                        <td>{{ $data->nik ?? 'Tidak Ada Data' }}</td>
                                        <td>{{ $data->email ?? 'Tidak Ada Data' }}</td>
                                        <td>{{ $data->nomor_telepon ?? 'Tidak Ada Data' }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('dataPengguna.show', $data->nik) }}"><i class="fa fa-info-circle me-1"></i>Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada data pengguna yang tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>                            
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item {{ $dataPengguna->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $dataPengguna->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @foreach ($dataPengguna->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $dataPengguna->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li class="page-item {{ $dataPengguna->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $dataPengguna->nextPageUrl() }}" aria-label="Next">
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
