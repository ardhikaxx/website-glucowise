@extends('layouts.main')

@section('title', 'Data Screening')

@section('content')
<link rel="stylesheet" href="{{ asset('css/data-screening/data-screening.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Data Screening</h1>
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

        <!-- Tabel Data Screening -->
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex justify-content-between">
                                <a href="{{ route('screening.create') }}" class="btn btn-primary btn-rounded">
                                    <i class="fa fa-plus-circle"></i> Create
                                </a>

                                <!-- Form Pencarian di sebelah kanan -->
                                <form action="{{ route('screening.index') }}" method="GET" class="search-form">
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
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataScreening as $data)
                                        <tr class="table-row">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->pertanyaan }}</td>
                                            <td>
                                                @foreach ($data->jawabanScreening as $jawaban)
                                                    <p>{{ $jawaban->jawaban }}</p>
                                                @endforeach
                                            </td>
                                            
                                            <td>
                                                <a href="{{ route('screening.edit', $data->id_pertanyaan) }}" class="btn btn-primary btn-rounded">Edit</a>
                                                
                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('screening.destroy', $data->id_pertanyaan) }}" method="POST" class="delete-form" style="display: inline-block;">
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
                                    <li class="page-item {{ $dataScreening->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $dataScreening->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <!-- Loop through the pagination links -->
                                    @foreach ($dataScreening->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $dataScreening->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Next Button -->
                                    <li class="page-item {{ $dataScreening->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $dataScreening->nextPageUrl() }}" aria-label="Next">
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
    <script src="{{ asset('js/data-screening/data-screening.js') }}"></script>
@endsection