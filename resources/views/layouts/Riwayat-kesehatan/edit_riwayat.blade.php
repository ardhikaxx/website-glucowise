@extends('layouts.main')

@section('title', 'Edit Riwayat Kesehatan')

@section('content')
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Edit Riwayat Kesehatan - Nomor KK: {{ $data->nomor_kk }}</h1>
        </div>
    </div>

    <!-- Form Edit Riwayat Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" action="{{ route('riwayatKesehatan.update', $data->nomor_kk) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="ibu">Nama Ibu</label>
                            <input type="text" name="ibu" class="form-control" value="{{ $data->ibu }}" required>
                        </div>

                        <div class="form-group">
                            <label for="ayah">Nama Ayah</label>
                            <input type="text" name="ayah" class="form-control" value="{{ $data->ayah }}" required>
                        </div>

                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ $data->telepon }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Riwayat</label>
                            <textarea name="deskripsi" class="form-control" rows="3" required>{{ $data->deskripsi }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="dokter">Dokter</label>
                            <input type="text" name="dokter" class="form-control" value="{{ $data->dokter }}" required>
                        </div>

                        <div class="form-group">
                            <label for="diagnosa">Diagnosa</label>
                            <input type="text" name="diagnosa" class="form-control" value="{{ $data->diagnosa }}" required>
                        </div>

                        <div class="form-group">
                            <label for="pengobatan">Pengobatan</label>
                            <input type="text" name="pengobatan" class="form-control" value="{{ $data->pengobatan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="catatan_lainnya">Catatan Lainnya</label>
                            <input type="text" name="catatan_lainnya" class="form-control" value="{{ $data->catatan_lainnya }}">
                        </div>

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
