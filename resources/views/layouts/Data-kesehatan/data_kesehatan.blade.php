@extends('layouts.main')

@section('title', 'Data Kesehatan')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Data Kesehatan</h1>
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
                                        <input type="text" name="search" class="form-control search-input" placeholder="Search" value="{{ request()->search }}">
                                        <button type="submit" class="btn btn-search">
                                            <i class="fa fa-search"></i>Search
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
                                    @foreach ($dataKesehatan->take(10) as $data)  <!-- Menampilkan hanya 10 data pertama -->
                                        <tr class="table-row">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nomor_kk }}</td>
                                            <td>{{ $data->ibu }}</td>
                                            <td>{{ $data->ayah }}</td>
                                            <td>{{ $data->telepon }}</td>
                                            <td>
                                                <a class="btn btn-warning" href="{{ route('dataKesehatan.edit', $data->nomor_kk) }}">Edit</a>
                                                <a class="btn btn-info" href="{{ route('dataKesehatan.show', $data->nomor_kk) }}">Action</a>
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

    {{-- @push('styles')
    <link rel="stylesheet" href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/Data-kesehatan/Data-kesehatan.js') }}"></script>
@endpush --}}
    {{-- <style>
        .pagination-container {
            display: flex;
            justify-content: flex-end; /* Align to the right */
            margin-top: 20px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            padding: 8px 16px;
            background-color: #199A8E;
            color: white;
            border: 1px solid #199A8E;
            border-radius: 30px;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            cursor: pointer;
        }

        .page-link:hover,
        .page-item.active .page-link {
            background-color: #15867D;
            border-color: #15867D;
            transform: scale(1.1);
        }

        .page-link:focus {
            outline: none;
        }

        .page-item.disabled .page-link {
            background-color: #e0e0e0;
            color: #b0b0b0;
            border-color: #e0e0e0;
        }

        .page-item.active .page-link {
            background-color: #15867D;
            color: white;
            border: 1px solid #15867D;
        }

        /* Enhanced style for Previous and Next buttons */
        .page-item a {
            font-weight: bold;
        }

        .page-item a span {
            font-size: 18px;
        }

        .page-item a:hover {
            color: inherit;
            text-decoration: underline;
        }

        .search-form .input-group {
            max-width: 300px;
            margin: 0 auto;
        }

        .search-input {
            padding: 10px;
            border-radius: 25px 0 0 25px;
            font-size: 14px;
            border: 1px solid #199A8E;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #15867D;
            box-shadow: 0 0 10px rgba(25, 154, 142, 0.2);
        }

        .search-form {
            float: right; /* Menjaga form berada di sebelah kanan */
            margin-top: 10px;
        }

        .btn-search {
            background-color: #199A8E; /* Warna latar tombol */
            color: white; /* Warna teks tombol */
            border: none; /* Menghilangkan border default */
            border-radius: 0 25px 25px 0; /* Menambahkan rounded corner untuk tombol */
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-search:hover {
            background-color: #15867D; /* Warna saat tombol di-hover */
            transform: scale(1.1);
        }

        .btn-search:focus {
            outline: none; /* Menghilangkan outline saat tombol di-click */
        }

        /* Desain tabel */
        .page-title, .card-header {
            color: #199A8E;
            font-weight: 600;
        }

        /* Mengatur tinggi tabel dengan scroll */
        .table-wrapper {
            max-height: 300px; /* Ganti sesuai kebutuhan */
            overflow-y: auto;
            margin-top: 20px;
            background-color: #f8f9fa; /* Sesuaikan dengan warna latar belakang */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .table-wrapper.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Styling untuk tabel */
        .table th, .table td {
            padding: 12px;
            text-align: center;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #199A8E;
            color: white;
        }
        .table tbody tr {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .table tbody tr.visible {
            opacity: 1;
            transform: translateX(0);
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f6f9;
        }

        .table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Hover effect untuk tabel */
        .table tbody tr:hover {
            background-color: #e6f7f3;
        }

        /* Scroll styling */
        .table-wrapper::-webkit-scrollbar {
            width: 8px;
            display: block;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background-color: #199A8E;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background-color: #f2f6f9;
        }

        /* Tombol dengan animasi */
        .btn-warning, .btn-info {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 50px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-warning {
            background-color: #4DB6AC; /* Warna latar tombol Edit yang lebih terang */
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 14px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn-warning:hover {
            transform: scale(1.1);
            background-color: #e6b800;
        }

        .btn-info {
            background-color: #199A8E;
            color: white;
        }

        .btn-info:hover {
            transform: scale(1.1);
            background-color: #15867D;
        }

        /* Animasi untuk kartu */
        .card {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive styling for smaller screens */
        @media (max-width: 768px) {
            .table-wrapper {
                overflow-x: auto;
            }
            
            .search-form .input-group {
                width: 100%;
            }

            .pagination-container {
                justify-content: center; /* Align pagination to the center on small screens */
            }

            .btn-search {
                width: 100%; /* Make the search button full width */
            }

            .table th, .table td {
                padding: 10px;
                font-size: 12px; /* Reduce font size on smaller screens */
            }

            .page-link {
                font-size: 14px;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Menambahkan class 'loaded' untuk memulai animasi halaman
        document.querySelector('.page-wrapper').classList.add('loaded');

        // Menambahkan class 'visible' untuk tabel secara keseluruhan
        let tableWrapper = document.querySelector('.table-wrapper');
        tableWrapper.classList.add('visible');

        // Menambahkan class 'visible' pada setiap baris tabel secara dinamis
        let rows = document.querySelectorAll('.table tbody tr');
        rows.forEach(function(row, index) {
            setTimeout(function() {
                row.classList.add('visible');
            }, index * 200); // Delay untuk setiap baris tabel muncul, misalnya 200ms
        });

        // Menampilkan tombol dengan efek animasi
        let buttons = document.querySelectorAll('.btn-warning, .btn-info');
        buttons.forEach(function(button) {
            button.classList.add('visible');
        });

        // Menampilkan kartu (jika ada) dengan animasi
        let cards = document.querySelectorAll('.card');
        cards.forEach(function(card) {
            card.classList.add('visible');
        });
    });
    </script> --}}
@endsection
