@extends('layouts.main')

@section('title', isset($dataEdukasi->id_educasi) ? 'Edit Edukasi' : 'Tambah Edukasi')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">{{ isset($dataEdukasi->id_educasi) ? 'Edit Edukasi' : 'Tambah Edukasi' }}</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ isset($dataEdukasi->id_educasi) ? route('edukasi.update', $dataEdukasi->id_educasi) : route('edukasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($dataEdukasi->id_educasi))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="judul" class="form-label">Judul Edukasi</label>
                                        <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $dataEdukasi->judul) }}" placeholder="Masukkan Judul Edukasi" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi" class="form-label">Deskripsi Edukasi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" placeholder="Masukkan Deskripsi Edukasi" required>{{ old('deskripsi', $dataEdukasi->deskripsi) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-control" required>
                                            <option value="Dasar Diabetes" {{ old('kategori', $dataEdukasi->kategori) == 'Dasar Diabetes' ? 'selected' : '' }}>Dasar Diabetes</option>
                                            <option value="Manajemen Diabetes" {{ old('kategori', $dataEdukasi->kategori) == 'Manajemen Diabetes' ? 'selected' : '' }}>Manajemen Diabetes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gambar" class="form-label">Upload Gambar</label>
                                        <input type="file" name="gambar" id="gambar" class="form-control-file" accept="image/*">
                                    </div>

                                    <!-- Preview Gambar -->
                                    <div class="form-group">
                                        <div id="image-container">
                                            @if(isset($dataEdukasi->gambar) && $dataEdukasi->gambar)
                                                <img id="preview" src="{{ asset($dataEdukasi->gambar) }}" alt="Foto Edukasi" class="img-fluid" style="width: 100%; border-radius: 8px;">
                                            @else
                                                <img id="preview" src="" alt="No image available" class="img-fluid" style="width: 100%; border-radius: 8px; display: none;">
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">{{ isset($dataEdukasi->id_educasi) ? 'Simpan Perubahan' : 'Tambah Edukasi' }}</button>
                                <a href="{{ route('edukasi.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
