@extends('blueprints.with-login-main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/resuable/cards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@endpush


@section('title')
    Settings
@endsection

@section('container')
    <br>
    <br>

    <section class="container">
        <div class="heading">
            <h2 class="heading-title">
                Configure your settings
            </h2>
        </div>

        <div class="container">
            <div class="card__container">
                <article class="card__article">
                    <div class="card__scale-1"></div>
                    <div class="card__scale-2"></div>

                    <div class="card__shape-1">
                        <div class="card__shape-2"></div>
                        <div class="card__shape-3">
                            <i class="bx bx-edit-alt card__icon"></i>
                        </div>
                    </div>

                    <div class="card__data">
                        <h2 class="card__title">Edit your profile</h2>

                        <p class="card__description">
                            enable you to change your name, profile-picture, gender, and etc.
                        </p>

                        <a href="{{ route('user.edit-profile') }}" class="card__button">
                            Continue
                        </a>
                    </div>
                </article>

                <article class="card__article card__orange">
                    <div class="card__scale-1"></div>
                    <div class="card__scale-2"></div>

                    <div class="card__shape-1">
                        <div class="card__shape-2"></div>
                        <div class="card__shape-3">
                            <i class="bx bx-gift card__icon"></i>
                        </div>
                    </div>

                    <div class="card__data">
                        <h2 class="card__title">Referral your friend</h2>

                        <p class="card__description">
                            After every referral you will get 1 month subscription free
                        </p>

                        <a class="card__button" id="open-modal" style="cursor: pointer;">
                            Start refrring
                        </a>
                    </div>
                </article>

                <article class="card__article">
                    <div class="card__scale-1"></div>
                    <div class="card__scale-2"></div>

                    <div class="card__shape-1">
                        <div class="card__shape-2"></div>
                        <div class="card__shape-3">
                            <i class="bx bx-trash card__icon"></i>
                        </div>
                    </div>

                    <div class="card__data">
                        <h2 class="card__title">Delete your account</h2>

                        <p class="card__description">
                            if you want to delete your account then your subscription also canclled!
                        </p>

                        <a href="#" class="card__button">
                            Delete
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Popup form for referall -->
    <div class="modal__container" id="modal-container">
        <div class="modal__content">
            <div class="modal__close close-modal" title="Close">
                <i class='bx bx-x'></i>
            </div>

            <img src="{{ asset('img/Gift card-rafiki.svg') }}" alt="" class="modal__img">

            <h1 class="modal__title">Good Job!</h1>
            <p class="modal__description">People you add will recive an invite automatically</p>

            <input type="text" placeholder="Enter the email address" class="modal__button modal__button-width">
            <button class="modal__button-link">
                Send
            </button>
        </div>
    </div>
@endsection


@push('scripts')
    <!-- ========== JAVASCRIPTS ========== -->
    <script src="{{ asset('js/settingModal.js') }}"></script>
@endpush