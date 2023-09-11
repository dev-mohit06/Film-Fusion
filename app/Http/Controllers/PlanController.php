<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RedisTagSet;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function getPlan(String $planId){
        $planDetails = [];
        if($planId == 1){
            $planDetails = [
                'plan_id' => 1,
                'plan_name' => 'Premium Mini',
                'plan_price' => '199',
                'plan_duration' => '30',
                'plan_type' => '0', // it is for plan 2 (downalod functionality).
            ];
        }else if($planId == 2){
            $planDetails = [
                'plan_id' => 2,
                'plan_name' => 'Ultimate',
                'plan_price' => '399',
                'plan_duration' => '30',
                'plan_type' => '1', // it is for plan 2 (downalod functionality).
            ];
        }else{
            return redirect()->back();
        }
        // return redirect()->route('discount', ['planDetails' => $planDetails]);
        return view('discount',['planDetails' => $planDetails]);
    }

    public static function getPlanData(String $planId){
        $planDetails = [];
        if($planId == 1){
            $planDetails = [
                'plan_id' => 1,
                'plan_name' => 'Premium Mini',
                'plan_price' => '199',
                'plan_duration' => '30',
                'plan_type' => '0', // it is for plan 2 (downalod functionality).
            ];
        }else if($planId == 2){
            $planDetails = [
                'plan_id' => 2,
                'plan_name' => 'Ultimate',
                'plan_price' => '399',
                'plan_duration' => '30',
                'plan_type' => '1', // it is for plan 2 (downalod functionality).
            ];
        }else{
            return redirect()->back();
        }
        return $planDetails;
    }
}
