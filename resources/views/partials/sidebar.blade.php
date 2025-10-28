<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll -->
    <div>
        <div class="brand-logo d-flex align-items-center flex-column justify-content-center position-relative">
            <a href="/" class="text-nowrap logo-img pt-3">
                <img src="{{ asset('images/logos/favicon1.png') }}" width="150" alt="Logo" />
            </a>
            <button class="close-btn d-xl-none d-flex align-items-center justify-content-center sidebartoggler"
                id="sidebarCollapse" aria-label="Close Sidebar">
                <i class="mdi mdi-chevron-left fs-6"></i>
            </button>
        </div>

        <!-- Sidebar navigation -->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <span class="hide-menu">Menu Utama</span>
                </li>

                <!-- Dashboard (Dapat diakses oleh semua user) -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span class="sidebar-icon"><i class="ti ti-smart-home"></i></span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span class="sidebar-icon"><i class="ti ti-list"></i></span>
                        <span class="hide-menu">Manajemen Kunjungan</span>
                    </a>
                </li> --}}

                <!-- Data Pengguna (Dokter & Perawat) -->
                @if (Auth::user()->hak_akses == 'Dokter' || Auth::user()->hak_akses == 'Perawat')
                    <li class="sidebar-item {{ request()->is('data_pengguna*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('dataPengguna.index') }}" aria-expanded="false">
                            <span class="sidebar-icon"><i class="ti ti-users"></i></span>
                            <span class="hide-menu">Manajemen Pasien</span>
                        </a>
                    </li>
                @endif

                <!-- Data Kesehatan (Dokter & Perawat) -->
                @if (Auth::user()->hak_akses == 'Dokter' || Auth::user()->hak_akses == 'Perawat')
                    <li class="sidebar-item {{ request()->is('data-kesehatan*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('dataKesehatan.index') }}" aria-expanded="false">
                            <span class="sidebar-icon"><i class="ti ti-stethoscope"></i></span>
                            <span class="hide-menu">Data Kesehatan</span>
                        </a>
                    </li>
                @endif

                <!-- Riwayat Kesehatan (Hanya untuk Dokter) -->
                @if (Auth::user()->hak_akses == 'Dokter')
                    <li class="sidebar-item {{ request()->is('rekam-medis*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('riwayatKesehatan.index') }}" aria-expanded="false">
                            <span class="sidebar-icon"><i class="ti ti-notes"></i></span>
                            <span class="hide-menu">Rekam Medis</span>
                        </a>
                    </li>
                @endif

                <!-- Data Screening (Hanya untuk Dokter) -->
                @if (Auth::user()->hak_akses == 'Dokter')
                    <li class="sidebar-item {{ request()->is('data-screening*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('screening.index') }}" aria-expanded="false">
                            <span class="sidebar-icon"><i class="ti ti-clipboard"></i></span>
                            <span class="hide-menu">Manajemen Screening</span>
                        </a>
                    </li>
                @endif

                <!-- Edukasi (Hanya untuk Dokter) -->
                @if (Auth::user()->hak_akses == 'Dokter')
                    <li class="sidebar-item {{ request()->is('edukasi*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('edukasi.index') }}" aria-expanded="false">
                            <span class="sidebar-icon"><i class="ti ti-book"></i></span>
                            <span class="hide-menu">Manajemen Edukasi</span>
                        </a>
                    </li>
                @endif

                <!-- Laporan (Hanya untuk Dokter) -->
                @if (Auth::user()->hak_akses == 'Dokter')
                    <li class="sidebar-item {{ request()->is('Laporan*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('laporan.index') }}" aria-expanded="false">
                            <span class="sidebar-icon"><i class="ti ti-report"></i></span>
                            <span class="hide-menu">Laporan Rekam Medis</span>
                        </a>
                    </li>
                @endif

                <!-- Data Admin (Hanya untuk Dokter) -->
                @if (Auth::user()->hak_akses == 'Dokter')
                    <li class="sidebar-item {{ request()->is('admin*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.index') }}" aria-expanded="false">
                            <span class="sidebar-icon"><i class="ti ti-shield"></i></span>
                            <span class="hide-menu">Manajemen Admin</span>
                        </a>
                    </li>
                @endif

                <!-- Profile (Dapat diakses oleh semua role) -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Akun</span>
                </li>

                <li class="sidebar-item {{ request()->is('profile*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('profile.show') }}" aria-expanded="false">
                        <span class="sidebar-icon"><i class="ti ti-user-circle"></i></span>
                        <span class="hide-menu">Profil Saya</span>
                    </a>
                </li>

                <!-- Tombol Keluar -->
                <li class="sidebar-item logout-item">
                    <a class="sidebar-link" href="javascript:void(0)" onclick="confirmLogout()" aria-expanded="false">
                        <span class="sidebar-icon"><i class="ti ti-logout"></i></span>
                        <span class="hide-menu">Keluar</span>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll -->
</aside>
<!-- Sidebar End -->