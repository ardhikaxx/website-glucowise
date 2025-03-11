@extends('layouts.main')

@section('title', isset($admin) ? 'Edit Admin' : 'Tambah Admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/tambah-admin.css') }}">
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
                        <form action="{{ isset($admin) ? route('admin.update', $admin->id_admin) : route('admin.store') }}" method="POST">
                            @csrf
                            @if(isset($admin))
                            @method('PUT')
                        @endif
                            <div class="row">
                                <!-- Nama Lengkap -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" id="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ old('nama_lengkap', isset($admin) ? $admin->nama_lengkap : '') }}" required>
                                        @error('nama_lengkap')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email', isset($admin) ? $admin->email : '') }}" required>
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                @if(!isset($admin))  <!-- Menampilkan input password hanya saat menambah data admin -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan Konfirmasi Password" required>
                                    </div>
                                </div>
                                @endif

                                <!-- Jenis Kelamin -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', isset($admin) ? $admin->jenis_kelamin : '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', isset($admin) ? $admin->jenis_kelamin : '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Hak Akses -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="hak_akses" class="form-label">Hak Akses</label>
                                        <select name="hak_akses" id="hak_akses" class="form-select" required>
                                            <option value="">Pilih Hak Akses</option>
                                            <option value="Bidan" {{ old('hak_akses', isset($admin) ? $admin->hak_akses : '') == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                                            <option value="Kader" {{ old('hak_akses', isset($admin) ? $admin->hak_akses : '') == 'Kader' ? 'selected' : '' }}>Kader</option>
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
    <script src="{{ asset('js/admin/tambah-admin.js') }}"></script>
@endsection
