<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- ========== CSS ========== -->
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <!-- ========== Favicon ========== -->
    <link rel="shortcut icon" href="{{ asset('img/Logo.svg') }}" type="image/x-icon">
    <!-- ========== Box Icons ========== -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- Toast Notificaations CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

</head>

<body>
    <!-- Staring of loader -->
    <div class="loader">
        <div class="scene">
            <div class="cube-wrapper">
                <div class="cube">
                    <div class="cube-faces">
                        <div class="cube-face shadow"></div>
                        <div class="cube-face bottom"></div>
                        <div class="cube-face top"></div>
                        <div class="cube-face left"></div>
                        <div class="cube-face right"></div>
                        <div class="cube-face back"></div>
                        <div class="cube-face front"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of laoder -->

    <!-- ========== HEADER ========== -->
    <header>
        <!-- Nav -->
        <div class="nav container">
            <!-- Logo -->
            <a href="./index.html" class="logo">
                <img src="{{ asset('img/Logo.svg') }}" alt="Logo">
                <div>
                    <span class="span-1">Film</span><span class="span-2">Fusion</span>
                </div>
            </a>
            <!-- Search box -->
            <!-- <div class="search-box">
                <input type="search" name="" id="search-input" placeholder="Search Movie" autocomplete="off">
                <i class='bx bx-search'></i>
            </div> -->
            <!-- User -->
            <a href="#" class="user">
                <img src="{{ asset('users/profile_pictures/' . session()->get('dp') . '') }}" alt="profile-picture">
            </a>

            <!-- NavBar or Sidebar -->
            <div class="navbar">
                <a href="{{ route('user.home') }}" class="nav-link">
                    <i class="bx bxs-home"></i>
                    <span class="nav-link-title">Home</span>
                </a>
                <a href="{{ route('user.watch-later') }}" class="nav-link">
                    <i class='bx bx-list-plus'></i>
                    <span class="nav-link-title">Watch Later</span>
                </a>
                <a href="{{ route('user.favorite') }}" class="nav-link">
                    <i class="bx bxs-heart"></i>
                    <span class="nav-link-title">Favorite</span>
                </a>
                <a href="{{ route('user.history') }}" class="nav-link">
                    <i class='bx bx-history'></i>
                    <span class="nav-link-title">Histroy</span>
                </a>
                <a href="{{ route('user.settings') }}" class="nav-link">
                    <i class="bx bxs-cog"></i>
                    <span class="nav-link-title">Setting</span>
                </a>
                @if (session()->get('role') == 1)
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="bx bxs-business"></i>
                        <span class="nav-link-title">Admin Panel</span>
                    </a>
                @endif
                <a href="{{ route('logout') }}" class="nav-link">
                    <i class="bx bx-undo"></i>
                    <span class="nav-link-title">Logout</span>
                </a>
            </div>
        </div>
    </header>
    <!-- ========== END HEADER ========== -->
    <div class="master-container">
        @yield('container')
        <!-- Copyright marko -->
        <br>
        <div class="copyright next-page" style="margin-top: -25px">
            <p>&copy; FilmFusion All Right Reserved</p>
        </div>
        <br>
    </div>
    <script src="{{ asset('js/loader.js') }}"></script>
    <!--=============== Jquery ===============-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    {{-- Toast Notificaations JS --}}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>


    <script>
        // Get the current URL path
        var currentPath = window.location.pathname;
        var pathParts = currentPath.split('/'); // Split the path by slashes
        var currentPage = pathParts[pathParts.length - 1]; // Get the last part of the path

        // Find and activate the corresponding navigation link
        var navLinks = document.querySelectorAll('.navbar .nav-link');
        navLinks.forEach(function(link) {
            var linkHref = link.getAttribute('href');
            var linkPath = linkHref.split('/').pop(); // Get the last part of the link's path
            if (currentPage === linkPath) {
                link.classList.add('nav-active');
            } else {
                link.classList.remove('nav-active');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
