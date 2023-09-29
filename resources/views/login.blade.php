@extends('blueprints.without-login-main')

@section('title')
    Login - Registration
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('container')
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    {{-- Login Form --}}
                    <form autocomplete="off" class="sign-in-form" id="sign-in-form" method="POST">
                        @csrf
                        <div class="logo">
                            <img src="{{ asset('img/Logo.svg') }}" alt="easyclass" />
                            <h4>Film Fusion</h4>
                        </div>

                        <div class="heading">
                            <h2>Welcome Back</h2>
                            <h6>Not registred yet?</h6>
                            <a class="toggle" style="cursor: pointer">Sign up</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" id="lg-username" name="lg_username" class="input-field"
                                    autocomplete="off" required />
                                <label>Username</label>
                                <span class="err" id="err-lg-username"></span>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" id="lg-password" name="lg_password"
                                    class="input-field" autocomplete="off" required />
                                <label>Password</label>
                                <span class="err" id="err-lg-password"></span>
                            </div>

                            <input type="submit" value="Sign In" class="sign-btn" />

                            <p class="text">
                                Forgotten your password or you login datails?
                                <a href="{{ route('forget_password') }}">Get help</a> signing in
                            </p>
                        </div>
                    </form>

                    {{-- Registration Form --}}
                    <form autocomplete="off" class="sign-up-form" enctype="multipart/form-data" id="sign-up-form">
                        @csrf
                        <div class="logo">
                            <img src="{{ asset('img/Logo.svg') }}" alt="easyclass" />
                            <h4>Film Fusion</h4>
                        </div>

                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a class="toggle" style="cursor: pointer">Sign in</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" autocomplete="off" id="username"
                                    name="username" required />
                                <label>Username</label>
                                <span class="err" id="err-username"></span>
                            </div>

                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" id="email" name="email"
                                    required />
                                <label>Email</label>
                                <span class="err" id="err-email"></span>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" id="password" name="password"
                                    autocomplete="off" required />
                                <label>Password</label>
                                <span class="err" id="err-password"></span>
                            </div>

                            <div class="input-wrap">
                                <input type="file" class="input-field" id="profile_picture" name="profile_picture"
                                    autocomplete="off" />
                                <label style="opacity: 0;">demo error</label>
                                <span class="err" id="err-profile_picture"></span>
                            </div>

                            <br>
                            <input type="submit" value="Sign Up" class="sign-btn" />

                            <p class="text">
                                By signing up, I agree to the
                                <a href="#">Terms of Services</a> and
                                <a href="#">Privacy Policy</a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="{{ asset('img/Film rolls-pana.svg') }}" class="image img-1 show" alt="" />
                        <img src="{{ asset('img/Safe-bro.svg') }}" class="image img-2" alt="" />
                        <img src="{{ asset('img/Discount-pana.svg') }}" class="image img-3" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Experince the theater at your device.</h2>
                                <h2>Fell the best privacy.</h2>
                                <h2>Save you money with our offers</h2>
                            </div>
                        </div>

                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/login-registration.js') }}"></script>
    <script src="{{ asset('ajax/url.js') }}"></script>
    <script src="{{ asset('ajax/Login-Registration/registration.js') }}"></script>
    <script src="{{ asset('ajax/Login-Registration/login.js') }}"></script>

    @if (session()->has('activate'))
        @push('scripts')
            <script>
                const Toast = new Notyf({
                    duration: 3000,
                    position: {
                        x: 'center',
                        y: 'top',
                    },
                });
                Toast.success("Your account has been successfully activated!");
            </script>
        @endpush
    @endif

    @if (session()->has('already_activate'))
        @push('scripts')
            <script>
                const Toast = new Notyf({
                    duration: 3000,
                    position: {
                        x: 'center',
                        y: 'top',
                    },
                });
                Toast.open({
                    type: 'info',
                    background: 'orange',
                    message: 'Your account has already been successfully activated!'
                });
            </script>
        @endpush
    @endif

    @if (session()->has('token_expire'))
        <script>
            const Toast = new Notyf({
                duration: 3000,
                position: {
                    x: 'center',
                    y: 'top',
                },
            });
            Toast.error("Activation link is expired, Please try again!!");
        </script>
    @endif

    @if (session()->has('token_not_found'))
        <script>
            const Toast = new Notyf({
                duration: 3000,
                position: {
                    x: 'center',
                    y: 'top',
                },
            });
            Toast.error("Invalid Link, Please try again!!");
        </script>
    @endif

    @if (session()->has('password_update'))
        <script>
            const Toast = new Notyf({
                duration: 3000,
                position: {
                    x: 'center',
                    y: 'top',
                },
            });
            Toast.success("Password change successfully!!");
        </script>
    @endif
@endpush
