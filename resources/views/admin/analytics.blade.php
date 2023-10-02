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
                <tbody class="table-data"></tbody>
            </table>
        </section>
    </div>
    <!-- ========== End of Table ========== -->
@endsection
@push('scripts')
    <script src="{{ asset('ajax/Analytics/analytics.js') }}"></script>
@endpush
