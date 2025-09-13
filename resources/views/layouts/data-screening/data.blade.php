@extends('layouts.main')

@section('title', 'Manajemen Screening')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;"><i
                        class="fa fa-file-medical-alt me-3" style="color: #34B3A0;"></i>Manajemen Screening</h1>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card visible">
                    <div class="card-body">
                        <h4>Data Screening Pertanyaan</h4>
                        <a href="{{ route('screening.create') }}" class="btn btn-primary float-left mt-2">
                            <i class="fa fa-plus-circle me-2"></i>Tambah Pertanyaan Screening
                        </a>
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
                                    @if ($dataScreening->count() > 0)
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
                                                    <div class="d-flex flex-column justify-content-center gap-2">
                                                        <a href="{{ route('screening.edit', $data->id_pertanyaan) }}"
                                                            class="btn btn-primary btn-rounded mb-2">
                                                            <i class="fas fa-edit me-1"></i>Edit
                                                        </a>

                                                        <form
                                                            action="{{ route('screening.destroy', $data->id_pertanyaan) }}"
                                                            method="POST" class="delete-form"
                                                            style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-rounded"
                                                                onclick="confirmDelete(event)">
                                                                <i class="fas fa-trash-alt me-1"></i>Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="no-data-message">
                                                    <i class="fa fa-question-circle fa-3x mb-3" style="color: #34B3A0;"></i>
                                                    <h4 style="color: #34B3A0;">Tidak Ada Data Pertanyaan Screening</h4>
                                                    <p>Belum ada data pertanyaan screening yang tersedia.</p>
                                                    <a href="{{ route('screening.create') }}" class="btn btn-primary mt-2">
                                                        <i class="fa fa-plus-circle me-1"></i>Tambah Pertanyaan
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if ($dataScreening->count() > 0)
                            <div class="pagination-container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item {{ $dataScreening->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $dataScreening->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        @foreach ($dataScreening->links()->elements[0] as $page => $url)
                                            <li
                                                class="page-item {{ $dataScreening->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                        <li class="page-item {{ $dataScreening->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $dataScreening->nextPageUrl() }}"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tesScreeningData->count() > 0)
                                        @foreach ($tesScreeningData as $tes)
                                            <tr class="table-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $tes->pengguna->nama_lengkap }}</td>
                                                <td>
                                                    @if ($tes->tanggal_screening)
                                                        {{ \Carbon\Carbon::parse($tes->tanggal_screening)->locale('id')->translatedFormat('d F Y') }}
                                                    @else
                                                        Tanggal tidak tersedia
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (is_null($tes->skor_risiko) || $tes->skor_risiko == 0)
                                                        Coba Check Detail Dulu
                                                    @else
                                                        {{ $tes->skor_risiko }}
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('screening.show', $tes->id_screening) }}"
                                                        class="btn btn-primary btn-rounded"><i
                                                            class="fa fa-info-circle me-1"></i>Detail
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="no-data-message">
                                                    <i class="fa fa-clipboard-list fa-3x mb-3" style="color: #34B3A0;"></i>
                                                    <h4 style="color: #34B3A0;">Tidak Ada Data Screening Tes</h4>
                                                    <p>Belum ada data hasil screening dari pengguna.</p>
                                                    <p class="small text-muted">Data akan muncul setelah pengguna melakukan
                                                        tes screening.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination for TesScreening Table - Hanya tampilkan jika ada data -->
                        @if ($tesScreeningData->count() > 0)
                            <div class="pagination-container">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <li class="page-item {{ $tesScreeningData->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $tesScreeningData->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        @foreach ($tesScreeningData->links()->elements[0] as $page => $url)
                                            <li
                                                class="page-item {{ $tesScreeningData->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                        <li class="page-item {{ $tesScreeningData->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $tesScreeningData->nextPageUrl() }}"
                                                aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>


    <style>
        .pagination {
            text-decoration: none;
            color: white;
            display: flex;
            flex-wrap: wrap;
            /* biar bisa turun ke baris berikutnya */
            justify-content: center;
            /* biar selalu rata tengah */
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .page-item {
            margin: 3px;
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

        /* Hover & active */
        .page-link:hover,
        .page-item.active .page-link {
            text-decoration: none;
            color: white;
            background-color: #15867D;
            border-color: #15867D;
            transform: scale(1.05);
        }

        /* Disabled */
        .page-item.disabled .page-link {
            background-color: #e0e0e0;
            color: #888;
            border-color: #e0e0e0;
            cursor: not-allowed;
            transform: none;
        }

        /* Responsive: tampilan mobile */
        @media (max-width: 576px) {
            .page-link {
                padding: 6px 12px;
                font-size: 14px;
            }

            .pagination {
                justify-content: center;
            }
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

        .table th,
        .table td {
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

        /* Styling untuk pesan tidak ada data */
        .no-data-message {
            padding: 40px 20px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .no-data-message h4 {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .no-data-message p {
            color: #6c757d;
            margin-bottom: 15px;
        }

        .no-data-message .small {
            font-size: 0.875rem;
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

            .table th,
            .table td {
                padding: 10px;
                font-size: 12px;
            }

            .page-link {
                font-size: 14px;
            }
        }

        .custom-swal-popup {
            border-radius: 15px;
        }

        .custom-confirm-btn {
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 500 !important;
            background-color: #34B3A0 !important;
            border: none !important;
        }

        .custom-cancel-btn {
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 500 !important;
            background-color: #6c757d !important;
            border: none !important;
        }

        .swal2-icon.swal2-warning {
            border-color: #ffc107 !important;
            color: #ffc107 !important;
        }
    </style>

    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Mencegah form dikirim langsung

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                iconColor: '#ffc107',
                showCancelButton: true,
                confirmButtonColor: '#34B3A0',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i> Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
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
