<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Header Start -->
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                <!-- Nama User -->
                <li class="nav-item me-3">
                    <span class="text-center" style="color: #34B3A0; font-size: 18px; font-weight: bold;">
                        {{ Auth::user()->nama_lengkap }}
                    </span>
                </li>

                <!-- Ikon User -->
                <li class="nav-item me-3">
                    <div style="width: 40px; height: 40px; background-color: #34B3A0; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center;">
                        <i class="fa fa-user-md" style="color: white; font-size: 20px;"></i>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Header End -->
