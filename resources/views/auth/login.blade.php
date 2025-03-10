@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img src="{{ asset('images/logos/favicon1.png') }}" width="180" alt="Logo">
                            </a>

                            {{-- Tampilkan pesan error jika login gagal --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label text-dark" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>
                                    <a class="text-primary fw-bold" href="#">Lupa Password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
                                    Sign In
                                </button>
                            </form>

                            {{-- Tombol Continue with Google --}}
                            <div class="d-flex justify-content-center mt-4">
                                <a href="#" class="btn btn-outline-danger w-100 py-3 fs-4 rounded-2 d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('images/logos/search.png') }}" alt="Google Logo" width="30" class="me-2">
                                    Continue with Google
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
