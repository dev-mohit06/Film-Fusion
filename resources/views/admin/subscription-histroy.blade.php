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
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody class="table-data"></tbody>
            </table>
        </section>
    </div>
    <!-- ========== End of Table ========== -->
@endsection
@push('scripts')
    <script src="{{ asset('ajax/Subscription-histroy/subscription-histroy.js') }}"></script>
@endpush
