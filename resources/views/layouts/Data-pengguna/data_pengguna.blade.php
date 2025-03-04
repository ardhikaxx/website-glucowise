@extends('layouts.main')

@section('title', 'Data Pengguna')



@section('content')
<link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Data Pengguna</h1>
            </div>
        </div>
        
        <!-- Tabel Data Pengguna -->
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('dataPengguna.search') }}" method="GET" class="search-form float-right">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control search-input" placeholder="Search" value="{{ request()->search }}">
                                        <button type="submit" class="btn btn-search">
                                            <i class="fa fa-search"></i> Search
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
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Nomor Telepon</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPengguna->take(10) as $data)
                                        <tr class="table-row">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->full_name }}</td>
                                            <td>{{ $data->username }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->phone_number }}</td>
                                            <td>{{ $data->status }}</td>
                                            <td>
                                                <a class="btn btn-warning" href="{{ route('dataPengguna.edit', $data->id) }}">Edit</a>
                                                <a class="btn btn-info" href="{{ route('dataPengguna.show', $data->id) }}">Action</a>
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
