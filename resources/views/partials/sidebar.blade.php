<!-- Sidebar Start -->
<aside class="left-sidebar">
  <!-- Sidebar scroll -->
  <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="/" class="text-nowrap logo-img pt-3">
              <img src="{{ asset('images/logos/favicon1.png') }}" width="150" alt="Logo" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
          </div>
      </div>

      <!-- Sidebar navigation -->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Home</span>
          </li>

          <!-- Dashboard (Dapat diakses oleh semua user) -->
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>

          <!-- Data Pengguna (Bidan & Kader) -->
          @if(Auth::user()->hak_akses == 'Bidan' || Auth::user()->hak_akses == 'Kader')
          <li class="sidebar-item {{ request()->is('dataPengguna/*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dataPengguna.index') }}" aria-expanded="false">
                <span><i class="ti ti-user"></i></span>
                <span class="hide-menu">Data Pengguna</span>
            </a>
        </li>
        
          @endif

          <!-- Data Kesehatan (Bidan & Kader) -->
          @if(Auth::user()->hak_akses == 'Bidan' || Auth::user()->hak_akses == 'Kader')
          <li class="sidebar-item {{ request()->is('dataKesehatan*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dataKesehatan.index') }}" aria-expanded="false">
              <span><i class="ti ti-heart"></i></span>
              <span class="hide-menu">Data Kesehatan</span>
            </a>
          </li>
          @endif

          <!-- Riwayat Kesehatan (Hanya untuk Bidan) -->
          @if(Auth::user()->hak_akses == 'Bidan')
          <li class="sidebar-item {{ request()->is('riwayatKesehatan*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('riwayatKesehatan.index') }}" aria-expanded="false">
              <span><i class="ti ti-history"></i></span>
              <span class="hide-menu">Riwayat Kesehatan</span>
            </a>
          </li>
          @endif

          <!-- Data Screening (Hanya untuk Bidan) -->
          @if(Auth::user()->hak_akses == 'Bidan')
          <li class="sidebar-item {{ request()->is('screening*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('screening.index') }}" aria-expanded="false">
              <span><i class="ti ti-clipboard"></i></span>
              <span class="hide-menu">Data Screening</span>
            </a>
          </li>
          @endif

          <!-- Edukasi (Hanya untuk Bidan) -->
          @if(Auth::user()->hak_akses == 'Bidan')
          <li class="sidebar-item {{ request()->is('edukasi*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('edukasi.index') }}" aria-expanded="false">
              <span><i class="ti ti-book"></i></span>
              <span class="hide-menu">Edukasi</span>
            </a>
          </li>
          @endif

          <!-- Data Admin (Hanya untuk Bidan) -->
          @if(Auth::user()->hak_akses == 'Bidan')
          <li class="sidebar-item {{ request()->is('admin*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.index') }}" aria-expanded="false">
              <span><i class="ti ti-shield"></i></span>
              <span class="hide-menu">Data Admin</span>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll -->
</aside>
<!-- Sidebar End -->
