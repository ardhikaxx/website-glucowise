@extends('layouts.main')

@section('title', isset($admin) ? 'Edit Admin' : 'Tambah Admin')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-center">{{ isset($admin) ? 'Edit Admin' : 'Tambah Admin Baru' }}</h1>
            </div>
        </div>

        <!-- Form Tambah/Edit Admin -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <form action="{{ isset($admin) ? route('admin.update', $admin->id) : route('admin.store') }}" method="POST">
                            @csrf
                            @if(isset($admin))
                                @method('PUT') <!-- Menggunakan method PUT untuk update -->
                            @endif
                            <div class="row">
                                <!-- Kolom Kiri: Nama, Email, Jenis Kelamin -->
                                <div class="col-md-12 mb-3">
                                    <!-- Nama Lengkap -->
                                    <div class="form-group">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ isset($admin) ? $admin->nama : '' }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <!-- Email -->
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="{{ isset($admin) ? $admin->email : '' }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <!-- Jenis Kelamin -->
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ isset($admin) && $admin->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ isset($admin) && $admin->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Form Submit -->
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary w-50">{{ isset($admin) ? 'Update' : 'Simpan' }}</button>
                                    <a href="{{ route('admin.index') }}" class="btn btn-secondary w-50">Kembali</a>
                                </div>
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
            margin-bottom: 30px;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            background-color: #f9f9f9;
            padding: 40px;
        }

        .form-label {
            font-size: 16px;
            color: #199A8E;
        }

        .form-control, .form-select {
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #199A8E;
            box-shadow: 0 0 5px rgba(25, 154, 142, 0.2);
        }

        .btn-primary {
            background-color: #199A8E;
            border-color: #199A8E;
            color: white;
            font-size: 16px;
            border-radius: 25px;
            padding: 12px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #15867D;
            border-color: #15867D;
        }

        .btn-secondary {
            background-color: #f2f6f9;
            border-color: #f2f6f9;
            color: #199A8E;
            font-size: 16px;
            border-radius: 25px;
            padding: 12px 20px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #e6f7f3;
            border-color: #e6f7f3;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .card-body {
                padding: 30px;
            }

            .btn-primary, .btn-secondary {
                font-size: 14px;
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>

@endsection
