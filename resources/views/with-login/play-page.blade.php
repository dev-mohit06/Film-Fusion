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
        <img src="{{ asset('movies-imgs/banners/' . $movie_data->movie_banner . '') }}" alt="" class="play-img"
            loading="lazy">
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
                <i class='bx bx-heart' title="favorite"></i>
                <p>Add to favorite</p>
            </div>
            <div class="dislike">
                <i class='bx bx-list-plus' title="watch later"></i>
                <p>Watch Later</p>
            </div>
        </div>
        <h2>
            {{ $movie_data->movie_name }}
        </h2>
        <p>
            {{ $movie_data->movie_description }}

        </p>
    </div>

    <!-- Download -->
    <div class="download">
        <h2 class="download-title">
            Download Movie
            <div class="download-links">
                <a href="{{ asset('movies/' . $movie_data->movie_file . '') }}" download>Download</a>
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
    <script>
        let movie_id = {{ $movie_data->id }};
    </script>
    <script>
        $(document).ready(function() {

            let likeCounter = $("#global-like");
            let dislikeCounter = $("#global-dislike");

            let like = $("#like");
            let dislike = $("#dislike");


            function getAnalytics() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.play-page.getAnalytics') }}",
                    data: {
                        movie_id: movie_id,
                    },
                    success: function(response) {
                        likeCounter.html(response.analytics.likes);
                        dislikeCounter.html(response.analytics.dislikes);

                        if (response.is_respond) {
                            if (response.user_preference.is_liked) {
                                like.removeClass("bx-like");
                                like.addClass("bxs-like");
                            } else {
                                like.removeClass("bxs-like");
                                like.addClass("bx-like");
                            }

                            if (response.user_preference.is_disliked) {
                                dislike.removeClass("bx-dislike");
                                dislike.addClass("bxs-dislike");
                            } else {
                                dislike.removeClass("bxs-dislike");
                                dislike.addClass("bx-dislike");
                            }
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
            getAnalytics();

            like.on("click", function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.play-page.giveAnalytics') }}",
                    data: {
                        movie_id: movie_id,
                        btn: "like",
                    },
                    beforeSend: function() {
                        if (like.hasClass("bx-like")) {
                            like.removeClass("bx-like");
                        } else if (like.hasClass("bxs-like")) {
                            like.removeClass("bxs-like");
                        }
                        like.addClass("bx-loader-alt bx-spin");
                    },
                    success: function(response) {
                        getAnalytics();
                        like.removeClass("bx-loader-alt bx-spin");
                    }
                });
            });

            dislike.on("click", function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.play-page.giveAnalytics') }}",
                    data: {
                        movie_id: movie_id,
                        btn: "dislike",
                    },
                    beforeSend: function() {
                        if (dislike.hasClass("bx-dislike")) {
                            dislike.removeClass("bx-dislike");
                        } else if (dislike.hasClass("bxs-dislike")) {
                            dislike.removeClass("bxs-dislike");
                        }
                        dislike.addClass("bx-loader-alt bx-spin");
                    },
                    success: function(response) {
                        getAnalytics();
                        dislike.removeClass("bx-loader-alt bx-spin");
                    }
                });
            });
        });
    </script>
@endpush
