@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
@endpush


@section('title')
    Edit Profile
@endsection

@section('container')
    <br>
    <br>
    <br>
    <br>

    <section class="container profile-container">
        <h1>Edit Profile</h1>
        <form action="#" class="form">
            <div class="input-box">
                <label>Username</label>
                <input type="text" placeholder="Enter username" required />
            </div>
            <div class="input-box">
                <label>Email Address</label>
                <input type="text" placeholder="Enter email address" required />
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Password</label>
                    <input type="password" placeholder="Enter the password" required />
                </div>
                <div class="input-box">
                    <label>Age</label>
                    <input type="number" placeholder="Enter the age" required />
                </div>
            </div>
            <div class="input-box address">
                <div class="column">
                    <div class="select-box">
                        <select>
                            <option hidden>Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Prefer not to say</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="input-box">
                <label>Profile Picture</label>
                <input type="file" required />
            </div>
            <button>Submit</button>
        </form>
    </section>
    <br>
    <br>
    <br>
    <br>
@endsection
