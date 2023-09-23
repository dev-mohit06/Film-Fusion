<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- Loader Css FIle -->
    <link rel="stylesheet" href="{{ asset('css/reusable/loader.css') }}">
    {{-- Toast Notificaations CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    @stack('styles')
</head>

<body>
    <!-- ========== Starting of loader ========== -->
    <div class="loader">
        <div class="boxes">
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- ========== end of loader ========== -->

    <div class="master-container">
        <div class="container">
            <!-- ========== Starting of SideBar ========== -->
            @yield('backdrop')
            <aside class="aside">
                <div class="top">
                    <div class="logo">
                        <img src="{{ asset('img/Logo.svg') }}" alt="Film Fusion">
                        <h2><span class="blue">Film</span><span class="danger">Fusion</span></h2>
                    </div>
                    <div class="close" id="close-btn">
                        <span class="material-symbols-rounded">close</span>
                    </div>
                </div>

                <div class="sidebar">
                    <a href="{{ route('admin.dashboard') }}">
                        <span class="material-symbols-rounded">dashboard</span>
                        <h3>Dashboard</h3>
                    </a>
                    <a href="{{ route('admin.users') }}">
                        <span class="material-symbols-rounded">person</span>
                        <h3>Manage Users</h3>
                    </a>
                    <a href="{{ route('admin.movies') }}">
                        <span class="material-symbols-rounded">movie_edit</span>
                        <h3>Manage Movies</h3>
                    </a>
                    <a href="{{ route('admin.offers') }}">
                        <span class="material-symbols-rounded">universal_currency_alt</span>
                        <h3>Manage offers</h3>
                    </a>
                    <a href="{{ route('admin.analytics') }}">
                        <span class="material-symbols-rounded">insights</span>
                        <h3>Analytics</h3>
                    </a>
                    <a href="{{ route('admin.subscription-histroy') }}">
                        <span class="material-symbols-rounded">request_quote</span>
                        <h3>Subscription</h3>
                    </a>
                    <a href="{{ route('admin.refrel-histroy') }}">
                        <span class="material-symbols-rounded">loyalty</span>
                        <h3>Refrel Histroy</h3>
                    </a>
                    <a href="{{ route('logout') }}">
                        <span class="material-symbols-rounded">logout</span>
                        <h3>Logout</h3>
                    </a>
                </div>
            </aside>
            <!-- Note it is a hamburger menu -->
            <div class="right none">
                <div class="top">
                    <button id="menu-btn">
                        <span class="material-symbols-rounded">menu</span>
                    </button>
                </div>
            </div>
            <!-- ========== End of SideBar ========== -->
            <main id="main">
                @yield('container')
            </main>
        </div>
    </div>

    <!-- ========== Loader Js ========== -->
    <script src="{{ asset('js/resulable/loader.js') }}"></script>
    <!-- ========== JQUERY JS ========== -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentPath = window.location.pathname;
            var pathParts = currentPath.split('/'); // Split the path by slashes
            var currentPage = pathParts[pathParts.length - 1]; // Get the last part of the path

            var sidebarLinks = document.querySelectorAll('.sidebar a');
            sidebarLinks.forEach(function(link) {
                var linkHref = link.getAttribute('href');
                var linkPath = linkHref.split('/').pop(); // Get the last part of the link's path
                if (currentPage === linkPath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
    <!--=============== Jquery ===============-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    {{-- Toast Notificaations JS --}}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    {{-- Needed scripts --}}
    <script src="{{ asset('ajax/url.js') }}"></script>
    @stack('scripts')
</body>

</html>
