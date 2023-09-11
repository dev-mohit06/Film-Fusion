<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    public static function getOfferCode()
    {
        $offerCode = "FUSION";
        $offerCode .= Str::upper(Str::random(6));
        return $offerCode;
    }

    public function createNewOffer(Request $request)
    {
        $allOffers = DB::table('offers')->get();
        foreach ($allOffers as $offer) {
            if ($offer == $request->offer_code) {
                return "offer code already exsisted";
            }
        }

        $check = 0;
        if ($request->offer_code != "") {
            $check = DB::table('offers')->insert([
                'offer_name' => $request->offer_name,
                'discount_percentage' => $request->discount_percentage,
                'offer_code' => $request->offer_code,
                'count' => $request->count,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $check = DB::table('offers')->insert([
                'offer_name' => $request->offer_name,
                'discount_percentage' => $request->discount_percentage,
                'offer_code' => self::getOfferCode(),
                'count' => $request->count,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($check) {
            return "true";
        }
    }

    public function applyOffer(Request $request)
    {
        // Here i will retrive all of the info about the current plan which is selected by user
        $planData = PlanController::getPlanData($request->plan_id);
        $price = $planData['plan_price'];

        // Fethc the count if count == 0 then it will break other wise continue
        $isValidCoupen = DB::table('offers')->where('offer_code', '=', $request->coupnCode)->where('count', '!=', '0')->count();
        
        // it will check inside the offers tabel if it's valid coupn code then it will continue.
        if ($isValidCoupen) {

            //fethc all the info about the offer.
            $couponCodeDetails = DB::table('offers')->where('offer_code', '=', $request->coupnCode)->get();

            //get updated price (discounted price).
            $updatePrice = self::getNewPrice($request->coupnCode, $price);

            // store the discounted price inside the $planData which is fethc form PlanController.
            $planData['discounted_price'] = $updatePrice;


            //store discounted_rate inside of the $planData 
            foreach ($couponCodeDetails as $data) {
                $planData['discounted_rate'] = $data->discount_percentage;
                // $planData['applied_coupn'] = $request->coupnCode;
            }

            // store the value for SubscriptionController's pay function (Payment gateway)
            session()->put('plan_name',$planData['plan_name'] );
            session()->put('plan_price',$planData['discounted_price'] );


            //return the responce
            /**
             * 1 = discount applyed
             * 0 = invlaid coupn code
             */
            return [
                'message' => "1",
                'data' => $planData,
            ];
        } else {
            return [
                'message' => '0'
            ];
        }
    }

    private static function getNewPrice($couponCode, $currentPrice)
    {
        // Fetch the discount percentage from the database based on the coupon code
        $offer = DB::table('offers')->where('offer_code', '=', $couponCode)->first();

        $discountPercentage = $offer->discount_percentage;

        // Calculate the discounted price
        $discountedPrice = $currentPrice - ($currentPrice * $discountPercentage / 100);

        return ceil($discountedPrice);
    }
}
