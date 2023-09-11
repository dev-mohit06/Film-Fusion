@extends('blueprints.admin-main')

@section('title')
    Dashboard
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reusable/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reusable/btnfancy.css') }}">
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
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <span class="material-symbols-rounded">search</span>
            </div>
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
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            Moonsoon Special
                        </td>
                        <td>20%</td>
                        <td>MON20</td>
                        <td class="deactive">Deactive</td>
                        <td>1-6-2023</td>
                        <td>
                            <p class="status delivered update-form pointer updateuser_popup">
                                Update
                            </p>
                            <br>
                            <p class="status cancelled delete-btn pointer">
                                Delete
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            Rakshabandhan Dhamak
                        </td>
                        <td>70%</td>
                        <td>BHAIBHEN70</td>
                        <td class="active">Active</td>
                        <td>5-8-2023</td>
                        <td>
                            <p class="status delivered update-form pointer updateuser_popup">
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

    <!-- ========== Starting of Add user form ========== -->
    <div class="user-add-form" id="add-form">
        <section class="form-container">
            <h1>Add User</h1>
            <div class="close-popup" id="adduser_popup_close">
                <span class="material-symbols-rounded">close</span>
            </div>
            <form action="#" class="form" id="insert-user-form">
                <div class="input-box">
                    <label>Offername</label>
                    <input type="text" placeholder="Enter the offer name" id="offer-name" required />
                    <span class="err" id="err-offer-name"></span>
                </div>
                <div class="gender-box">
                    <h3>Discount persentage</h3>
                    <div class="select-box">
                        <select required>
                            <option disabled>Discount persentage</option>
                            <option value="10" selected>10%</option>
                            <option value="20">20%</option>
                            <option value="30">30%</option>
                            <option value="40">40%</option>
                            <option value="50">50%</option>
                            <option value="60">60%</option>
                            <option value="70">70%</option>
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
            <form action="#" class="form" id="insert-user-form">
                <div class="input-box">
                    <label>Offername</label>
                    <input type="text" placeholder="Enter the offer name" id="update-offer-name" required />
                    <span class="err" id="err-update-offer-name"></span>
                </div>
                <div class="gender-box">
                    <h3>Discount persentage</h3>
                    <div class="select-box">
                        <select required>
                            <option disabled>Discount persentage</option>
                            <option value="10" selected>10%</option>
                            <option value="20">20%</option>
                            <option value="30">30%</option>
                            <option value="40">40%</option>
                            <option value="50">50%</option>
                            <option value="60">60%</option>
                            <option value="70">70%</option>
                        </select>
                    </div>
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
    <script src="{{ asset('js/admin-users.js') }}"></script>
@endpush
