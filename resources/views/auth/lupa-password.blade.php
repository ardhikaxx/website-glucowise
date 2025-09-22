@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<style>
    @font-face {
        font-family: 'DarumadropOne';
        src: url('{{ asset('fonts/DarumadropOne-Regular.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }

    .forgot-password-header {
        text-align: center;
    }
    .forgot-password-title {
        font-weight: 700;
        color: #199A8E;
        font-size: 40px;
        margin-bottom: 0.5rem;
        font-family: 'DarumadropOne', cursive, sans-serif;
    }
    .forgot-password-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                            <div class="card-header d-flex justify-content-center align-items-center pb-2 pt-4">
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="180" alt="Logo" class="img-fluid">
                            </div>

                            <div class="forgot-password-header px-5 pt-2">
                                <h2 class="forgot-password-title">LUPA PASSWORD</h2>
                                <p class="forgot-password-subtitle">Masukkan email Anda untuk menerima link reset password</p>
                            </div>

                            <div class="card-body px-5 pt-1">
                                <form action="{{ route('send-reset-link') }}" method="POST" class="mt-2" id="forgotPasswordForm" novalidate>
                                    @csrf
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control py-2" id="email" name="email" 
                                                placeholder="Masukkan email Anda" autofocus>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-3 shadow-sm"
                                            id="resetButton">
                                        <i class="fa fa-envelope me-2"></i>Kirim Link Reset Password
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
@endsection

@push('scripts')
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
        
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const button = document.getElementById('resetButton');
            
            if (!email) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input',
                    text: 'Email harus diisi.',
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
            
            if (!validateEmail(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Email Salah',
                    text: 'Format email tidak valid. Pastikan email mengandung karakter @ dan domain yang benar. Contoh: nama@example.com',
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
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
            
            firebase.auth().sendPasswordResetEmail(email)
                .then(() => {
                    this.submit();
                })
                .catch((error) => {
                    let errorMessage = 'Terjadi kesalahan saat mengirim email reset.';
                    
                    if (error.code === 'auth/user-not-found') {
                        errorMessage = 'Email tidak ditemukan dalam sistem.';
                    } else if (error.code === 'auth/invalid-email') {
                        errorMessage = 'Format email tidak valid.';
                    } else if (error.code === 'auth/too-many-requests') {
                        errorMessage = 'Terlalu banyak percobaan. Silakan coba lagi nanti.';
                    } else {
                        errorMessage = 'Terjadi kesalahan: ' + error.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengirim Email',
                        text: errorMessage,
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
                    
                    button.disabled = false;
                    button.innerHTML = '<i class="fa fa-envelope me-2"></i>Kirim Link Reset Password';
                });
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('forgotPasswordForm').setAttribute('novalidate', 'novalidate');
            
            document.getElementById('email').addEventListener('invalid', function(e) {
                e.preventDefault();
            });
        });
    </script>
@endpush