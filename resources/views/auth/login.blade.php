@extends('layouts.auth')

@section('title', 'Login')

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
                            <!-- Card header with logo - reduced padding -->
                            <div class="card-header d-flex justify-content-center align-items-center pb-2 pt-4">
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="200" alt="Logo" class="img-fluid">
                            </div>
                            
                            <!-- Card body - reduced top padding -->
                            <div class="card-body px-5 pt-1">
                                
                                {{-- Tampilkan pesan error jika login gagal --}}
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
                        
                                <form action="{{ route('login') }}" method="POST" class="mt-3">
                                    @csrf
                        
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control py-2" id="email" name="email"
                                                placeholder="Enter your email" required autofocus>
                                        </div>
                                    </div>
                        
                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password" name="password"
                                                placeholder="Enter your password" required>
                                        </div>
                                    </div>
                        
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Remember me
                                            </label>
                                        </div>
                                        <a class="text-decoration-none text-primary fw-semibold" href="./forgot-password">Forgot
                                            Password?</a>
                                    </div>
                        
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-2 shadow-sm">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Kang
                                    </button>
                        
                                    <div class="divider my-2">
                                        <div class="divider-text text-muted">OR</div>
                                    </div>
                        
                                    <!-- Social login buttons -->
                                    <div class="d-grid gap-3">
                                        <a href="#"
                                            class="btn btn-light border py-3 rounded-3 d-flex align-items-center justify-content-center shadow-sm">
                                            <img src="{{ asset('images/logos/search.png') }}" alt="Google Logo"
                                                width="20" class="me-2">
                                            <span>Continue with Google</span>
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

@push('styles')
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="bi bi-eye-fill text-muted"></i>' :
                    '<i class="bi bi-eye-slash-fill text-muted"></i>';
            });
        });
    </script>
@endpush
