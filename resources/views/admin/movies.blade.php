@extends('blueprints.admin-main')

@section('title')
    Dashboard
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/movies.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reusable/btnfancy.css') }}">
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
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <span class="material-symbols-rounded">search</span>
            </div>
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
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="{{ asset('img/movies-imgs/movie-1.jpg') }}" alt="">
                        </td>
                        <td class="movie-title-font">Jumanji: Welcome to the Jungel</td>
                        <td class="movie-category-font">Action</td>
                        <td class="movie-category-font">Slider</td>
                        <td>23-10-2023</td>
                        <td>
                            <p class="status delivered update-form pointer updatemovie_popup">
                                Update
                            </p>
                            <br>
                            <p class="status cancelled delete-btn pointer">
                                Delete
                            </p>
                        </td>
                    </tr>
                </tbody>
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
            <form action="#" class="form" id="insert-movie-form">
                <div class="input-box">
                    <label>Movie Name</label>
                    <input type="text" placeholder="Movie name" id="movie-name" required />
                    <span class="err" id="err-movie-name"></span>
                </div>
                <div class="input-box">
                    <label>Description</label>
                    <input type="text" placeholder="About the movie" id="movie-desc" required />
                    <span class="err" id="err-movie-desc"></span>
                </div>
                <div class="column">
                    <div class="select-box">
                        <select>
                            <option hidden>Category</option>
                            <option value="action">Action</option>
                            <option value="advanture">Advanture</option>
                            <option value="comady">Comady</option>
                        </select>

                        <span class="err"></span>
                    </div>
                    <div class="select-box">
                        <select>
                            <option hidden>Ott Category</option>
                            <option value="slider">Slider</option>
                            <option value="popular">Popular</option>
                        </select>
                        <span class="err"></span>
                    </div>
                </div>
                <div class="input-box">
                    <label>Release Date</label>
                    <input type="date" placeholder="Movie name" required />
                    <span class="err"></span>
                </div>

                <div class="column">
                    <div class="input-box">
                        <label>Movie Poster</label>
                        <input type="file" placeholder="Movie name" id="hero-pic" required />
                        <span class="err" id="err-hero-pic"></span>
                    </div>
                    <div class="input-box">
                        <label>Movie Banner</label>
                        <input type="file" placeholder="Movie name" id="banner" required />
                        <span class="err" id="err-banner"></span>
                    </div>
                </div>

                <div class="input-box">
                    <label>Movie File</label>
                    <input type="file" placeholder="Movie name" id="movie-file" required />
                    <span class="err" id="err-movie-file"></span>
                </div>
                <button>Submit</button>
            </form>
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
            <form action="#" class="form" id="updaet-movie-form">
                <div class="input-box">
                    <label>Movie Name</label>
                    <input type="text" placeholder="Movie name" id="update-movie-name" required />
                    <span class="err" id="err-update-movie-name"></span>
                </div>
                <div class="input-box">
                    <label>Description</label>
                    <input type="text" placeholder="About the movie" id="update-movie-desc" required />
                    <span class="err" id="err-update-movie-desc"></span>
                </div>
                <div class="column">
                    <div class="select-box">
                        <select>
                            <option hidden>Category</option>
                            <option value="action">Action</option>
                            <option value="advanture">Advanture</option>
                            <option value="comady">Comady</option>
                        </select>

                        <span class="err"></span>
                    </div>
                    <div class="select-box">
                        <select>
                            <option hidden>Ott Category</option>
                            <option value="slider">Slider</option>
                            <option value="popular">Popular</option>
                        </select>
                        <span class="err"></span>
                    </div>
                </div>
                <div class="input-box">
                    <label>Release Date</label>
                    <input type="date" placeholder="Movie name" required />
                    <span class="err"></span>
                </div>

                <div class="column">
                    <div class="input-box">
                        <label>Movie Poster</label>
                        <input type="file" placeholder="Movie name" id="update-hero-pic" required />
                        <span class="err" id="err-update-hero-pic"></span>
                    </div>
                    <div class="input-box">
                        <label>Movie Banner</label>
                        <input type="file" placeholder="Movie name" id="update-banner" required />
                        <span class="err" id="err-update-banner"></span>
                    </div>
                </div>

                <div class="input-box">
                    <label>Movie File</label>
                    <input type="file" placeholder="Movie name" id="update-movie-file" required />
                    <span class="err" id="err-update-movie-file"></span>
                </div>
                <button>Submit</button>
            </form>
        </section>
    </div>
    <!-- ========== End of Update user form ========== -->
@endsection
@push('scripts')
    <script src="{{ asset('js/resulable/sidebar.js') }}"></script>
    <script src="{{ asset('js/resulable/search.js') }}"></script>
    <script src="{{ asset('js/admin-movie.js') }}"></script>
@endpush