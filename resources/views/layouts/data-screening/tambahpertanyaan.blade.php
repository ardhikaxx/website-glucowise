@extends('layouts.main')

@section('title', isset($pertanyaan) ? 'Edit Data Screening' : 'Tambah Data Screening')

@section('content')
<link rel="stylesheet" href="{{ asset('css/data-screening/tambah-screening.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center text-primary font-weight-bold mb-4">{{ isset($pertanyaan) ? 'Edit Data Screening' : 'Tambah Data Screening' }}</h1>
            </div>
        </div>

        <!-- Form Tambah/Edit Screening -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <!-- Form -->
                        <form action="{{ isset($pertanyaan) ? route('screening.update', $pertanyaan->id_pertanyaan) : route('screening.store') }}" method="POST">
                            @csrf
                            @if(isset($pertanyaan))
                                @method('PUT') <!-- Menandakan bahwa ini adalah request PUT untuk update -->
                            @endif
                            <div class="row">
                                <!-- ID Pertanyaan -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="id_pertanyaan" class="form-label text-muted">ID Pertanyaan</label>
                                        <input type="hidden" name="id_pertanyaan" id="id_pertanyaan" value="{{ isset($pertanyaan) ? $pertanyaan->id_pertanyaan : $id_pertanyaan }}">
                                        <input type="text" class="form-control" value="{{ isset($pertanyaan) ? $pertanyaan->id_pertanyaan : $id_pertanyaan }}" disabled>
                                    </div>
                                </div>
                        
                                <!-- Pertanyaan -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="pertanyaan" class="form-label text-muted">Pertanyaan</label>
                                        <input type="text" name="pertanyaan" id="pertanyaan" class="form-control" placeholder="Masukkan Pertanyaan" value="{{ isset($pertanyaan) ? $pertanyaan->pertanyaan : old('pertanyaan') }}" required>
                                    </div>
                                </div>
                        
                                <!-- Jawaban dan Skoring -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="jawaban" class="me-2">Jawaban</label>
                                        <button type="button" class="btn btn-outline-primary mt-2 mb-3" id="add-jawaban">Tambah Jawaban</button>
                                        <div id="jawaban-container">
                                            @if(isset($pertanyaan))
                                                @foreach($pertanyaan->jawabanScreening as $jawaban)
                                                    <div class="jawaban-item mb-3 d-flex">
                                                        <select name="jawaban[]" class="form-select mb-2" required>
                                                            <option value="Tidak Pernah" {{ $jawaban->jawaban == 'Tidak Pernah' ? 'selected' : '' }}>Tidak Pernah</option>
                                                            <option value="Jarang" {{ $jawaban->jawaban == 'Jarang' ? 'selected' : '' }}>Jarang</option>
                                                            <option value="Sering" {{ $jawaban->jawaban == 'Sering' ? 'selected' : '' }}>Sering</option>
                                                            <option value="Selalu" {{ $jawaban->jawaban == 'Selalu' ? 'selected' : '' }}>Selalu</option>
                                                        </select>
                                                        <input type="number" name="skoring[]" class="form-control me-2" placeholder="Skoring" value="{{ explode('(', rtrim($jawaban->jawaban, ')'))[1] ?? '' }}" required>
                                                        <!-- Tombol minus untuk menghapus jawaban -->
                                                        <button type="button" class="btn btn-danger btn-sm remove-jawaban">-</button>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="jawaban-item mb-3 d-flex">
                                                    <select name="jawaban[]" class="form-select mb-2" required>
                                                        <option value="Tidak Pernah">Tidak Pernah</option>
                                                        <option value="Jarang">Jarang</option>
                                                        <option value="Sering">Sering</option>
                                                        <option value="Selalu">Selalu</option>
                                                    </select>
                                                    <input type="number" name="skoring[]" class="form-control me-2" placeholder="Skoring" required>
                                                    <!-- Tombol minus untuk menghapus jawaban -->
                                                    <button type="button" class="btn btn-danger btn-sm remove-jawaban" style="display:none;">-</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Tombol Simpan -->
                                <div class="col-md-12 d-flex flex-row gap-2 text-center justify-content-center align-items-center">
                                    <button type="submit" class="btn btn-primary w-50">{{ isset($pertanyaan) ? 'Update' : 'Simpan' }}</button>
                                    <a href="{{ route('screening.index') }}" class="btn btn-secondary w-50">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/data-screening/tambah-screening.js') }}"></script>
@endsection