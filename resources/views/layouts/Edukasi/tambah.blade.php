@extends('layouts.main')

@section('title', 'Tambah Edukasi')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edukasi/tambah-edukasi.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center">Tambah Edukasi Baru</h1>
            </div>
        </div>

        <!-- Form Tambah Edukasi -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('edukasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Kolom Kiri: Judul dan Deskripsi -->
                                <div class="col-md-6">
                                    <!-- Judul -->
                                    <div class="form-group">
                                        <label for="judul" class="form-label">Judul Edukasi</label>
                                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan Judul Edukasi" required>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="form-group">
                                        <label for="deskripsi" class="form-label">Deskripsi Edukasi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" placeholder="Masukkan Deskripsi Edukasi" required></textarea>
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Upload Gambar dan Preview -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gambar" class="form-label">Upload Gambar</label>
                                        <input type="file" name="gambar" id="gambar" class="form-control-file" accept="image/*" onchange="previewImage(event)" required>
                                        <small id="image-warning" class="form-text text-danger" style="display:none;">Ukuran gambar tidak boleh lebih dari 2MB.</small>
                                    </div>

                                    <!-- Preview Gambar -->
                                    <div class="form-group">
                                        <div id="image-container">
                                            <img id="preview" src="" alt="Image Preview" class="img-fluid" style="display: none; width: 100%; border-radius: 8px; border: 2px solid #ddd;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="form-group text-center">
                                <button type="submit" id="submit-button" class="btn btn-primary" disabled>Simpan</button>
                                <a href="{{ route('edukasi.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/edukasi/tambah-edukasi.js') }}"></script>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            const submitButton = document.getElementById('submit-button');
            const warningMessage = document.getElementById('image-warning');
            const preview = document.getElementById('preview');

            if (file) {
                // Check if file size exceeds 2MB
                if (file.size > maxSize) {
                    submitButton.disabled = true;
                    warningMessage.style.display = 'block';
                } else {
                    submitButton.disabled = false;
                    warningMessage.style.display = 'none';

                    // Show image preview
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
@endsection
