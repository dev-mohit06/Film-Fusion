<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    public static function getOfferCode()
    {
        $offerCode = "FUSION";
        $offerCode .= Str::upper(Str::random(6));
        return $offerCode;
    }

    public function applyOffer(Request $request)
    {
        // Here i will retrive all of the info about the current plan which is selected by user
        $planData = PlanController::getPlanData($request->plan_id);
        $price = $planData->plan_price;

        // Fethc the count if count == 0 then it will break other wise continue
        $isValidCoupen = DB::table('offers')->where('offer_code', '=', $request->coupnCode)->where('count', '!=', '0')->where('offer_status','=','1')->count();

        // it will check inside the offers tabel if it's valid coupn code then it will continue.
        if ($isValidCoupen) {

            //fethc all the info about the offer.
            $couponCodeDetails = DB::table('offers')->where('offer_code', '=', $request->coupnCode)->get();

            //get updated price (discounted price).
            $updatePrice = self::getNewPrice($request->coupnCode, $price);

            // store the discounted price inside the $planData which is fetch form PlanController.
            $planData->discounted_price = $updatePrice;


            //store discounted_rate inside of the $planData 
            foreach ($couponCodeDetails as $data) {
                $planData->discounted_rate = $data->discount_percentage;
            }

            // store the value for SubscriptionController's checkout function (Payment gateway)
            session()->put('plan_name', $planData->plan_name);
            session()->put('plan_price', $planData->discounted_price);


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
                'message' => '0',
                'data' => $planData,
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

        // store the value for SubscriptionController's checkout function (Payment gateway)
        session()->put('offer_id', $offer->id);

        // return rounded price
        return ceil($discountedPrice);
    }


    //for admin
    public function getOffersTable()
    {
        $offers = DB::table('offers')->get();
        $output = '';
        $count = 1;
        foreach ($offers as $offer) {
            $offerStatus = "";
            if ($offer->count > 0 && $offer->offer_status == 1) {
                $offerStatus = '<td class="active">Active</td>';
            }
            if (($offer->count > 0 && $offer->offer_status == 0) || $offer->count == 0) {
                $offerStatus = '<td class="deactive">Deactive</td>';
            }
            if ($offer->offer_status == -1) {
                $offerStatus = '<td class="deactive">Deleted</td>';
            }

            $output .= '<tr>
            <td>' . $count . '</td>
            <td>
                ' . $offer->offer_name . '
            </td>
            <td>' . $offer->discount_percentage . '%</td>
            <td>' . $offer->offer_code . '</td>
            ' . $offerStatus . '
            <td>' . $offer->created_at . '</td>
            <td>
                <p class="status delivered update-form pointer updateuser_popup" data-update_id="' . $offer->id . '" id="update-btn">
                    Update
                </p>
                <br>
                <p class="status cancelled delete-btn pointer" data-delete_id="' . $offer->id . '" id="delete-btn">
                    Delete
                </p>
            </td>
        </tr>';
            $count++;
        }

        return $output;
    }

    public function createNewOffer(Request $request)
    {
        $allOffers = DB::table('offers')->get();
        foreach ($allOffers as $offer) {
            if ($offer->offer_code == $request->offer_code) {
                return "-1";
            }
        }

        $check = 0;

        $offerCode = "";
        if ($request->offer_code != "") {
            $offerCode = $request->offer_code;
        } else {
            $offerCode = self::getOfferCode();
        }

        $check = DB::table('offers')->insert([
            'offer_name' => $request->offer_name,
            'discount_percentage' => $request->discount_percentage,
            'offer_code' => $offerCode,
            'count' => $request->count,
            'offer_status' => $request->offer_status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($check) {
            return "true";
        }
    }

    public function getUpdateForm(Request $request)
    {
        $offer_id = $request->offer_id;

        $offer = DB::table('offers')->where('id', '=', $offer_id)->first();

        $optionsValues = [
            'Active' => 1,
            'Deactive' => 0,
            'Deleted' => -1,
        ];

        $options = '';
        foreach ($optionsValues as $key => $value) {
            if ($value == $offer->offer_status) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $options .= '<option value="' . $value . '" ' . $selected . '>' . $key . '</option>';
        }

        $output = '
        <form class="form" id="update-user-form">
        ' . csrf_field() . '
        <div class="input-box">
            <label>Offer Name</label>
            <input type="text" placeholder="Enter the offer name" id="update-offer-name" value="' . $offer->offer_name . '" name="offer_name" required />
        </div>
        <div class="input-box">
            <label>Offer Code</label>
            <input type="text" placeholder="Enter the offer code" name="offer_code" value="' . $offer->offer_code . '" id="update-offer-code" />
        </div>
        <div class="input-box">
            <label>Discount Percentage</label>
            <input type="number" placeholder="Enter the discount percentage" name="discount_percentage" value="' . $offer->discount_percentage . '" id="update-offer-price" required />
        </div>
        <div class="input-box">
            <label>Add number of usage</label>
            <input type="number" placeholder="Enter the number of usage" name="count" value="' . $offer->count . '" id="update-offer-number" required />
        </div>
        <div class="input-box">
            <label>Status</label>
            <div class="select-box">
                <select required name="offer_status">
                    <option disabled>Status</option>
                    ' . $options . '
                </select>
            </div>
        </div>
        <button type="submit">Submit</button>
        </form>
        ';
        return $output;
    }

    public function update(Request $request)
    {
        $isOfferExsist = DB::table('offers')->where('offer_code', '=', $request->offer_code)->where('offer_code', '!=', $request->offer_code)->count();
        if ($isOfferExsist) {
            return -1;
        }

        if ($request->offer_code != "") {
            $offerCode = $request->offer_code;
        } else {
            $offerCode = self::getOfferCode();
        }

        DB::table('offers')->where('id', '=', $request->offer_id)->update([
            'offer_name' => $request->offer_name,
            'discount_percentage' => $request->discount_percentage,
            'offer_code' => $offerCode,
            'count' => $request->count,
            'offer_status' => $request->offer_status,
            'updated_at' => now(),
        ]);

        return 1;
    }

    public function delete(Request $request){

        $offer_id = $request->offer_id;

        DB::table('offers')->where('id','=',$offer_id)->update([
            'offer_status' => -1,
        ]);
        
        return 1;
    }
}
