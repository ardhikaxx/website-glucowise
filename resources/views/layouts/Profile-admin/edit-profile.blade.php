@extends('layouts.main')

@section('title', 'Edit Profil')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/profile/profile-admin.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">
                    <i class="fa fa-edit me-3" style="color: #34B3A0;"></i>Edit Profil
                </h1>
            </div>
        </div>

        <!-- Form Edit Profil -->
        <div class="row">
            <div class="col-md-12">
                <div class="card profile-card">
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="form-section-title">Informasi Dasar</h4>

                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">
                                            <i class="fa fa-user me-2"></i>Nama Lengkap
                                        </label>
                                        <input type="text"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            id="nama_lengkap" name="nama_lengkap"
                                            value="{{ old('nama_lengkap', $admin->nama_lengkap) }}" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <i class="fa fa-envelope me-2"></i>Email
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $admin->email) }}"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="nomor_telepon" class="form-label">
                                            <i class="fa fa-phone me-2"></i>Nomor Telepon
                                        </label>
                                        <input type="text"
                                            class="form-control @error('nomor_telepon') is-invalid @enderror"
                                            id="nomor_telepon" name="nomor_telepon"
                                            value="{{ old('nomor_telepon', $admin->nomor_telepon) }}"
                                            placeholder="Contoh: 081234567890">
                                        @error('nomor_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4 class="form-section-title">Ubah Password</h4>
                                    <p class="text-muted">Kosongkan jika tidak ingin mengubah password</p>

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">
                                            <i class="fa fa-lock me-2"></i>Password Saat Ini
                                        </label>
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">
                                            <i class="fa fa-key me-2"></i>Password Baru
                                        </label>
                                        <input type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            id="new_password" name="new_password">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">
                                            <i class="fa fa-key me-2"></i>Konfirmasi Password Baru
                                        </label>
                                        <input type="password" class="form-control" id="new_password_confirmation"
                                            name="new_password_confirmation">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary btn-save">
                                            <i class="fa fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                        <a href="{{ route('profile.show') }}" class="btn btn-secondary btn-cancel">
                                            <i class="fa fa-times me-2"></i>Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('new_password_confirmation').value;
            const currentPassword = document.getElementById('current_password').value;

            if (newPassword && !currentPassword) {
                e.preventDefault();
                alert('Harap masukkan password saat ini untuk mengubah password.');
                return false;
            }

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Konfirmasi password baru tidak sesuai.');
                return false;
            }
        });
    </script>
@endsection
