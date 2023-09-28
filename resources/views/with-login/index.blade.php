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

            @foreach ($sliderMovies as $movie)
                <div class="swiper-slide">
                    <section class="home container" id="home">
                        <!-- Home Image -->
                        <img src="{{ asset('movies-imgs/banners/' . $movie->movie_banner . '') }}" alt=""
                            class="home-img">
                        <!-- Home Text -->
                        <div class="home-text">
                            <h1 class="home-title">
                                {{ $movie->movie_name }}
                            </h1>
                            <a href="{{ route('user.play-page',['movie_id'=>$movie->id]) }}" class="watch-btn">
                                <i class="bx bx-right-arrow"></i>
                                <span>Watch the movie</span>
                            </a>
                        </div>
                    </section>
                </div>
            @endforeach
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
                @foreach ($popularMovies as $movie)
                    <div class="swiper-slide">
                        <div class="movie-box">
                            <img src="{{ asset('movies-imgs/posters/' . $movie->movie_poster . '') }}" alt=""
                                class="movie-box-img" loading="lazy">
                            <div class="box-text">
                                <h2 class="movie-title">
                                    {{ $movie->movie_name }}
                                </h2>
                                <span class="movie-type">
                                    {{ $movie->category }}
                                </span>
                                <a href="{{ route('user.play-page',['movie_id'=>$movie->id]) }}" class="watch-btn play-btn">
                                    <i class="bx bx-right-arrow"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Movie Box -->
            </div>
        </div>
    </section>
    <!-- Popular section end -->

    <!-- Movies section start -->
    <section class="movies container" id="movies">
        <!-- Heading -->
        <div class="heading">
            <h2 class="heading-title">
                All Movies
            </h2>
        </div>
        <!-- Movie Content -->
        <div class="movies-content">
            <!-- Movie Box -->
            @foreach ($allMovies as $movie)
                <div class="movie-box">
                    <img src="{{ asset('movies-imgs/posters/' . $movie->movie_poster . '') }}" alt="" class="movie-box-img" loading="lazy">
                    <div class="box-text">
                        <h2 class="movie-title">
                            {{ $movie->movie_name }}
                        </h2>
                        <span class="movie-type">
                            {{ $movie->category }}
                        </span>
                        <a href="{{ route('user.play-page',['movie_id'=>$movie->id]) }}"class="watch-btn play-btn">
                            <i class="bx bx-right-arrow"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
    <!-- ========== Swiper JS ========== -->
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <!-- ========== JAVASCRIPTS ========== -->
    <script src="{{ asset('js/with-login-main.js') }}"></script>
@endpush
