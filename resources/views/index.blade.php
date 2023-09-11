@extends('blueprints.without-login-main')

@section('title')
    Film Fusion
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

@section('container')
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">
                <img src="{{ asset('img/Logo.svg') }}" alt="">
            </a>

            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="#home" class="nav__link active-link">Home</a>
                    </li>
                    <li class="nav__item">
                        <a href="#features" class="nav__link">Features</a>
                    </li>
                    <li class="nav__item">
                        <a href="#what" class="nav__link">What to do?</a>
                    </li>
                    <li class="nav__item">
                        <a href="{{ route('login') }}" class="nav__link">Get started</a>
                    </li>
                </ul>

                <div class="nav__close" id="nav-close">
                    <i class="ri-close-line"></i>
                </div>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-function-line"></i>
            </div>
        </nav>
    </header>

    <main class="main">
        <!--=============== HOME ===============-->
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div>
                    <img src="{{ asset('img/Movie Night-bro.svg') }}" alt="" class="home__img">
                </div>

                <div class="home__data">
                    <div class="home__header">
                        <h2 class="home__subtitle">Film Fusion</h2>
                    </div>

                    <div class="home__footer">
                        <h3 class="home__title-description">Overview</h3>
                        <p class="home__description">Film Fusion is your one-stop online movie hub, dedicated to bringing
                            you a diverse collection of the latest blockbuster films, indie gems, timeless classics, and
                            everything in between. With an easy-to-navigate interface and an extensive movie library, we
                            strive to provide an unparalleled movie-watching experience for cinephiles of all tastes.
                        </p>
                        <a href="{{ route('login') }}" class="button button--flex">
                            <span class="button--flex">
                                Get Started
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!--=============== Features ===============-->
        <section class="specs section grid" id="features">
            <h2 class="section__title section__title-gradient">Features</h2>

            <div class="specs__container container grid">
                <div class="specs__content grid">
                    <div class="specs__data">
                        <i class="ri-movie-2-line specs__icon"></i>
                        <h3 class="specs__title">Stream Movies Online</h3>
                        <!-- <span class="specs__subtitle">without the need for downloads</span> -->
                    </div>

                    <div class="specs__data">
                        <i class="ri-download-line specs__icon"></i>
                        <h3 class="specs__title">Offline Enjoyment</h3>
                    </div>

                    <div class="specs__data">
                        <i class="ri-user-heart-fill specs__icon"></i>
                        <h3 class="specs__title">Recommendations</h3>
                    </div>

                    <div class="specs__data">
                        <i class="ri-vip-diamond-fill specs__icon"></i>
                        <h3 class="specs__title">Exclusive Content</h3>
                    </div>

                    <div class="specs__data">
                        <i class="ri-more-fill specs__icon"></i>
                        <h3 class="specs__title">And many more</h3>
                    </div>
                </div>

                <div>
                    <img src="{{ asset('img/Mobile inbox-pana.svg') }}" alt="" class="specs__img">
                </div>
            </div>
        </section>

        <!--=============== WHATTODO ===============-->
        <section class="case section grid" id="what">
            <h2 class="section__title section__title-gradient">Now what to do?</h2>

            <div class="case__container container grid">
                <div>
                    <img src="{{ asset('img/Problem solving-bro.svg') }}" alt="" class="case__img">
                </div>

                <div class="case__data">
                    <p class="case__description">Unleash cinema magic with Film Fusion! Access our film library, elevate
                        movie-watching with our premium plan. Join now and let the marathon begin!.
                    </p>
                    <a href="{{ route('login') }}" class="button button--flex">
                        Get Started
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!--=============== FOOTER ===============-->
    <footer class="footer section">
        <p class="footer__copy">
            <a href="#" target="_blank" class="footer__copy-link">&#169; Film Fusion. All right reserved</a>
        </p>
    </footer>

    <!--=============== SCROLL UP ===============-->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-s-line scrollup__icon"></i>
    </a>
@endsection

@push('scripts')
    <!--=============== SCROLL REVEAL ===============-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--=============== MAIN JS ===============-->
    <script src="{{ asset('js/without-login-main.js') }}"></script>
@endpush
