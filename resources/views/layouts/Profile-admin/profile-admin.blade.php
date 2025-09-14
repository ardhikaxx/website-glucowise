@extends('layouts.main')

@section('title', 'Profil Admin')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/profile/profile-admin.css') }}">
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">
                    <i class="fa fa-user-circle me-3" style="color: #34B3A0;"></i>Profil Saya
                </h1>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card Profil -->
        <div class="row">
            <div class="col-md-12">
                <div class="card profile-card">
                    <div class="card-body">
                        <div class="row  d-flex justify-content-center align-items-center">
                            <div class="col-lg-4 text-center">
                                <div class="profile-header">
                                    <div class="profile-image-wrapper">
                                        <i class="fa fa-user-circle profile-image"></i>
                                        <div class="profile-status online"></div>
                                    </div>
                                    <div class="profile-meta">
                                        <h4 class="profile-name mb-2">{{ $admin->nama_lengkap }}</h4>
                                        <span class="profile-role badge">{{ $admin->hak_akses }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="profile-info">
                                    <h4 class="info-title">Informasi Profil</h4>
                                    <div class="info-item">
                                        <span class="info-label"><i class="fa fa-user me-2"></i>Nama Lengkap</span>
                                        <span class="info-value">: {{ $admin->nama_lengkap }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label"><i class="fa fa-envelope me-2"></i>Email</span>
                                        <span class="info-value">: {{ $admin->email }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label"><i class="fa fa-phone me-2"></i>Nomor Telepon</span>
                                        <span class="info-value">: {{ $admin->nomor_telepon ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label"><i class="fa fa-venus-mars me-2"></i>Jenis Kelamin</span>
                                        <span class="info-value">: {{ $admin->jenis_kelamin }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label"><i class="fa fa-shield-alt me-2"></i>Hak Akses</span>
                                        <span class="info-value">: {{ $admin->hak_akses }}</span>
                                    </div>
                                </div>
                                <div class="profile-actions mt-4">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-edit">
                                        <i class="fa fa-edit me-2"></i>Edit Profil
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
