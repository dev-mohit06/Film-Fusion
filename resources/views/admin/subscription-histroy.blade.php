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
            <h1>Subscription Histroy</h1>
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
                        <th> Username </th>
                        <th> Subscription Type </th>
                        <th> Purchase date </th>
                        <th> Expire date </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>___mohit06</td>
                        <td>Premium Mini</td>
                        <td>20-3-2023</td>
                        <td>20-4-2023</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>kandarp02</td>
                        <td>Ultimate</td>
                        <td>20-2-2023</td>
                        <td>20-3-2023</td>
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
