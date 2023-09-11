@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/play-page.css') }}">
@endpush


@section('title')
    Film Fusion - Home
@endsection

@section('current-nav-item')
    nav-active
@endsection

@section('container')
    <!-- Moive Section -->
    <div class="play-container container">
        <!-- Play movie image -->
        <img src="{{ asset('img/play-background.jpg') }}" alt="" class="play-img" loading="lazy">
        <!-- Play Text -->
        <div class="play-text">
            <h2>Jumanji: Welcome to the Jungel</h2>
            <div class="tags">
                <span>Action</span>
            </div>
        </div>
        <!-- Movie Watch Button -->
        <i class="bx bx-right-arrow play-movie"></i>
        <!-- Video Container -->
        <div class="video-container">
            <!-- Video-Box -->
            <div class="video-box">
                <video id="myvideo" src="{{ asset('movies/Jumanji.mp4') }}" controls></video>
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
                <i class='bx bx-like' title="like"></i>
                <p>86%</p>
            </div>
            <div class="dislike">
                <i class='bx bx-dislike' title="dislike"></i>
                <p>14%</p>
            </div>
            <div class="dislike">
                <i class='bx bx-heart' title="favorite"></i>
                <p>Add to favorite</p>
            </div>
            <div class="dislike">
                <i class='bx bx-list-plus' title="watch later"></i>
                <p>Watch Later</p>
            </div>
        </div>
        <h2>
            Jumanji: Welcome to the Jungel
        </h2>
        <p>
            Four high schoolers discover an old video game console and are transported into its jungle world. To escape,
            they must survive dangerous challenges, uncover forgotten secrets, and change their perspectives. Failure
            means being stuck forever.
        </p>
    </div>

    <!-- Download -->
    <div class="download">
        <h2 class="download-title">
            Download Movie
            <div class="download-links">
                <a href="{{ asset('movies/Jumanji.mp4') }}" download>Download</a>
            </div>
        </h2>
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
    <script src="{{ asset('js/play-page.js') }}"></script>
@endpush
