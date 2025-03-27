@extends('layouts.main')

@section('title', 'Data Screening')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">Data Screening</h1>
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

        <!-- Tabel Data Screening Pertanyaan -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <h4>Data Screening Pertanyaan</h4>
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
                                                <a href="{{ route('screening.edit', $data->id_pertanyaan) }}" class="btn btn-primary btn-rounded">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                
                                                <form action="{{ route('screening.destroy', $data->id_pertanyaan) }}" method="POST" class="delete-form" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-rounded" onclick="confirmDelete(event)">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination for Pertanyaan Table -->
                        <div class="pagination-container">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $dataScreening->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $dataScreening->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    @foreach ($dataScreening->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $dataScreening->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
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

       
        <div class="row">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <h4>Data Screening Tes</h4>
                        <div class="table-wrapper">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Tanggal Screening</th>
                                        <th>Skor Risiko</th>
                                        <th>Kategori Risiko</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tesScreeningData as $tes)
                                        <tr class="table-row">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tes->pengguna->nama_lengkap }}</td> 
                                            <td>{{ $tes->tanggal_screening }}</td>
                                            <td>{{ $tes->skor_risiko }}</td>
                                            <td>{{ $tes->kategori_risiko }}</td>
                                            
                                            <td>
                                                <a href="{{ route('screening.edit', $data->id_pertanyaan) }}" class="btn btn-primary btn-rounded">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination for TesScreening Table -->
                        <div class="pagination-container">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $tesScreeningData->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $tesScreeningData->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    @foreach ($tesScreeningData->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $tesScreeningData->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                    <li class="page-item {{ $tesScreeningData->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $tesScreeningData->nextPageUrl() }}" aria-label="Next">
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
    

    <style>
        /* Animasi dan Pengaturan Tombol */
        .pagination-container {
            display: flex;
            justify-content: flex-end;
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

        .btn-primary,
        .btn-danger {
            background-color: #199A8E;
            border-color: #199A8E;
            color: white;
            font-size: 16px;
            border-radius: 25px;
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover,
        .btn-danger:hover {
            background-color: #15867D;
            border-color: #15867D;
            transform: scale(1.1);
        }

        .btn-search {
            background-color: #199A8E;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-search:hover {
            background-color: #15867D;
            transform: scale(1.1);
        }

        .search-form .input-group {
            width: 300px;
            transition: transform 0.5s ease;
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

        .table-wrapper {
            max-height: 300px;
            overflow-y: auto;
            margin-top: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .table-wrapper.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

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

        .table tbody tr:hover {
            background-color: #e6f7f3;
        }

        .table-row {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .table-row.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .table-wrapper {
                overflow-x: auto;
            }

            .search-form .input-group {
                width: 100%;
            }

            .pagination-container {
                justify-content: center;
            }

            .table th, .table td {
                padding: 10px;
                font-size: 12px;
            }

            .page-link {
                font-size: 14px;
            }
        }
    </style>

    <script>
        function confirmDelete(event) {
            event.preventDefault();  // Mencegah form dikirim langsung

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit(); // Mengirim form untuk menghapus
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let tableWrapper = document.querySelector('.table-wrapper');
            tableWrapper.classList.add('visible');
            let rows = document.querySelectorAll('.table tbody tr');
            rows.forEach(function(row, index) {
                setTimeout(function() {
                    row.classList.add('visible');
                }, index * 200);
            });
        });
    </script>
@endsection