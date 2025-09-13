@extends('layouts.main')

@section('title', isset($admin) ? 'Edit Admin' : 'Tambah Admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/tambah-admin.css') }}">
<!-- Tambahkan CDN SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title text-center" style="font-weight: bold; font-size: 36px; color: #34B3A0;">{{ isset($admin) ? 'Edit Admin' : 'Tambah Admin Baru' }}</h1>
        </div>
    </div>

    <!-- Form Tambah/Edit Admin -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-12 col-lg-10">
            <div class="card shadow-lg rounded-4">
                <div class="card-body">
                    <form id="adminForm" action="{{ isset($admin) ? route('admin.update', $admin->id_admin) : route('admin.store') }}" method="POST">
                        @csrf
                        @if(isset($admin))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" id="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ old('nama_lengkap', isset($admin) ? $admin->nama_lengkap : '') }}">
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email', isset($admin) ? $admin->email : '') }}">
                                </div>
                            </div>

                            @if(!isset($admin))
                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="password-container">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password">
                                        <span class="toggle-password" onclick="togglePassword('password')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="password-container">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan Konfirmasi Password">
                                        <span class="toggle-password" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Jenis Kelamin -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', isset($admin) ? $admin->jenis_kelamin : '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', isset($admin) ? $admin->jenis_kelamin : '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Hak Akses -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="hak_akses" class="form-label">Hak Akses</label>
                                    <select name="hak_akses" id="hak_akses" class="form-select">
                                        <option value="">Pilih Hak Akses</option>
                                        <option value="Bidan" {{ old('hak_akses', isset($admin) ? $admin->hak_akses : '') == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                                        <option value="Kader" {{ old('hak_akses', isset($admin) ? $admin->hak_akses : '') == 'Kader' ? 'selected' : '' }}>Kader</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Submit -->
                        <div class="row text-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa {{ isset($admin) ? 'fa-edit' : 'fa-save' }}"></i> 
                                    {{ isset($admin) ? 'Update' : 'Simpan' }}
                                </button>
                                
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary w-100">
                                    <i class="fa fa-chevron-left"></i> Kembali
                                </a>                                    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Fungsi untuk toggle show/hide password
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.querySelector(`[onclick="togglePassword('${inputId}')"] i`);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('adminForm');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi input
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const jenisKelamin = document.getElementById('jenis_kelamin').value;
            const hakAkses = document.getElementById('hak_akses').value;
            
            // Jika edit admin, tidak perlu validasi password
            let password, passwordConfirmation;
            if (!{{ isset($admin) ? 'true' : 'false' }}) {
                password = document.getElementById('password').value;
                passwordConfirmation = document.getElementById('password_confirmation').value;
            }
            
            // Validasi field
            if (!nama) {
                showError('Nama Lengkap harus diisi!');
                return;
            }
            
            if (!email) {
                showError('Email harus diisi!');
                return;
            }
            
            if (!isValidEmail(email)) {
                showError('Format email tidak valid!');
                return;
            }
            
            if (!{{ isset($admin) ? 'true' : 'false' }}) {
                if (!password) {
                    showError('Password harus diisi!');
                    return;
                }
                
                if (password.length < 8) {
                    showError('Password minimal 8 karakter!');
                    return;
                }
                
                if (password !== passwordConfirmation) {
                    showError('Konfirmasi password tidak sama!');
                    return;
                }
            }
            
            if (!jenisKelamin) {
                showError('Jenis Kelamin harus dipilih!');
                return;
            }
            
            if (!hakAkses) {
                showError('Hak Akses harus dipilih!');
                return;
            }
            
            // Jika semua validasi berhasil, submit form
            form.submit();
        });
        
        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
                confirmButtonColor: '#34B3A0',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        }
        
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });
</script>
<style>
    .password-container {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        z-index: 5;
        background: transparent;
        border: none;
        padding: 5px;
    }
    .toggle-password:hover {
        color: #34B3A0;
    }
    .form-control {
        padding-right: 40px;
    }
</style>
@endsection