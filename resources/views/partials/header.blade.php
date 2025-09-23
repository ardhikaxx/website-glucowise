<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Header Start -->
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light px-3">
        <ul class="navbar-nav d-flex justify-content-start align-items-center">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)"
                    style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; background-color: #f2f2f2; transition: all 0.3s;">
                    <i class="fas fa-bars" style="font-size: 18px; color: #34B3A0;"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                <!-- Nama User -->
                <li class="nav-item me-3">
                    <span class="user-name" style="color: #34B3A0; font-size: 18px; font-weight: bold;">
                        {{ Auth::user()->nama_lengkap }}
                    </span>
                </li>

                <!-- Ikon User -->
                <li class="nav-item">
                    <div
                        style="width: 40px; height: 40px; background-color: #34B3A0; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center;">
                        <i class="fa fa-user-md" style="color: white; font-size: 20px;"></i>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<style>
    .user-avatar {
        width: 42px;
        height: 42px;
        background-color: #34B3A0;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.3s;
    }

    .user-avatar i {
        color: #fff;
        font-size: 18px;
    }

    .user-avatar:hover {
        background-color: #2e9b8b;
        transform: scale(1.05);
    }

    .sidebartoggler {
        cursor: pointer;
    }

    .sidebartoggler:hover {
        background-color: rgba(52, 179, 160, 0.1) !important;
        transform: scale(1.05);
    }

    .user-name {
        font-weight: 600;
        display: flex;
        justify-content: end;
        align-items: end;
        text-align: end;
    }
</style>
