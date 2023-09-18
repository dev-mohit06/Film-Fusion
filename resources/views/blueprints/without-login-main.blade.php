<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Toast Notificaations CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    @yield('meta-tags')
    <title>@yield('title')</title>

    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="{{ asset('img/Logo.svg') }}" type="image/x-icon">

    <!--=============== REMIX ICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <div class="master-container">
        @yield('container')
    </div>

    <!--=============== Jquery ===============-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    
    {{-- Toast Notificaations JS --}}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @stack('scripts')
</body>

</html>
