@extends('blueprints.without-login-main')

@section('title')
    Discount - FilmFusion
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

@section('container')
    <section class="discount section container">
        <h1 class="home__subtitle">Have any promocode?</h1>
        <br>
        {{ session()->put('plan_id', $planDetails->plan_id) }}
        {{ session()->put('plan_duration', $planDetails->plan_duration * 30) }}
        {{ session()->put('plan_name', $planDetails->plan_name) }}
        {{ session()->put('plan_price', $planDetails->plan_price) }}
        <div class="discount__container container grid">
            <div class="discount__animate">
                <h2 class="discount__title">Current Plan is <span id="currentPlan">₹{{ $planDetails->plan_price }}</span>
                    <span id="discountedPrice"></span>.
                </h2>
                <p class="discount__description" id="applyedDiscountMessage"></p>
                <input type="text" class="button button--flex" placeholder="Enter the promocode."
                    id="coupn_code"></input>
                <div class="container">
                    <br>
                    <a style="cursor: pointer" type="submit" class="button button--flex" id="apply">Apply</a>
                    <a href="{{ route('checkout') }}" class="footer__copy-link" style="margin-left: 10px; cursor: pointer;"
                        id="continue">Continue</a>
                </div>
            </div>

            <img src="{{ asset('img/Mobile inbox-pana.svg') }}" alt="" class="discount__img" style="height: 200px;">
        </div>
    </section>
@endsection

@push('scripts')

    <script src="{{ asset('ajax/url.js') }}"></script>
    <script src="{{ asset('ajax/Discount/discount.js') }}"></script>

    <script>
        // it is for discount.js file to pass current plan id
        let plan_id = {{ $planDetails->plan_id }};
    </script>
@endpush
