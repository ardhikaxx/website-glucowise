
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

    <style>
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

        .btn-primary {
            background-color: #199A8E; /* Ubah warna latar belakang tombol menjadi hijau */
            border-color: #199A8E; /* Ubah warna border tombol */
            color: white; /* Warna teks tombol */
            font-size: 16px;
            border-radius: 25px; /* Menambahkan sudut membulat pada tombol */
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #15867D; /* Warna tombol saat di-hover */
            border-color: #15867D; /* Warna border saat di-hover */
            transform: scale(1.1); /* Efek zoom in pada tombol */
        }

        .btn-primary:focus {
            outline: none; /* Menghilangkan outline saat tombol di-click */
        }
        /* Tombol Edit dan Hapus */
/* Tombol Edit dan Hapus */
.btn-rounded {
    padding: 8px 20px;
    font-size: 14px;
    border-radius: 50px; /* Membuat tombol bulat */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Efek transisi untuk hover dan transformasi */
    text-align: center;
    display: inline-block;
    cursor: pointer;
}

/* Tombol Edit */
.btn-primary {
    background-color: #199A8E;  /* Warna hijau */
    border-color: #199A8E;
    color: white;
}

.btn-primary:hover {
    background-color: #15867D;  /* Warna hijau lebih gelap saat hover */
    border-color: #15867D;
    transform: scale(1.1); /* Efek zoom */
}

/* Tombol Hapus */
.btn-danger {
    background-color: #FF5733; /* Warna merah terang */
    border-color: #FF5733;
    color: white;
}

.btn-danger:hover {
    background-color: #C0392B;  /* Warna merah lebih gelap saat hover */
    border-color: #C0392B;
    transform: scale(1.1);  /* Efek zoom */
}

/* Animasi saat tombol ditekan (sedikit mengecil) */
.btn:active {
    transform: scale(0.9); /* Efek tombol mengecil saat ditekan */
}

/* Tombol Fokus */
.btn:focus {
    outline: none;
}


        /* Styling untuk tombol Create dan Pencarian */
        .search-form .input-group {
            max-width: 300px;
            margin: 0 auto;
        }

        .search-form {
            float: right; /* Menjaga form berada di sebelah kanan */
            margin-top: 10px;
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
            background-color: #199A8E;
            color: white;
            border: none;
            border-radius: 0 25px 25px 0;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-search:hover {
            background-color: #15867D;
            transform: scale(1.1);
        }

        /* Styling untuk tabel */
        .page-title, .card-header {
            color: #199A8E;
            font-weight: 600;
        }

        /* Mengatur tinggi tabel dengan scroll */
        .table-wrapper {
            max-height: 300px; 
            overflow-y: auto;
            margin-top: 20px;
            background-color: #f8f9fa;
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

        /* Responsive styling for smaller screens */
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

            .btn-search {
                width: 100%;
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
        document.addEventListener("DOMContentLoaded", function() {
    let buttons = document.querySelectorAll('.btn-rounded');
    buttons.forEach(function(button) {
        setTimeout(function() {
            button.classList.add('visible');
        }, 200); // Memberikan delay untuk animasi muncul, misalnya 200ms
    });
});

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.page-wrapper').classList.add('loaded');
            let tableWrapper = document.querySelector('.table-wrapper');
            tableWrapper.classList.add('visible');
            let rows = document.querySelectorAll('.table tbody tr');
            rows.forEach(function(row, index) {
                setTimeout(function() {
                    row.classList.add('visible');
                }, index * 200);
            });
        });
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
            // Jika dikonfirmasi, kirimkan form untuk menghapus
            event.target.closest('form').submit(); // Mengirim form untuk melakukan penghapusan
        }
    });
}

    </script>
@endsection
