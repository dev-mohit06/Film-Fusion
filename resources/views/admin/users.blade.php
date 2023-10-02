@extends('blueprints.admin-main')

@section('title')
    Manage Users
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reusable/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reusable/btnfancy.css') }}">
    <link rel="stylesheet" href="{{ asset('css/resuable/data-loader.css') }}">
@endpush


@section('backdrop')
    <!-- ========== Backdrop for popups ========== -->
    <div class="backdrop" id="backdrop"></div>
@endsection

@section('container')
    <!-- ========== Starting of Fancy button ========== -->
    <div class="btn-container">
        <a class="button" id="adduserBtn">
            <div class="button__content">
                <span class="button__text">Add new user</span>
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
            <h1 style="margin-left: 25px">Users</h1>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Id </th>
                        <th> Username </th>
                        <th> Email </th>
                        <th> Status </th>
                        <th> Subscription Status </th>
                        <th> Operations </th>
                    </tr>
                </thead>
                <tbody class="userdata"></tbody>
            </table>
        </section>
    </div>
    <!-- ========== End of Table ========== -->

    <!-- ========== Starting of Add user form ========== -->
    <div class="user-add-form" id="add-form">
        <section class="form-container">
            <h1>Add User</h1>
            <div class="close-popup" id="adduser_popup_close">
                <span class="material-symbols-rounded">close</span>
            </div>
            <div class="dif"></div>
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
    <!-- ========== End of Add user form ========== -->

    <!-- ========== Starting of Update user form ========== -->
    <div class="user-update-form" id="update-form">
        <section class="form-container">
            <h1>Update user</h1>
            <div class="close-popup" id="updateuser_popup_close">
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
    <script src="{{ asset('ajax/Admin/Users/users.js') }}"></script>
@endpush
