@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/play-page.css') }}">
@endpush


@section('title')
    {{ $movie_data->movie_name }}
@endsection

@section('current-nav-item')
    nav-active
@endsection

@section('container')
    <!-- Moive Section -->
    <div class="play-container container">
        <!-- Play movie image -->
        <img src="{{ asset('movies-imgs/banners/' . $movie_data->movie_banner . '') }}" alt="{{ $movie_data->movie_name }}"
            class="play-img" loading="lazy">
        <!-- Play Text -->
        <div class="play-text">
            <h2>{{ $movie_data->movie_name }}</h2>
            <div class="tags">
                <span>{{ $movie_data->category }}</span>
            </div>
        </div>
        <!-- Movie Watch Button -->
        <i class="bx bx-right-arrow play-movie"></i>
        <!-- Video Container -->
        <div class="video-container">
            <!-- Video-Box -->
            <div class="video-box">
                <video id="myvideo" src="{{ asset('movies/' . $movie_data->movie_file . '') }}" controls></video>
                <!-- Close Video Icon -->
                <i class="bx bx-x close-video"></i>
            </div>
        </div>
    </div>
    <!-- End Movie Section -->

    <!-- About -->
    <div class="about-movie container">
        <!-- Rating -->
        <div class="rating">
            <div class="like">
                <i class='bx bx-like' id="like" title="like"></i>
                <p id="global-like"></p>
            </div>
            <div class="dislike">
                <i class='bx bx-dislike' id="dislike" title="dislike"></i>
                <p id="global-dislike"></p>
            </div>
            <div class="dislike">
                <i class='bx bx-heart' id="favorite" title="favorite"></i>
                <p>Add to favorite</p>
            </div>
            <div class="dislike">
                <i class='bx bx-list-plus' id="watch-lator" title="watch later"></i>
                <p>Watch Later</p>
            </div>
        </div>
        <h2>
            {{ $movie_data->movie_name }}
        </h2>
        <p>
            {{ $movie_data->movie_description }}
        </p>

        <!-- Download -->
        <div class="download">
            <h2 class="download-title">
                Download Movie
                <div class="download-links">
                    <a href="{{ asset('movies/' . $movie_data->movie_file . '') }}" download>Download</a>
                </div>
            </h2>
        </div>

        <br><br>
        <h2>Must watch movies</h2>
        <br>
        <div class="movies-content">
            <!-- Movie Box -->
            @foreach ($allMovies as $movie)
                <div class="movie-box">
                    <img src="{{ asset('movies-imgs/posters/' . $movie->movie_poster . '') }}" style="object-fit: cover;"
                        alt="{{ $movie_data->movie_name }}" class="movie-box-img" loading="lazy">
                    <div class="box-text">
                        <h2 class="movie-title">
                            {{ $movie->movie_name }}
                        </h2>
                        <a href="{{ route('user.play-page', ['movie_id' => $movie->id]) }}"class="watch-btn play-btn">
                            <i class="bx bx-right-arrow"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('copyright')
    <br>
    <div class="copyright next-page" style="margin-top: -25px">
        <p>&copy; FilmFusion All Right Reserved</p>
    </div>
    <br>
@endsection

@push('scripts')
    <!-- ========== JAVASCRIPTS ========== -->
    <script src="{{ asset('ajax/url.js') }}"></script>
    <script src="{{ asset('js/play-page.js') }}"></script>
    <script>
        let movie_id = {{ $movie_data->id }};
        let user_id = {{ session()->get('id') }};
    </script>
    <script src="{{ asset('ajax/Play-page/play-page.js') }}"></script>
@endpush
