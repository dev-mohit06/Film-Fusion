@extends('blueprints.admin-main')

@section('title')
    Dashboard
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
                <span class="button__text">Add new offer</span>
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
            <h1>Offers</h1>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Id </th>
                        <th> Offer name </th>
                        <th> Discount </th>
                        <th> Offer Code </th>
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
            <h1>Add User</h1>
            <div class="close-popup" id="adduser_popup_close">
                <span class="material-symbols-rounded">close</span>
            </div>
            <form class="form" id="insert-user-form">
                @csrf
                <div class="input-box">
                    <label>Offer Name</label>
                    <input type="text" placeholder="Enter the offer name" id="offer-name" name="offer_name" required />
                    {{-- <span class="err" id="err-offer-name"></span> --}}
                </div>
                <div class="input-box">
                    <label>Offer Code</label>
                    <input type="text" placeholder="Enter the offer code" name="offer_code" id="offer-code" />
                    {{-- <span class="err" id="err-offer-name"></span> --}}
                </div>
                <div class="input-box">
                    <label>Discount Percentage</label>
                    <input type="number" placeholder="Enter the discount percentage" name="discount_percentage"
                        id="offer-price" />
                    {{-- <span class="err" id="err-offer-name"></span> --}}
                </div>
                <div class="input-box">
                    <label>Add number of usage</label>
                    <input type="number" placeholder="Enter the number of usage" name="count" id="offer-number" />
                    {{-- <span class="err" id="err-offer-name"></span> --}}
                </div>
                <div class="input-box">
                    <label>Status</label>
                    <div class="select-box">
                        <select required="" name="offer_status">
                            <option disabled>Status</option>
                            <option value="1" selected="">Active</option>
                            <option value="0">Deactive</option>
                            <option value="-1">Delete</option>
                        </select>
                    </div>
                </div>
                <button>Submit</button>
            </form>
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
    <script src="{{ asset('js/resulable/sidebar.js') }}"></script>
    {{-- <script src="{{ asset('js/admin-users.js') }}"></script> --}}

    <script src="{{ asset('ajax/Offers/offers.js') }}"></script>
@endpush
