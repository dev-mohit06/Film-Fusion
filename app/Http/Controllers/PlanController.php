<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{

    public function getPricingCardView(){
        return view('pricing',["planDetails" => DB::table('plans')->get()]);
    }

    public function returnDiscountView(String $planId){
        $planDetails = [];
        $planDetails = self::getPlanData($planId);
        return view('discount',['planDetails' => $planDetails]);
    }

    public static function getPlanData(String $planId = null){
        $planDetails = [];
        if($planId != null){
            $isValidId = DB::table('plans')->where('plan_id','=',$planId)->count();
            if($isValidId == 1){
                $data =  DB::table('plans')->where('plan_id','=',$planId)->first();
                $planDetails = $data;
            }else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }

        return $planDetails;
    }
}
