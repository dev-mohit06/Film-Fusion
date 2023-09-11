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
            <h1>Users</h1>
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
                        <th> Username </th>
                        <th> Email </th>
                        <th> Status </th>
                        <th> Subscription Status </th>
                        <th> Operations </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="multifield">
                            <div class="profile-pic">
                                <img src="{{ asset('img/user.jpg') }}" alt="">
                            </div>
                            <div class="username">
                                Mohit Paddhariya
                            </div>
                        </td>
                        <td>mohit.local1@gmail.com</td>
                        <td>
                            <p class="status shipped">Admin</p>
                        </td>
                        <td class="active">Active</td>
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
                    <label>Username</label>
                    <input type="text" placeholder="Enter the username" id="user-name" required />
                    <span class="err" id="err-user-name"></span>
                </div>
                <div class="input-box">
                    <label>Email Address</label>
                    <input type="email" placeholder="Enter email address" id="email" required />
                    <span class="err" id="err-email"></span>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>Password</label>
                        <input type="password" placeholder="Enter the password" id="password" required />
                        <span class="err" id="err-password"></span>
                    </div>
                    <div class="input-box">
                        <label>Age</label>
                        <input type="number" placeholder="Enter the age" id="age" required />
                        <span class="err" id="err-age"></span>
                    </div>
                </div>
                <div class="gender-box">
                    <h3>Gender</h3>
                    <div class="select-box">
                        <select required>
                            <option>Gender</option>
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>
                    </div>
                </div>
                <div class="input-box address">
                    <label>Config of user</label>
                    <div class="column">
                        <div class="select-box">
                            <select required>
                                <option disabled>Role</option>
                                <option selected value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="select-box">
                            <select required>
                                <option disabled>Subscription</option>
                                <option value="1">1 month</option>
                                <option value="3">3 month</option>
                            </select>
                        </div>
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
            <form action="#" class="form" id="updaet-user-form">
                <div class="input-box">
                    <label>Username</label>
                    <input type="text" placeholder="Enter the username" id="update_username" required />
                    <span class="err" id="err-update_username"></span>
                </div>
                <div class="input-box">
                    <label>Email Address</label>
                    <input type="email" placeholder="Enter email address" id="update_email" required />
                    <span class="err" id="err-update_email"></span>
                </div>
                <div class="column">
                    <div class="input-box">
                        <label>Password</label>
                        <input type="password" placeholder="Enter the password" id="update_password" required />
                        <span class="err" id="err-update_password"></span>
                    </div>
                    <div class="input-box">
                        <label>Age</label>
                        <input type="number" placeholder="Enter the age" id="update_age" required />
                        <span class="err" id="err-update_age"></span>
                    </div>
                    <div class="input-box">
                        <label>Profile Picture</label>
                        <input type="file" id="update-profile_picture" required />
                        <span class="err" id="err-update-profile_picture"></span>
                    </div>
                </div>
                <div class="gender-box">
                    <h3>Gender</h3>
                    <div class="select-box">
                        <select required>
                            <option>Gender</option>
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>
                    </div>
                </div>
                <div class="input-box address">
                    <label>Config of user</label>
                    <div class="column">
                        <div class="select-box">
                            <select required>
                                <option disabled>Role</option>
                                <option selected value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="select-box">
                            <select required>
                                <option disabled>Subscription</option>
                                <option value="1">1 month</option>
                                <option value="3">3 month</option>
                            </select>
                        </div>
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