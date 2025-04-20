<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Authentication - Modernize Free')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
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
    </style>
</head>

<body>
    @yield('content')

    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
