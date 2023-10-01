@extends('blueprints.admin-main')

@section('title')
    Plans
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
        <a class="button" id="adduser_popup">
            <div class="button__content">
                <span class="button__text">Add new plan</span>
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
            <h1>Plans</h1>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Id </th>
                        <th> Plan Name </th>
                        <th> Duration </th>
                        <th> Status </th>
                        <th> Registered Date </th>
                        <th> Operations </th>
                    </tr>
                </thead>
                <tbody class="table-data"></tbody>
            </table>
        </section>
    </div>
    <!-- ========== End of Table ========== -->

    <!-- ========== Starting of Add user form ========== -->
    <div class="user-add-form" id="add-form">
        <section class="form-container">
            <h1>Add Plan</h1>
            <div class="close-popup" id="adduser_popup_close">
                <span class="material-symbols-rounded">close</span>
            </div>
            <form class="form" id="insert-user-form">
                @csrf
                <div class="input-box">
                    <label>Plan Name</label>
                    <input type="text" placeholder="Enter the offer name" id="plan-name" name="plan_name" required />
                </div>
                <div class="input-box">
                    <label>Plan Features</label>
                    <input type="text" placeholder="Enter the offer code" name="features" id="plan-features" required />
                </div>
                <div class="input-box">
                    <label>Plan Duration</label>
                    <input type="number" placeholder="Enter the discount percentage" name="plan_duration"
                        id="plan-duration" required />
                </div>
                <div class="input-box">
                    <label>Plan Price</label>
                    <input type="number" placeholder="Enter the number of usage" name="plan_price" id="plan-price"
                        required />
                </div>
                <button>Submit</button>
            </form>
        </section>
    </div>
    <!-- ========== End of Add user form ========== -->

    <!-- ========== Starting of Update user form ========== -->
    <div class="user-update-form" id="update-form">
        <section class="form-container">
            <h1>Update plans</h1>
            <div class="close-popup" id="updateuser_popup_close">
                <span class="material-symbols-rounded">close</span>
            </div>
            <div class="duf">

            </div>
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
    <script src="{{ asset('ajax/url.js') }}"></script>
    <script src="{{ asset('ajax/Plans/plan.js') }}"></script>
@endpush
