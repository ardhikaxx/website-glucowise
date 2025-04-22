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
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="200" alt="Logo" class="img-fluid">
                            </div>

                            <div class="card-body px-5 pt-1">
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show rounded-3">
                                        {{ session('status') }}
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

                                <form action="{{ route('reset-password') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control py-2" id="email" name="email"
                                                placeholder="Enter your email" required value="{{ old('email') }}">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password" name="password"
                                                placeholder="Enter your new password" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control py-2" id="password_confirmation"
                                                name="password_confirmation" placeholder="Confirm your new password" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-2 shadow-sm">
                                        <i class="bi bi-lock me-2"></i> Reset Password
                                    </button>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">Back to Login</a>
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
    <!-- Additional custom styles if needed -->
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Additional JS logic (if needed)
        });
    </script>
@endpush
