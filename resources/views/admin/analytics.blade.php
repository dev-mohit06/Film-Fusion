@extends('blueprints.admin-main')

@section('title')
    Dashboard
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/movies.css') }}">
    <link rel="stylesheet" href="{{ asset('css/analytics.css') }}">
@endpush

@section('container')
    <!-- ========== Starting of Table ========== -->
    <div class="table-parent">
        <section class="table__header">
            <h1>Analytics</h1>
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
                        <th> Like </th>
                        <th> Dislike </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="{{ asset('img/movies-imgs/movie-1.jpg') }}" alt="">
                        </td>
                        <td class="movie-title-font">Jumanji: Welcome to the Jungel</td>
                        <td>Action</td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded active">thumb_up</span>
                                <p>89</p>
                            </div>
                        </td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded danger">thumb_down</span>
                                <p>11</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <img src="{{ asset('img/movies-imgs/movie-2.jpg') }}" alt="">
                        </td>
                        <td class="movie-title-font">Hitman's Wife's Bodyguard</td>
                        <td>Thriller</td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded active">thumb_up</span>
                                <p>90</p>
                            </div>
                        </td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded danger">thumb_down</span>
                                <p>10</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <img src="{{ asset('img/movies-imgs/movie-3.jpg') }}" alt="">
                        </td>
                        <td class="movie-title-font">Shang-Chi and the Legend of the Ten Rings</td>
                        <td>Action</td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded active">thumb_up</span>
                                <p>69</p>
                            </div>
                        </td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded danger">thumb_down</span>
                                <p>31</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <img src="{{ asset('img/movies-imgs/movie-4.jpg') }}" alt="">
                        </td>
                        <td class="movie-title-font">Eternals</td>
                        <td>Advanture</td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded active">thumb_up</span>
                                <p>99</p>
                            </div>
                        </td>
                        <td>
                            <div class="count-container">
                                <span class="material-symbols-rounded danger">thumb_down</span>
                                <p>1</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
    <!-- ========== End of Table ========== -->
@endsection
@push('scripts')
    <script src="{{ asset('js/resulable/sidebar.js') }}"></script>
    <script src="{{ asset('js/resulable/search.js') }}"></script>
@endpush
