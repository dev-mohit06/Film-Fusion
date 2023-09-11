@extends('blueprints.without-login-main')

@section('title')
    Select your plan
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pricing.css') }}">
@endpush

@section('container')
    <section class="card container grid">
        <div class="card__container grid">

            <!--==================== CARD 1 ====================-->
            <article class="card__content grid">
                <div class="card__pricing">
                    <div class="card__pricing-number">
                        <span class="card__pricing-symbol">₹</span>199
                    </div>
                    <span class="card__pricing-month">/month</span>
                </div>

                <header class="card__header">
                    <div class="card__header-circle grid">
                        <img src="../img/pro-coin.png" alt="" class="card__header-img">
                    </div>

                    <span class="card__header-subtitle">Most popular</span>
                    <h1 class="card__header-title">Premium Mini</h1>
                </header>

                <ul class="card__list grid">
                    <li class="card__list-item">
                        <i class="uil uil-check card__list-icon"></i>
                        <p class="card__list-description">Watch online</p>
                    </li>
                    <li class="card__list-item">
                        <i class="uil uil-check card__list-icon"></i>
                        <p class="card__list-description">Unlock all features from our site</p>
                    </li>
                    <li class="card__list-item">
                        <i class="uil uil-check card__list-icon"></i>
                        <p class="card__list-description">Daily content updates</p>
                    </li>
                </ul>

                <a href="{{ route('discount', ['planId' => 1]) }}" class="card__button" style="text-decoration: none">Choose this plan</a>
            </article>

            <!--==================== CARD 2 ====================-->
            <article class="card__content grid">
                <div class="card__pricing">
                    <div class="card__pricing-number">
                        <span class="card__pricing-symbol">₹</span>399
                    </div>
                    <span class="card__pricing-month">/month</span>
                </div>

                <header class="card__header">
                    <div class="card__header-circle grid">
                        <img src="../img/enterprise-coin.png" alt="" class="card__header-img">
                    </div>

                    <span class="card__header-subtitle">for premium users</span>
                    <h1 class="card__header-title">Ultimate</h1>
                </header>

                <ul class="card__list grid">
                    <li class="card__list-item">
                        <i class="uil uil-check card__list-icon"></i>
                        <p class="card__list-description">Unlimited downloads</p>
                    </li>
                    <li class="card__list-item">
                        <i class="uil uil-check card__list-icon"></i>
                        <p class="card__list-description">Watch online</p>
                    </li>
                    <li class="card__list-item">
                        <i class="uil uil-check card__list-icon"></i>
                        <p class="card__list-description">Unlock all features from our site</p>
                    </li>
                    <li class="card__list-item">
                        <i class="uil uil-check card__list-icon"></i>
                        <p class="card__list-description">Daily content updates</p>
                    </li>
                </ul>

                <a href="{{ route('discount', ['planId' => 2]) }}" class="card__button" style="text-decoration: none">Choose this plan</a>
            </article>
        </div>
    </section>
@endsection
