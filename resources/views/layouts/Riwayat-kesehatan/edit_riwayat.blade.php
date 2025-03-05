@extends('layouts.main')

@section('title', 'Edit Riwayat Kesehatan')

@section('content')
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Edit Riwayat Kesehatan - ID: {{ $data->id_riwayat }}</h1>
        </div>
    </div>

    <!-- Form Edit Riwayat Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" action="{{ route('riwayatKesehatan.update', $data->id_riwayat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Dropdown untuk Pilihan Risiko -->
                        <div class="form-group">
                            <label for="kategori_risiko">Status Risiko</label>
                            <select name="kategori_risiko" class="form-control" required>
                                <option value="Rendah" {{ $data->kategori_risiko == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="Sedang" {{ $data->kategori_risiko == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ $data->kategori_risiko == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>

                        <!-- Input untuk Catatan -->
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3">{{ $data->catatan }}</textarea>
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="button" id="submitBtn" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('riwayatKesehatan.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('submitBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang telah diedit akan disimpan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#199A8E',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editForm').submit(); // Submit the form if confirmed
            }
        });
    });
</script>

<style>
    .page-title {
        color: #199A8E;
        font-weight: 600;
        text-align: center;
        margin-bottom: 30px;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        color: #199A8E;
        font-weight: bold;
    }

    .form-control {
        border-radius: 25px;
        border: 1px solid #199A8E;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #15867D;
        box-shadow: 0 0 10px rgba(25, 154, 142, 0.2);
    }

    .btn-primary {
        background-color: #199A8E;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 20px;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #15867D;
        transform: scale(1.05);
    }

    .btn-secondary {
        background-color: #f2f6f9;
        color: #199A8E;
        border: 1px solid #199A8E;
        border-radius: 50px;
        padding: 10px 20px;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #e6f7f3;
        transform: scale(1.05);
    }
</style>
@endsection
