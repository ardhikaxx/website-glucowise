@extends('layouts.main')

@section('title', 'Edit Edukasi')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">Edit Edukasi</h1>
            </div>
        </div>

        <!-- Form Edit Edukasi -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('edukasi.update', $dataEdukasi->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Menggunakan metode PUT untuk update -->

                            <div class="row">
                                <!-- Kolom Kiri: Judul dan Isi -->
                                <div class="col-md-6">
                                    <!-- Judul -->
                                    <div class="form-group">
                                        <label for="judul" class="form-label">Judul Edukasi</label>
                                        <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $dataEdukasi->judul) }}" placeholder="Masukkan Judul Edukasi" required>
                                    </div>

                                    <!-- Isi -->
                                    <div class="form-group">
                                        <label for="isi" class="form-label">Isi Edukasi</label>
                                        <textarea name="isi" id="isi" class="form-control" rows="6" placeholder="Masukkan Isi Edukasi" required>{{ old('isi', $dataEdukasi->isi) }}</textarea>
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Upload Gambar dan Preview -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gambar" class="form-label">Upload Gambar</label>
                                        <input type="file" name="gambar" id="gambar" class="form-control-file" accept="image/*">
                                    </div>

                                    <!-- Preview Gambar -->
                                    <div class="form-group">
                                        <div id="image-container">
                                            <img id="preview" src="{{ asset('storage/images/edukasi/' . $dataEdukasi->gambar) }}" alt="Foto Edukasi" class="img-fluid" style="width: 100%; border-radius: 8px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('edukasi.create') }}"  class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Styling -->
    <style>
        .page-title {
            color: #199A8E;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
            background-color: #f9f9f9;
        }

        .form-label {
            font-size: 16px;
            color: #199A8E;
        }

        .form-control {
            font-size: 14px;
            border-radius: 8px;
            padding: 10px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #199A8E;
            box-shadow: 0 0 5px rgba(25, 154, 142, 0.2);
        }

        .btn-primary {
            background-color: #199A8E;
            border-color: #199A8E;
            color: white;
            font-size: 16px;
            border-radius: 25px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #15867D;
            border-color: #15867D;
        }

        .btn-secondary {
            background-color: #ccc;
            border-color: #ccc;
            color: white;
            font-size: 16px;
            border-radius: 25px;
            padding: 10px 20px;
        }

        .btn-secondary:hover {
            background-color: #b0b0b0;
            border-color: #b0b0b0;
        }

        /* Styling untuk kolom kiri dan kanan */
        .form-group {
            margin-bottom: 20px;
        }

        #image-container {
            border: 2px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-top: 15px;
        }
    </style>

    <!-- JavaScript untuk preview gambar -->
    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block'; // Menampilkan preview gambar
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
