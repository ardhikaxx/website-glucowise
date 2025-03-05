@extends('layouts.main')

@section('title', 'Edit Data Kesehatan')

@section('content')
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
                            <input type="date" name="tanggal_pemeriksaan" class="form-control" value="{{ $data->tanggal_pemeriksaan }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="umur">Umur</label>
                            <input type="number" name="umur" class="form-control" value="{{ $data->umur }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="tinggi_badan">Tinggi Badan (cm)</label>
                            <input type="number" name="tinggi_badan" class="form-control" value="{{ $data->tinggi_badan }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="berat_badan">Berat Badan (kg)</label>
                            <input type="number" name="berat_badan" class="form-control" value="{{ $data->berat_badan }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="gula_darah">Gula Darah</label>
                            <input type="number" name="gula_darah" class="form-control" value="{{ $data->gula_darah }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="lingkar_pinggang">Lingkar Pinggang (cm)</label>
                            <input type="number" name="lingkar_pinggang" class="form-control" value="{{ $data->lingkar_pinggang }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="tensi_darah">Tekanan Darah</label>
                            <input type="text" name="tensi_darah" class="form-control" value="{{ $data->tensi_darah }}" required>
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
