@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <!-- Menambahkan link CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @font-face {
            font-family: 'DarumadropOne';
            src: url('{{ asset('fonts/DarumadropOne-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        
        .reset-password-header {
            text-align: center;
        }
        .reset-password-title {
            font-weight: 700;
            color: #199A8E;
            font-size: 40px;
            margin-bottom: 0.5rem;
            font-family: 'DarumadropOne', cursive, sans-serif;
        }
        .reset-password-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
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
            padding-right: 40px;
            /* Memberikan ruang untuk ikon mata */
        }

        .card {
            border-radius: 1rem;
        }

        .btn-primary {
            border-radius: 0.5rem;
        }

        .toggle-password {
            cursor: pointer;
            background: transparent;
            border: none;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #6c757d;
        }
        
        .password-strength {
            width: auto;
            height: 5px;
            margin-top: 5px;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        
        .password-requirements {
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 3px;
        }
        
        .requirement i {
            margin-right: 5px;
            font-size: 0.75rem;
        }
        
        .valid {
            color: #28a745;
        }
        
        .invalid {
            color: #6c757d;
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
                <div class="row justify-content-center w-100 h-100">
                    <div class="col-md-8 col-lg-6 col-xxl-4">
                        <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                            <div class="card-header d-flex justify-content-center align-items-center pb-2 pt-4">
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="180" alt="Logo"
                                    class="img-fluid">
                            </div>

                            <!-- Header untuk halaman reset password -->
                            <div class="reset-password-header px-5 pt-1">
                                <h2 class="reset-password-title">RESET PASSWORD</h2>
                                <p class="reset-password-subtitle">Buat password baru untuk akun Anda</p>
                            </div>

                            <div class="card-body px-5 pt-1">
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show rounded-3">
                                        {{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show rounded-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('reset-password') }}" method="POST" class="mt-2"
                                    id="resetPasswordForm" novalidate>
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control py-2" id="email" name="email"
                                                placeholder="Enter your email" value="{{ $email ?? old('email') }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password" name="password"
                                                placeholder="Masukkan password baru" required>
                                            <button type="button" class="password-toggle toggle-password"
                                                data-target="password">
                                                <i class="fas fa-eye-slash text-muted"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength" id="passwordStrength"></div>
                                        <div class="password-requirements">
                                            <div class="requirement" id="lengthReq">
                                                <i class="fas fa-circle invalid"></i>
                                                <span>Minimal 8 karakter</span>
                                            </div>
                                            <div class="requirement" id="numberReq">
                                                <i class="fas fa-circle invalid"></i>
                                                <span>Mengandung angka</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password_confirmation"
                                                name="password_confirmation" placeholder="Konfirmasi password baru"
                                                required>
                                            <button type="button" class="password-toggle toggle-password"
                                                data-target="password_confirmation">
                                                <i class="fas fa-eye-slash text-muted"></i>
                                            </button>
                                        </div>
                                        <div class="password-requirements">
                                            <div class="requirement" id="matchReq">
                                                <i class="fas fa-circle invalid"></i>
                                                <span>Password harus cocok</span>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-2 shadow-sm"
                                        id="resetButton">
                                        <i class="fas fa-lock me-2"></i> Reset Password
                                    </button>

                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 py-3 fw-semibold rounded-3 shadow-sm">
                                            <i class="fa fa-arrow-left me-2"></i>Kembali Ke Login
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-auth-compat.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}"
        };

        firebase.initializeApp(firebaseConfig);

        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });

        // Fungsi untuk memvalidasi kekuatan password
        function validatePassword(password) {
            const errors = [];
            
            if (!password) {
                return {
                    isValid: false,
                    errors: ['Password harus diisi.'],
                    strength: 0
                };
            }
            
            if (password.length < 8) {
                errors.push('Password harus minimal 8 karakter.');
            }
            
            if (!/\d/.test(password)) {
                errors.push('Password harus mengandung minimal 1 angka.');
            }
            
            // Hitung kekuatan password (0-100)
            let strength = 0;
            if (password.length >= 8) strength += 40;
            if (/\d/.test(password)) strength += 20;
            if (/[A-Z]/.test(password)) strength += 10;
            if (/[^A-Za-z0-9]/.test(password)) strength += 10;
            
            return {
                isValid: errors.length === 0,
                errors: errors,
                strength: strength
            };
        }

        // Fungsi untuk memperbarui tampilan kekuatan password
        function updatePasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrength');
            const lengthReq = document.getElementById('lengthReq');
            const numberReq = document.getElementById('numberReq');
            
            if (!password) {
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = '#dc3545';
                return;
            }
            
            const validation = validatePassword(password);
            
            // Update persyaratan
            if (password.length >= 6) {
                lengthReq.querySelector('i').className = 'fas fa-check-circle valid';
            } else {
                lengthReq.querySelector('i').className = 'fas fa-circle invalid';
            }
            
            if (/\d/.test(password)) {
                numberReq.querySelector('i').className = 'fas fa-check-circle valid';
            } else {
                numberReq.querySelector('i').className = 'fas fa-circle invalid';
            }
            
            // Update strength bar
            strengthBar.style.width = validation.strength + '%';
            
            if (validation.strength < 40) {
                strengthBar.style.backgroundColor = '#dc3545'; // Merah
            } else if (validation.strength < 70) {
                strengthBar.style.backgroundColor = '#ffc107'; // Kuning
            } else {
                strengthBar.style.backgroundColor = '#28a745'; // Hijau
            }
        }

        // Fungsi untuk memeriksa kecocokan password
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchReq = document.getElementById('matchReq');
            
            if (!confirmPassword) {
                matchReq.querySelector('i').className = 'fas fa-circle invalid';
                return false;
            }
            
            if (password === confirmPassword && password.length > 0) {
                matchReq.querySelector('i').className = 'fas fa-check-circle valid';
                return true;
            } else {
                matchReq.querySelector('i').className = 'fas fa-times-circle invalid';
                return false;
            }
        }

        // Event listeners untuk validasi real-time
        document.getElementById('password').addEventListener('input', function() {
            updatePasswordStrength(this.value);
            checkPasswordMatch();
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            checkPasswordMatch();
        });

        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const button = document.getElementById('resetButton');

            // Validasi password
            const passwordValidation = validatePassword(password);
            if (!passwordValidation.isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Valid',
                    html: passwordValidation.errors.join('<br>'),
                    iconColor: '#dc3545',
                    confirmButtonColor: '#34B3A0',
                    confirmButtonText: 'Mengerti',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return;
            }

            // Validasi konfirmasi password
            if (password !== passwordConfirmation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Konfirmasi Password Tidak Sesuai',
                    text: 'Password dan konfirmasi password harus sama.',
                    iconColor: '#dc3545',
                    confirmButtonColor: '#34B3A0',
                    confirmButtonText: 'Mengerti',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return;
            }

            button.disabled = true;
            button.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

            this.submit();
        });
        
        // Menonaktifkan validasi default browser
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('resetPasswordForm').setAttribute('novalidate', 'novalidate');
            
            // Menghapus event listener default untuk invalid event
            const inputs = document.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('invalid', function(e) {
                    e.preventDefault();
                });
            });
        });
    </script>
@endsection