<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Glucowise')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />
    
    <!-- Default Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    {{-- <link rel="stylesheet"  href="{{ asset('css/Data-kesehatan/Data-kesehatan.css') }}"/> --}}

    {{-- @yield('css/Data-kesehatan/Data-kesehatan.css') <!-- This will allow page-specific CSS to be injected --> --}}
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
            
            {{-- @include('partials.footer') --}}
        </div>
    </div>
    
    <!-- Default JS -->
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- @yield('js/Data-kesehatan/Data-kesehatan.js') 
    <!-- This will allow page-specific JS to be injected --> --}}

    {{-- <script src="{{ asset('js/Data-kesehatan/Data-kesehatan.js') }}"></script> --}}
</body>
</html>
