@extends('layouts.main')

@section('title', 'Data Admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/data-admin.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;"><i class="fa fa-user-shield me-3" style="color: #34B3A0;"></i>Data Admin</h1>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(request()->search)
            <div class="alert alert-info">
                Menampilkan hasil pencarian untuk: <strong>{{ request()->search }}</strong>
            </div>
        @endif

        <!-- Tabel Data Admin -->
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="{{ route('admin.create') }}" class="btn btn-primary float-left">
                                    <i class="fa fa-plus-circle"></i> Tambah Admin
                                </a>                                    
                                <form action="{{ route('admin.index') }}" method="GET" class="search-form float-right">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control search-input" placeholder="Cari Nama Admin" value="{{ request()->search }}">
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
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $index => $admin)
                                        <tr>
                                            <td>{{ ($admins->currentPage() - 1) * $admins->perPage() + $loop->iteration }}</td>
                                            <td>{{ $admin->nama_lengkap }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->jenis_kelamin }}</td>
                                            <td>
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('admin.edit', $admin->id_admin) }}" class="btn btn-primary btn-rounded"><i class="fa fa-edit me-1"></i>Edit</a>

                                            
                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('admin.destroy', $admin->id_admin) }}" method="POST" class="delete-form" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-rounded" onclick="confirmDelete(event)"><i class="fa fa-trash-alt me-1"></i>Hapus</button>
                                                </form>
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
                                    <li class="page-item {{ $admins->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $admins->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <!-- Loop through the pagination links -->
                                    @foreach ($admins->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $admins->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Next Button -->
                                    <li class="page-item {{ $admins->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $admins->nextPageUrl() }}" aria-label="Next">
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
    <script src="{{ asset('js/admin/data-admin.js') }}"></script>
@endsection
