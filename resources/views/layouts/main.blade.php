<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Glucowise')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .custom-swal-popup {
            border-radius: 15px;
        }

        .swal2-icon.swal2-question {
            border-color: #34B3A0;
            color: #34B3A0;
        }
        
        /* Style untuk tombol keluar di sidebar */
        .logout-item .sidebar-link {
            color: #f85149 !important;
        }
        
        .logout-item .sidebar-link:hover {
            background-color: rgba(248, 81, 73, 0.1) !important;
        }
        
        .logout-item.active .sidebar-link {
            background-color: #f85149 !important;
            color: white !important;
        }
        
        .logout-item.active .sidebar-link i {
            color: white !important;
        }
        
        /* Style untuk semua item sidebar saat aktif */
        .sidebar-item.active .sidebar-link {
            background-color: #34B3A0;
            color: white !important;
            border-radius: 8px;
        }
        
        .sidebar-item.active .sidebar-link i {
            color: white !important;
        }
        
        .sidebar-item.active .sidebar-link .hide-menu {
            color: white !important;
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('partials.sidebar')

        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include('partials.header')

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            // Tambahkan kelas aktif ke tombol keluar saat diklik
            document.querySelectorAll('.logout-item').forEach(item => {
                item.classList.add('active');
            });
            
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'question',
                iconColor: '#34B3A0',
                showCancelButton: true,
                confirmButtonColor: '#34B3A0',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-sign-out-alt me-2"></i> Ya, Keluar!',
                cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                // Hapus kelas aktif jika user membatalkan
                if (!result.isConfirmed) {
                    document.querySelectorAll('.logout-item').forEach(item => {
                        item.classList.remove('active');
                    });
                }
                
                if (result.isConfirmed) {
                    // Submit form logout
                    document.getElementById('logout-form').submit();
                }
            });
        }
        
        // Hapus status aktif saat mouse meninggalkan tombol keluar (kecuali jika sedang aktif)
        document.querySelectorAll('.logout-item').forEach(item => {
            item.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.querySelector('.sidebar-link').style.backgroundColor = '';
                }
            });
        });
    </script>
    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
        @csrf
    </form>
</body>

</html>
