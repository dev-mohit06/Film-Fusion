@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush


@section('title')
    Histroy
@endsection

@section('container')
    <br>
    <br>

    <!-- Movies section start -->
    <section class="movies container" id="movies">
        <!-- Heading -->
        <div class="heading">
            <h2 class="heading-title">
                Histroy
            </h2>
        </div>
        <!-- Movie Content -->
        <div class="movies-content">
            <!-- Movie Box -->
            @if ($movie_count)
                @foreach ($histroy as $movie)
                    <div class="movie-box">
                        <img src="{{ asset('movies-imgs/posters/' . $movie->movie_poster . '') }}" alt="" class="movie-box-img"
                            loading="lazy">
                        <div class="box-text">
                            <h2 class="movie-title">
                                {{ $movie->movie_name }}
                            </h2>
                            <span class="movie-type">
                                {{ $movie->category }}
                            </span>
                            <a href="{{ route('user.play-page', ['movie_id' => $movie->id]) }}" class="watch-btn play-btn">
                                <i class="bx bx-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="heading-title" style="text-align: center; margin-top: 3rem;">Please watch some movies and come
                    back later!!</p>
            @endif
        </div>
    </section>
@endsection
