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
                                <!-- Kolom Kiri: Judul dan Isi -->
                                <div class="col-md-6">
                                    <!-- Judul -->
                                    <div class="form-group">
                                        <label for="judul" class="form-label">Judul Edukasi</label>
                                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan Judul Edukasi" required>
                                    </div>

                                    <!-- Isi -->
                                    <div class="form-group">
                                        <label for="isi" class="form-label">Isi Edukasi</label>
                                        <textarea name="isi" id="isi" class="form-control" rows="6" placeholder="Masukkan Isi Edukasi" required></textarea>
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Upload Gambar dan Preview -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gambar" class="form-label">Upload Gambar</label>
                                        <input type="file" name="gambar" id="gambar" class="form-control-file" accept="image/*" onchange="previewImage(event)" required>
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('edukasi.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/edukasi/tambah-edukasi.js') }}"></script>
@endsection
