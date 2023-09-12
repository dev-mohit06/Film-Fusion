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
        let currentPlanId = plan_id;
        if (coupnCode != "") {
            $.ajax({
                type: "GET",
                // url: "{{ route('applyCoupn') }}",
                url: url + "applyCoupn",
                data: {
                    coupnCode: coupnCode,
                    plan_id: currentPlanId,
                },
                success: function(response) {
                    if (response.message == 1) {

                        Toast.success(
                            "Coupn code applyed successfully you will redirect shortly"
                            )

                        orignalPriceIP.css("text-decoration", "line-through");
                        discountedPriceIP.html("₹" + response.data.discounted_price);
                        applyedDiscountMessageIp.html("Applyed Discount is " + response
                            .data.discounted_rate + "%");


                        apply.prop('disabled', true);

                        window.location.href = url + "checkout";

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