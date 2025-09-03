@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
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
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="200" alt="Logo"
                                    class="img-fluid">
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

                                <form action="{{ route('reset-password') }}" method="POST" class="mt-3" id="resetPasswordForm">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control py-2" id="email" name="email"
                                                placeholder="Enter your email" required value="{{ $email ?? old('email') }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password" name="password"
                                                placeholder="Enter your new password" required>
                                            <span class="input-group-text toggle-password">
                                                <i class="bi bi-eye-slash"></i>
                                            </span>
                                        </div>
                                        <div class="form-text">Password minimal 6 karakter</div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label fw-semibold">Confirm
                                            Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password_confirmation"
                                                name="password_confirmation" placeholder="Confirm your new password"
                                                required>
                                            <span class="input-group-text toggle-password">
                                                <i class="bi bi-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-2 shadow-sm"
                                        id="resetButton">
                                        <i class="bi bi-lock me-2"></i> Reset Password
                                    </button>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('login') }}"
                                            class="text-decoration-none text-primary fw-semibold">Back to Login</a>
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

        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            });
        });

        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const button = document.getElementById('resetButton');

            if (password !== passwordConfirmation) {
                alert('Konfirmasi password tidak sesuai.');
                return;
            }

            if (password.length < 6) {
                alert('Password harus minimal 6 karakter.');
                return;
            }

            button.disabled = true;
            button.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

            this.submit();
        });
    </script>
@endpush
