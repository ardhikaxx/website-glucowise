<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Authentication - Modernize Free')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            z-index: -1;
            overflow: hidden;
        }

        .circle-xl,
        .circle-lg,
        .circle-md,
        .circle-sm {
            position: absolute;
            border-radius: 50%;
            background: #199A8E;
            opacity: 0.1;
        }

        .circle-xl {
            width: 600px;
            height: 600px;
            top: -300px;
            right: -300px;
        }

        .circle-lg {
            width: 400px;
            height: 400px;
            bottom: -150px;
            left: -150px;
        }

        .circle-md {
            width: 200px;
            height: 200px;
            top: 20%;
            left: 10%;
        }

        .circle-sm {
            width: 100px;
            height: 100px;
            bottom: 20%;
            right: 10%;
        }

        .card {
            border: none;
            overflow: hidden;
        }

        .card-header {
            border-bottom: none;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider-text {
            padding: 0 1rem;
        }

        .form-control:focus,
        .form-check-input:focus {
            border-color: #199A8E;
            outline: 2;
            box-shadow: 0 0 0 0.25rem rgb(25 154 142 / 25%);
        }

        .form-check-input:checked {
            background-color: #199A8E;
            border-color: #199A8E;
        }

        /* Custom SweetAlert Styles */
        .swal2-popup {
            border-radius: 15px !important;
        }
        .swal2-icon.swal2-success {
            border-color: #34B3A0 !important;
            color: #34B3A0 !important;
        }
        .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(52, 179, 160, 0.3) !important;
        }
        .swal2-icon.swal2-success [class^=swal2-success-line] {
            background-color: #34B3A0 !important;
        }
        .swal2-icon.swal2-error {
            border-color: #dc3545 !important;
            color: #dc3545 !important;
        }
        .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
            background-color: #dc3545 !important;
        }
        .swal2-confirm {
            background-color: #34B3A0 !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
        }
        .swal2-confirm:focus {
            box-shadow: 0 0 0 3px rgba(52, 179, 160, 0.3) !important;
        }
    </style>
</head>

<body>
    @yield('content')

    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- Script untuk menampilkan SweetAlert berdasarkan session -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert untuk login berhasil
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    iconColor: '#34B3A0',
                    confirmButtonColor: '#34B3A0',
                    confirmButtonText: '<i class="fas fa-check me-2"></i>OK',
                    timer: 3000,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then(() => {
                    window.location.href = "{{ route('dashboard') }}";
                });
            @endif

            // SweetAlert untuk status logout
            @if(session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('status') }}',
                    iconColor: '#34B3A0',
                    confirmButtonColor: '#34B3A0',
                    confirmButtonText: '<i class="fas fa-check me-2"></i>OK',
                    timer: 3000,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            @endif

            // SweetAlert untuk reset password berhasil
            @if(session('status') && request()->is('login'))
                @if(session('status') == 'Password berhasil direset! Silakan login dengan password baru.')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('status') }}',
                        iconColor: '#34B3A0',
                        confirmButtonColor: '#34B3A0',
                        confirmButtonText: '<i class="fas fa-check me-2"></i>OK',
                        timer: 4000,
                        timerProgressBar: true,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                @endif
            @endif

            // SweetAlert untuk error validasi
            @if($errors->any())
                @foreach($errors->all() as $error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ $error }}',
                        iconColor: '#dc3545',
                        confirmButtonColor: '#34B3A0',
                        confirmButtonText: '<i class="fas fa-times me-2"></i>OK',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                    @break
                @endforeach
            @endif
        });
    </script>
</body>

</html>