<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function checkout()
    {
        $planName = session()->get('plan_name');
        $planPrice = session()->get('plan_price');

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'INR',
                        'product_data' => [
                            "name" => $planName,
                        ],
                        'unit_amount' => $planPrice * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('afterCheckout'),
            'cancel_url' => route('pricing'),
        ]);

        return redirect($session->url);
    }

    public function afterCheckout()
    {

        // Modify the session variable. it is define in AccountController file

        $check = DB::table('users')->where('id', '=', session()->get('id'))->update([
            'subscription_status' => 1,
        ]);


        // It is all are coming from diffrent files
        // The all session variable is use to store the value inside the subscriptions table, they all are use to maintain the record of user subscription
        $userId = session()->get('id');
        if (session()->has('offer_id')) {
            $offerId = session()->get('offer_id');
            
            // now reduce the count of offer code
            $offer = DB::table('offers')->where('id','=',$offerId)->first();
            $newCount = $offer->count;
            $newCount--;
            DB::table('offers')->where('id', '=', $offerId)->update([
                'count' => $newCount,
            ]);
        } else {
            $offerId = null;
        }
        $planId = session()->get('plan_id');
        $purchaseDate = now();
        $planDuration = session()->get('plan_duration');
        $startingDate = Carbon::parse(now());
        $expireData = $startingDate->addDay($planDuration);


        DB::table('subscriptions')->insert([
            'user_id' => $userId,
            'offer_id' => $offerId,
            'plan_id' => $planId,
            'purchase_date' => $purchaseDate,
            'expire_date' => $expireData,
            'plan_duration' => $planDuration,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // removing unnessery session variables
        session()->remove('offer_id');
        session()->remove('plan_id');
        session()->remove('plan_duration');
        session()->remove('plan_name');
        session()->remove('plan_price');

        // Update the current subscription status.
        session()->put('subscription_status', 1);
        return redirect()->route('user.home');
    }

    public function getSubscriptionTable()
    {
        $records = DB::table('subscriptions')->get();

        $output = '';
        $count = 1;

        foreach ($records as $record) {

            $userData = DB::table('users')->select('username')->where('id', '=', $record->user_id)->first();
            $planData = DB::table('plans')->select('plan_name')->where('plan_id', '=', $record->plan_id)->first();

            if($record->is_active){
                $status = "<td class='active'>Active</td>";
            }else{
                $status = "<td class='deactive'>Deactive</td>";
            }

            $output .= '<tr>
            <td>' . $count . '</td>
            <td>' . $userData->username . '</td>
            <td>' . $planData->plan_name . '</td>
            <td>' . $record->purchase_date . '</td>
            <td>' . $record->expire_date . '</td>
            '.$status.'
            </tr>';
            $count++;
        }

        return $output;
    }
}