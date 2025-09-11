@extends('layouts.main')

@section('title', 'Edit Riwayat Kesehatan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/riwayat-kesehatan/edit-riwayat.css') }}">
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
                        <div class="form-group mb-3">
                            <label for="kategori_risiko">Status Risiko</label>
                            <select name="kategori_risiko" class="form-control" required>
                                <option value="Rendah" {{ $data->kategori_risiko == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="Sedang" {{ $data->kategori_risiko == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ $data->kategori_risiko == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>

                        <!-- Input untuk Catatan -->
                        <div class="form-group mb-3">
                            <label for="catatan">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3">{{ $data->catatan }}</textarea>
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="button" id="submitBtn" class="btn btn-primary me-2">Simpan</button>
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
<script src="{{ asset('js/riwayat-kesehatan/edit-riwayat.js') }}"></script>
@endsection
