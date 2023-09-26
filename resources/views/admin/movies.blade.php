@extends('blueprints.admin-main')

@section('title')
    Manage Movies
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/movies.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reusable/btnfancy.css') }}">
    <link rel="stylesheet" href="{{ asset('css/resuable/data-loader.css') }}">
    <style>
        .hideProgress {
            display: none;
        }
    </style>
@endpush


@section('backdrop')
    <!-- ========== Backdrop for popups ========== -->
    <div class="backdrop" id="backdrop"></div>
@endsection

@section('container')
    <!-- ========== Starting of Fancy button ========== -->
    <div class="btn-container">
        <a class="button" id="addmovie_popup">
            <div class="button__content">
                <span class="button__text">Add new movie</span>
                <i class="ri-download-cloud-fill button__icon"></i>

                <div class="button__reflection-1"></div>
                <div class="button__reflection-2"></div>
            </div>

            <img src="{{ asset('img/btn-fancy/star.svg') }}" alt="" class="button__star-1">
            <img src="{{ asset('img/btn-fancy/star.svg') }}" alt="" class="button__star-2">
            <img src="{{ asset('img/btn-fancy/circle.svg') }}" alt="" class="button__circle-1">
            <img src="{{ asset('img/btn-fancy/diamond.svg') }}" alt="" class="button__diamond">

            <div class="button__shadow"></div>
        </a>
    </div>
    <!-- ========== End of Fancy button ========== -->

    <!-- ========== Starting of Table ========== -->
    <div class="table-parent">
        <section class="table__header">
            <h1>Movies</h1>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> No. </th>
                        <th> Poster </th>
                        <th> Name </th>
                        <th> Category </th>
                        <th> Ott Category </th>
                        <th> Release Date </th>
                        <th> Operations </th>
                    </tr>
                </thead>
                <tbody class="movies-container"></tbody>
            </table>
        </section>
    </div>
    <!-- ========== End of Table ========== -->

    <!-- ========== Starting of Add movie form ========== -->
    <div class="user-add-form" id="add-form">
        <section class="form-container">
            <h1>Add Movie</h1>
            <div class="close-popup" id="addmovie_popup_close">
                <span class="material-symbols-rounded">close</span>
            </div>
            <div class="dif">
                <form class="form" id="insert-movie-form" enctype="multipart/form-data">
                    @csrf
                    <div class="input-box">
                        <label>Movie Name</label>
                        <input type="text" placeholder="Movie name" id="movie-name" name="movie_name" required />
                        <span class="err" id="err-movie-name"></span>
                    </div>
                    <div class="input-box">
                        <label>Description</label>
                        <input type="text" placeholder="About the movie" id="movie-desc" name="movie_desc" required />
                        <span class="err" id="err-movie-desc"></span>
                    </div>
                    <div class="column">
                        <div class="select-box">
                            <select required name="category">
                                <option disabled>Category</option>
                                <option value="action" selected>Action</option>
                                <option value="advanture">Advanture</option>
                                <option value="comady">Comady</option>
                                <option value="drama">Drama</option>
                                <option value="sifi">Science Fiction</option>
                                <option value="fantasy">Fantasy</option>
                                <option value="horror">Horror</option>
                                <option value="thriller">Thriller</option>
                                <option value="romantic">Romantic</option>
                            </select>

                            <span class="err"></span>
                        </div>
                        <div class="select-box">
                            <select required name="ott_category">
                                <option disabled>Ott Category</option>
                                <option value="all" selected>All</option>
                                <option value="slider">Slider</option>
                                <option value="popular">Popular</option>
                            </select>
                            <span class="err"></span>
                        </div>
                    </div>

                    <div class="column">
                        <div class="input-box">
                            <label>Movie Poster</label>
                            <input type="file" placeholder="Movie name" id="hero-pic" name="poster" required />
                            <span class="err" id="err-hero-pic"></span>
                        </div>
                        <div class="input-box">
                            <label>Movie Banner</label>
                            <input type="file" placeholder="Movie name" id="banner" name="banner" required />
                            <span class="err" id="err-banner"></span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Movie File</label>
                        <input type="file" placeholder="Movie name" id="movie-file" name="movie_file" required />
                        <span class="err" id="err-movie-file"></span>
                        <label class="hideProgress" id="progressTitle">Progress of file uploading</label>
                        <progress id="progressBar" class="hideProgress" value="0" max="100"
                            style="width:100%;"></progress>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </section>
    </div>
    <!-- ========== End of Add user form ========== -->

    <!-- ========== Starting of Update user form ========== -->
    <div class="user-update-form" id="update-form">
        <section class="form-container">
            <h1>Edit Details</h1>
            <div class="close-popup" id="updatemovie_popup_close">
                <span class="material-symbols-rounded">close</span>
            </div>
            <div class="duf"></div>
            <div class="data-loader">
                <div class="lds-roller">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </section>
    </div>
    <!-- ========== End of Update user form ========== -->
@endsection
@push('scripts')
    <script src="{{ asset('js/resulable/sidebar.js') }}"></script>
    <script src="{{ asset('ajax/Admin/Movies/movies.js') }}"></script>
@endpush
