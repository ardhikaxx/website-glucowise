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
                        <form action="{{ route('edukasi.store') }}" method="POST" enctype="multipart/form-data" id="edukasi-form">
                            @csrf
                            <div class="row">
                                <!-- Kolom Kiri: Judul, Deskripsi dan Kategori -->
                                <div class="col-md-6">
                                    <!-- Judul -->
                                    <div class="form-group">
                                        <label for="judul" class="form-label">Judul Edukasi</label>
                                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan Judul Edukasi" required>
                                        @error('judul')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="form-group">
                                        <label for="deskripsi" class="form-label">Deskripsi Edukasi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" placeholder="Masukkan Deskripsi Edukasi" required></textarea>
                                        @error('deskripsi')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Kategori -->
                                    <div class="form-group">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="Dasar Diabetes">Dasar Diabetes</option>
                                            <option value="Manajemen Diabetes">Manajemen Diabetes</option>
                                        </select>
                                        @error('kategori')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Upload Gambar dan Preview -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gambar" class="form-label">Upload Gambar</label>
                                        <input type="file" name="gambar" id="gambar" class="form-control-file" accept="image/*" onchange="previewImage(event)" required>
                                        <small id="image-warning" class="form-text text-danger" style="display:none;">Ukuran gambar tidak boleh lebih dari 2MB.</small>
                                        @error('gambar')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
                                <button type="submit" id="submit-button" class="btn btn-primary">Simpan</button>
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
        // Validasi ukuran gambar
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const warningElement = document.getElementById('image-warning');
            
            if (file && file.size > 2 * 1024 * 1024) { // 2MB
                warningElement.style.display = 'block';
                e.target.value = ''; // Clear the file input
                document.getElementById('preview').style.display = 'none';
            } else {
                warningElement.style.display = 'none';
            }
        });

        // Validasi form sebelum submit
        document.getElementById('edukasi-form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('gambar');
            const warningElement = document.getElementById('image-warning');
            
            if (fileInput.files.length > 0 && fileInput.files[0].size > 2 * 1024 * 1024) {
                e.preventDefault();
                warningElement.style.display = 'block';
                
                // SweetAlert untuk error
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Gambar Terlalu Besar',
                    text: 'Ukuran gambar tidak boleh lebih dari 2MB. Silakan pilih gambar lain.',
                    confirmButtonColor: '#34B3A0',
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                });
            }
        });

        // Fungsi preview gambar
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection