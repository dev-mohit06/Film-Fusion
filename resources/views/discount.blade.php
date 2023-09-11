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
        <div class="discount__container container grid">
            <div class="discount__animate">
                <h2 class="discount__title">Current Plan is <span id="currentPlan">₹{{ $planDetails['plan_price'] }}</span>
                    <span id="discountedPrice"></span>.
                </h2>
                <p class="discount__description" id="applyedDiscountMessage"></p>
                <input type="text" class="button button--flex" placeholder="Enter the promocode."
                    id="coupn_code"></input>
                <div class="container">
                    <br>
                    <a style="cursor: pointer" type="submit" class="button button--flex" id="apply">Apply</a>
                    <a href="{{ route('pay') }}" class="footer__copy-link" style="margin-left: 10px; cursor: pointer;"
                        id="continue">Continue</a>
                </div>
            </div>

            <img src="{{ asset('img/Mobile inbox-pana.svg') }}" alt="" class="discount__img" style="height: 200px;">
        </div>
    </section>

    @if (!session()->has('plan_name'))
        {{ session()->put('plan_name', $planDetails['plan_name']) }}
        {{ session()->put('plan_price', $planDetails['plan_price']) }}
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const coupnCodeIp = $("#coupn_code");
            const apply = $("#apply");
            const orignalPriceIP = $("#currentPlan");
            const discountedPriceIP = $("#discountedPrice");
            const applyedDiscountMessageIp = $("#applyedDiscountMessage");
            const continueBtn = $("#continue");

            // Toast notifications
            var Toast = new Notyf({
                duration: 3000,
                position: {
                    x: 'center',
                    y: 'top',
                },
            });

            apply.on("click", function() {
                let coupnCode = coupnCodeIp.val();
                let currentPlanId = {{ $planDetails['plan_id'] }};
                if (coupnCode != "") {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('applyCoupn') }}",
                        data: {
                            coupnCode: coupnCode,
                            plan_id: currentPlanId,
                        },
                        success: function(response) {
                            if (response.message == 1) {

                                Toast.success("Coupn code applyed successfully")

                                orignalPriceIP.css("text-decoration", "line-through");
                                discountedPriceIP.html("₹" + response.data.discounted_price);
                                applyedDiscountMessageIp.html("Applyed Discount is " + response
                                    .data.discounted_rate + "%");

                            } else if (response.message == 0) {

                                Toast.error("Invalid coupn code or expired code.")

                                orignalPriceIP.css("text-decoration", "none");
                                discountedPriceIP.html("");
                                applyedDiscountMessageIp.html("");
                            }
                        }
                    });
                }
            });

        });
    </script>
@endpush
