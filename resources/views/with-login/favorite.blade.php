@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush


@section('title')
    Watch Later
@endsection

@section('container')
    <br>
    <br>

    <!-- Movies section start -->
    <section class="movies container" id="movies">
        <!-- Heading -->
        <div class="heading">
            <h2 class="heading-title">
                Favorite
            </h2>
        </div>
        <!-- Movie Content -->
        <div class="movies-content">
            <!-- Movie Box -->
            <div class="movie-box">
                <img src="{{ asset('img/movie-6.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                <div class="box-text">
                    <h2 class="movie-title">
                        Money Heist
                    </h2>
                    <span class="movie-type">
                        Suspense
                    </span>
                    <a href="{{ route('user.play-page') }}" class="watch-btn play-btn">
                        <i class="bx bx-right-arrow"></i>
                    </a>
                </div>
            </div>
            <div class="movie-box">
                <img src="{{ asset('img/movie-7.jpg') }}" alt="" class="movie-box-img" loading="lazy">
                <div class="box-text">
                    <h2 class="movie-title">
                        The Wolverine
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
    </section>
@endsection