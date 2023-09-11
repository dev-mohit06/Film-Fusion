@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
@endpush


@section('title')
    Home
@endsection

@section('container')
    <!-- Swiper -->
    <div class="swiper home-content">
        <div class="swiper-wrapper">
            <!-- First promition movie -->
            <div class="swiper-slide">
                <section class="home container" id="home">
                    <!-- Home Image -->
                    <img src="{{ asset('img/banner-1.jpg') }}" alt="" class="home-img">
                    <!-- Home Text -->
                    <div class="home-text">
                        <h1 class="home-title">
                            Ford vs Ferrari
                        </h1>
                        <a href="{{ route('user.play-page') }}" class="watch-btn">
                            <i class="bx bx-right-arrow"></i>
                            <span>Watch the movie</span>
                        </a>
                    </div>
                </section>
            </div>
            <!-- Second promition movie -->
            <div class="swiper-slide">
                <section class="home container" id="home">
                    <!-- Home Image -->
                    <img src="{{ asset('img/banner-2.jpg') }}" alt="" class="home-img">
                    <!-- Home Text -->
                    <div class="home-text">
                        <h1 class="home-title">
                            Fast and Furious 8
                        </h1>
                        <span class="home-category">Action</span>
                        <a href="{{ route('user.play-page') }}" class="watch-btn">
                            <i class="bx bx-right-arrow"></i>
                            <span>Watch the movie</span>
                        </a>
                    </div>
                </section>
            </div>
        </div>
        <div class="swiper-pagination home-swiper"></div>
    </div>
    <!-- Swiper end -->

    <!-- Popular section start -->
    <section class="popular container" id="popular">
        <!-- Heading -->
        <div class="heading">
            <h2 class="heading-title">
                Popular Movies
            </h2>
            <!-- Swiper Buttons -->
            <div class="swiper-btn">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

        <!-- Content -->
        <div class="popular-content swiper">
            <div class="swiper-wrapper">
                <!-- Movie Box -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="{{ asset('img/popular-movie-1.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                        <div class="box-text">
                            <h2 class="movie-title">
                                No Way Home
                            </h2>
                            <span class="movie-type">
                                Action
                            </span>
                            <a href="{{ route('user.play-page') }}" class="watch-btn play-btn">
                                <i class="bx bx-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Movie Box -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="{{ asset('img/popular-movie-2.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                        <div class="box-text">
                            <h2 class="movie-title">
                                Jungle Cruise
                            </h2>
                            <span class="movie-type">
                                Adventure
                            </span>
                            <a href="{{ route('user.play-page') }}" class="watch-btn play-btn">
                                <i class="bx bx-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Movie Box -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="{{ asset('img/popular-movie-3.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                        <div class="box-text">
                            <h2 class="movie-title">
                                Loki
                            </h2>
                            <span class="movie-type">
                                Action
                            </span>
                            <a href="{{ route('user.play-page') }}" class="watch-btn play-btn">
                                <i class="bx bx-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Popular section end -->

    <!-- Movies section start -->
    <section class="movies container" id="movies">
        <!-- Heading -->
        <div class="heading">
            <h2 class="heading-title">
                Movies
            </h2>
        </div>
        <!-- Movie Content -->
        <div class="movies-content">
            <!-- Movie Box -->
            <!-- Movie Box -->
            <div class="movie-box">
                <img src="{{ asset('img/movie-1.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                <div class="box-text">
                    <h2 class="movie-title">
                        Jumanji - welcome to the jungle
                    </h2>
                    <span class="movie-type">
                        Adventure
                    </span>
                    <a href="{{ route('user.play-page') }}"class="watch-btn play-btn">
                        <i class="bx bx-right-arrow"></i>
                    </a>
                </div>
            </div>
            <div class="movie-box">
                <img src="{{ asset('img/movie-2.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                <div class="box-text">
                    <h2 class="movie-title">
                        Jumanji - welcome to the jungle
                    </h2>
                    <span class="movie-type">
                        Adventure
                    </span>
                    <a href="{{ route('user.play-page') }}"class="watch-btn play-btn">
                        <i class="bx bx-right-arrow"></i>
                    </a>
                </div>
            </div>
            <div class="movie-box">
                <img src="{{ asset('img/movie-3.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                <div class="box-text">
                    <h2 class="movie-title">
                        Jumanji - welcome to the jungle
                    </h2>
                    <span class="movie-type">
                        Adventure
                    </span>
                    <a href="{{ route('user.play-page') }}"class="watch-btn play-btn">
                        <i class="bx bx-right-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- ========== Swiper JS ========== -->
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <!-- ========== JAVASCRIPTS ========== -->
    <script src="{{ asset('js/with-login-main.js') }}"></script>
@endpush