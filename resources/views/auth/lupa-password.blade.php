@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
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
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="200" alt="Logo" class="img-fluid">
                            </div>

                            <div class="card-body px-5 pt-1">
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show rounded-3">
                                        <ul class="mb-0">
                                            <li>{{ session('status') }}</li>
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show rounded-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('send-reset-link') }}" method="POST" class="mt-3" id="forgotPasswordForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control py-2" id="email" name="email" 
                                                placeholder="Enter your email" required autofocus>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-3 shadow-sm"
                                            id="resetButton">
                                        <i class="fa fa-envelope me-2"></i> Send Reset Link
                                    </button>

                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 py-3 fw-semibold rounded-3 shadow-sm">
                                            <i class="fa fa-arrow-left me-2"></i>Back to Login
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
        // Konfigurasi Firebase
        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}"
        };
        
        // Inisialisasi Firebase
        firebase.initializeApp(firebaseConfig);
        
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const button = document.getElementById('resetButton');
            
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
            
            // Mengirim permintaan reset password melalui Firebase
            firebase.auth().sendPasswordResetEmail(email)
                .then(() => {
                    // Jika berhasil, submit form ke server untuk menangani respons
                    this.submit();
                })
                .catch((error) => {
                    // Menampilkan error
                    alert('Error: ' + error.message);
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-envelope me-2"></i> Send Reset Link';
                });
        });
    </script>
@endpush