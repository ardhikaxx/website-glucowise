@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <style>
        /* CSS yang sudah ada */
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 52%;
            transform: translateY(-50%);
            z-index: 10;
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .input-group {
            position: relative;
        }
        .form-control {
            border-radius: 0.375rem !important;
            padding-right: 50px;
        }
        .card {
            border-radius: 1rem;
        }
        .btn-primary {
            border-radius: 0.5rem;
            background-color: #34B3A0;
            border-color: #34B3A0;
        }
        .btn-primary:hover {
            background-color: #2a8f80;
            border-color: #2a8f80;
        }
        /* Menghilangkan validasi default browser */
        input:invalid {
            box-shadow: none;
        }
        
        /* CSS tambahan untuk header */
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .login-title {
            font-weight: 700;
            color: #199A8E;
            margin-bottom: 0.5rem;
        }
        .login-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }
    </style>

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <!-- Background gradient and decorative elements -->
            <div class="auth-bg">
                <div class="circle-xl"></div>
                <div class="circle-lg"></div>
                <div class="circle-md"></div>
                <div class="circle-sm"></div>
            </div>

            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-4">
                        <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                            <!-- Card header with logo - reduced padding -->
                            <div class="card-header d-flex justify-content-center align-items-center pb-2 pt-4">
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="200" alt="Logo" class="img-fluid">
                            </div>
                            
                            <!-- Header untuk halaman login -->
                            <div class="login-header px-5 pt-2">
                                <h2 class="login-title">Halaman Login</h2>
                                <p class="login-subtitle">Masukkan email dan password Anda untuk mengakses sistem</p>
                            </div>
                            <div class="card-body px-5 pt-1">
                                <form action="{{ route('login') }}" method="POST" class="mt-3" id="loginForm">
                                    @csrf
                        
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control py-2" id="email" name="email"
                                                placeholder="Masukkan Email Anda" autofocus
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                        
                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password" name="password"
                                                placeholder="Masukkan Password Anda">
                                            <button type="button" class="password-toggle" id="togglePassword">
                                                <i class="fas fa-eye text-muted"></i>
                                            </button>
                                        </div>
                                    </div>
                        
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                Ingat saya
                                            </label>
                                        </div>
                                        <a class="text-decoration-none text-primary fw-semibold" href="{{ route('forgot-password') }}">Lupa Password?</a>
                                    </div>
                        
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-2 shadow-sm">
                                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk toggle password visibility dan validasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = togglePassword.querySelector('i');
            
            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Toggle the eye icon
                if (type === 'password') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });

            // Validasi form dengan SweetAlert
            const loginForm = document.getElementById('loginForm');
            
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value.trim();
                
                // Validasi email harus diisi
                if (!email) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Harus Diisi',
                        text: 'Silakan masukkan alamat email Anda',
                        iconColor: '#dc3545',
                        confirmButtonColor: '#34B3A0',
                        confirmButtonText: 'OK',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    return;
                }
                
                // Validasi format email harus mengandung @
                if (!email.includes('@')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Email Tidak Valid',
                        text: 'Email harus mengandung karakter @',
                        iconColor: '#dc3545',
                        confirmButtonColor: '#34B3A0',
                        confirmButtonText: 'OK',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    return;
                }
                
                // Validasi password harus diisi
                if (!password) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Harus Diisi',
                        text: 'Silakan masukkan password Anda',
                        iconColor: '#dc3545',
                        confirmButtonColor: '#34B3A0',
                        confirmButtonText: 'OK',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    return;
                }
                
                // Jika semua validasi berhasil, submit form
                this.submit();
            });
        });
    </script>
@endsection