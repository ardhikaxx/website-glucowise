
@extends('layouts.main')

@section('title', 'Edukasi')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Edukasi</h1>
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


        <!-- Tabel Data Edukasi -->
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="{{ route('edukasi.create') }}" class="btn btn-primary float-left">
                                    <i class="fa fa-plus-circle"></i> Create
                                </a>                                    
                                <form action="{{ route('edukasi.index') }}" method="GET" class="search-form float-right">
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
                                        <th>Judul</th>
                                        <th>Isi</th>
                                        <th>Foto</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataEdukasi as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->judul }}</td>
                                            <td>{{ Str::limit($data->isi, 30) }}...</td>  <!-- Menampilkan hanya sebagian isi -->
                                            <td>
                                                <!-- Menampilkan Gambar -->
                                                <img src="{{ asset('storage/images/edukasi/' . $data->gambar) }}" alt="Foto Edukasi" style="width: 50px; height: auto; border-radius: 8px;">
                                            </td>
                                            <td>
                                                <a href="{{ route('edukasi.edit', $data->id) }}" class="btn btn-primary btn-rounded">Edit</a>
                                                
                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('edukasi.destroy', $data->id) }}" method="POST" class="delete-form" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-rounded" onclick="confirmDelete(event)">Hapus</button>
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
                                    <li class="page-item {{ $dataEdukasi->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $dataEdukasi->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <!-- Loop through the pagination links -->
                                    @foreach ($dataEdukasi->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $dataEdukasi->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Next Button -->
                                    <li class="page-item {{ $dataEdukasi->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $dataEdukasi->nextPageUrl() }}" aria-label="Next">
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

  
@endsection
