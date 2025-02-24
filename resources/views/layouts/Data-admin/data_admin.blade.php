@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Admin</h5>
        </div>
    </div>

    <!-- Search Bar & Button in the same row -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
            Tambah Data Admin +
        </button>
        <input type="text" id="searchBox" class="form-control w-25" placeholder="Cari Nama Admin ...">
    </div>

    <!-- Modal Tambah Data Admin -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Tambah Data Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="adminName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="adminName" placeholder="Masukkan Nama Lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="adminEmail" placeholder="Masukkan Email">
                        </div>
                        <div class="mb-3">
                            <label for="adminGender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="adminGender">
                                <option selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Data Admin -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                            <td>{{ $admin->nama }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->jenis_kelamin }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm">Edit</a>
                                <a class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination di kiri bawah -->
            <div class="d-flex justify-content-end mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item {{ $admins->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $admins->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $admins->lastPage(); $i++)
                            <li class="page-item {{ $admins->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $admins->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
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
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "paging": false, // Karena Laravel sudah menangani pagination
            "searching": true,
            "info": false
        });

        $('#searchBox').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>

<style>
    .pagination .page-item {
        margin: 0 3px;
    }
    .pagination .page-link {
        color: #007bff;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
    }
    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@endsection
