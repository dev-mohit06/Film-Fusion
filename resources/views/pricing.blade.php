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

            {{-- {{ $planDetails }} --}}

            @foreach ($planDetails as $plan)
                {{-- {{ $plan->features }} --}}
                <!--==================== CARD {{ $loop->index+1 }} ====================-->
                <article class="card__content grid">
                    <div class="card__pricing">
                        <div class="card__pricing-number">
                            <span class="card__pricing-symbol">₹</span>{{ $plan->plan_price }}
                        </div>
                        <span class="card__pricing-month">/{{ $plan->plan_duration }} month</span>
                    </div>

                    <header class="card__header">
                        <div class="card__header-circle grid">
                            <img src="../img/pro-coin.png" alt="" class="card__header-img">
                        </div>

                        <h1 class="card__header-title">{{ $plan->plan_name }}</h1>
                    </header>

                    <ul class="card__list grid">
                        @php
                            $data = $plan->features;
                            $features = explode(',', $data);
                        @endphp
                        @foreach ($features as $feature)
                            <li class="card__list-item">
                                <i class="uil uil-check card__list-icon"></i>
                                <p class="card__list-description">{{ $feature }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('discount', ['planId' => $plan->plan_id]) }}" class="card__button"
                        style="text-decoration: none">Choose this plan</a>
                </article>
            @endforeach

            {{-- ==================== CARD ==================== --}}
            {{-- <article class="card__content grid">
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
            </article> --}}
        </div>
    </section>
@endsection
