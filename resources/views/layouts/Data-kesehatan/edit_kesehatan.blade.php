@extends('layouts.main')

@section('title', 'Edit Data Kesehatan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Data-kesehatan/edit-kesehatan.css') }}">
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Edit Data Kesehatan - NIK: {{ $data->nik }}</h1>
        </div>
    </div>

    <!-- Form Edit Data Kesehatan -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" action="{{ route('dataKesehatan.update', $data->nik) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Menambahkan method spoofing untuk PUT -->
                    
                        <!-- Form fields -->
                        <div class="form-group">
                            <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan</label>
                            <!-- Kolom tanggal tidak bisa diedit -->
                            <input type="date" name="tanggal_pemeriksaan" class="form-control" value="{{ $data->tanggal_pemeriksaan }}" required readonly>
                        </div>
                    
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <!-- Kolom umur hanya bisa menerima angka -->
                            <input type="number" name="umur" class="form-control" value="{{ $data->umur }}" required min="0" step="1">
                        </div>
                    
                        <div class="form-group">
                            <label for="tinggi_badan">Tinggi Badan (cm)</label>
                            <!-- Kolom tinggi badan hanya bisa menerima angka -->
                            <input type="number" name="tinggi_badan" class="form-control" value="{{ $data->tinggi_badan }}" required min="0" step="1">
                        </div>
                    
                        <div class="form-group">
                            <label for="berat_badan">Berat Badan (kg)</label>
                            <!-- Kolom berat badan hanya bisa menerima angka -->
                            <input type="number" name="berat_badan" class="form-control" value="{{ $data->berat_badan }}" required min="0" step="0.1">
                        </div>
                    
                        <div class="form-group">
                            <label for="gula_darah">Gula Darah</label>
                            <!-- Kolom gula darah hanya bisa menerima angka -->
                            <input type="number" name="gula_darah" class="form-control" value="{{ $data->gula_darah }}" required min="0" step="0.1">
                        </div>
                    
                        <div class="form-group">
                            <label for="lingkar_pinggang">Lingkar Pinggang (cm)</label>
                            <!-- Kolom lingkar pinggang hanya bisa menerima angka -->
                            <input type="number" name="lingkar_pinggang" class="form-control" value="{{ $data->lingkar_pinggang }}" required min="0" step="1">
                        </div>
                    
                        <div class="form-group">
                            <label for="tensi_darah">Tekanan Darah</label>
                            <!-- Kolom tekanan darah hanya bisa menerima angka -->
                            <input type="text" name="tensi_darah" class="form-control" value="{{ $data->tensi_darah }}" required pattern="\d{1,3}/\d{1,3}">
                            <!-- Pattern regex untuk format tekanan darah seperti 120/80 -->
                        </div>
                    
                        <div class="form-group">
                            <label for="riwayat_keluarga_diabetes">Riwayat Keluarga Diabetes</label>
                            <select name="riwayat_keluarga_diabetes" class="form-control" required>
                                <option value="Ya" {{ $data->riwayat_keluarga_diabetes == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ $data->riwayat_keluarga_diabetes == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>
                    
                        <button type="button" id="submitBtn" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('dataKesehatan.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/Data-kesehatan/edit-kesehatan.js') }}"></script>
@endsection
