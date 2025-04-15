@extends('layouts.main')

@section('title', isset($dataEdukasi->id_edukasi) ? 'Edit Edukasi' : 'Tambah Edukasi')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edukasi/edit-edukasi.css') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title">{{ isset($dataEdukasi->id_edukasi) ? 'Edit Edukasi' : 'Tambah Edukasi' }}</h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ isset($dataEdukasi->id_edukasi) ? route('edukasi.update', $dataEdukasi->id_edukasi) : route('edukasi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($dataEdukasi->id_edukasi))
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
                                <button type="submit" class="btn btn-primary">{{ isset($dataEdukasi->id_edukasi) ? 'Simpan Perubahan' : 'Tambah Edukasi' }}</button>
                                <a href="{{ route('edukasi.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/edukasi/edit-edukasi.js') }}"></script>
@endsection
