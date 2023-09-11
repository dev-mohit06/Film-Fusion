<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function pay(){

        if(session()->has('plan_price') || session()->has('plan_price')){
            $planName = session()->get('plan_name');
            $planPrice = session()->get('plan_price');
    


            return $planPrice;
        }else{
            return redirect()->back();
        }

    }
}
