<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{

    public function getPricingCardView()
    {
        return view('pricing', ["planDetails" => DB::table('plans')->where('status', '=', '1')->get()]);
    }

    public function returnDiscountView(String $planId)
    {
        $planDetails = [];
        $planDetails = self::getPlanData($planId);
        if (!empty($planDetails)) {
            return view('discount', ['planDetails' => $planDetails]);
        } else {
            return redirect()->route('pricing');
        }
    }

    public static function getPlanData(String $planId = null)
    {
        $planDetails = [];
        if ($planId != null) {
            $isValidId = DB::table('plans')->where('plan_id', '=', $planId)->where('status', '=', '1')->count();
            if ($isValidId == 1) {
                $data =  DB::table('plans')->where('plan_id', '=', $planId)->first();
                $planDetails = $data;
            } else {
                return $planDetails;
            }
        } else {
            return $planDetails;
        }

        return $planDetails;
    }

    public function getPlansTable()
    {
        $planDetails = DB::table('plans')->get();

        $output = '';
        $count = 1;
        foreach ($planDetails as $plan) {
            $currentStatus = ($plan->status == 1) ? "<td class='active'>Active</td>" : ($plan->status == 0 ? "<td class='deactive'>Deactive</td>" : "<td class='deactive'>Deleted</td>");
            $output .= '<tr>
            <td>' . $count . '</td>
            <td>
                ' . $plan->plan_name . '
            </td>
            <td>' . $plan->plan_duration . ' month</td>
            ' . $currentStatus . '
            <td>' . $plan->created_at . '</td>
            <td>
                <p class="status delivered update-form pointer updateuser_popup" data-update_id="' . $plan->plan_id . '" id="update-btn">
                    Update
                </p>
                <br>
                <p class="status cancelled delete-btn pointer" data-delete_id="' . $plan->plan_id . '" name="' . $plan->plan_id . '" id="delete-btn">
                    Delete
                </p>
            </td>
        </tr>';
            $count++;
        }

        return $output;
    }

    public function insert(Request $request)
    {
        DB::table('plans')->insert([
            'plan_name' => $request->plan_name,
            'features' => $request->features,
            'plan_price' => $request->plan_price,
            'plan_duration' => $request->plan_duration,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return 1;
    }

    public function getUpdateForm(Request $request)
    {
        $current_plna_id = $request->plan_id;

        $plan_data = DB::table('plans')->where('plan_id', '=', $current_plna_id)->first();

        $current_status = "";
        if ($plan_data->status == "1") {
            $current_status = '<select name="status" required>
            <option disabled>Status</option>
            <option value="1" selected>Active</option>
            <option value="0">Deactive</option>
            <option value="-1">Delete</option>
        </select>';
        } else if ($plan_data->status == "0") {
            $current_status = '<select name="status" required>
            <option disabled>Status</option>
            <option value="1">Active</option>
            <option value="0" selected>Deactive</option>
            <option value="-1">Delete</option>
        </select>';
        } else {
            $current_status = '<select name="status" required>
            <option disabled>Status</option>
            <option value="1">Active</option>
            <option value="0">Deactive</option>
            <option value="-1" selected>Delete</option>
            </select>';
        }


        $output = '
        <form class="form" id="update-user-form">
        ' . csrf_field() . '
        <div class="input-box">
            <label>Plan Name</label>
            <input type="text" placeholder="Enter the offer name" id="update-plan-name" name="plan_name" required value="' . $plan_data->plan_name . '" />
        </div>
        <div class="input-box">
            <label>Plan Features</label>
            <input type="text" placeholder="Enter the offer code" name="features" id="update-plan-features" value="' . $plan_data->features . '" required />
        </div>
        <div class="input-box">
            <label>Plan Duration</label>
            <input type="number" placeholder="Enter the discount percentage" name="plan_duration" value="' . $plan_data->plan_duration . '" id="update-plan-duration"
                required />
        </div>
        <div class="input-box">
            <label>Plan Price</label>
            <input type="number" placeholder="Enter the number of usage" name="plan_price" value="' . $plan_data->plan_price . '" id="update-plan-price"
                required />
        </div>
        <div class="input-box">
            <label>Plan Status</label>
            <div class="select-box">
                ' . $current_status . '
            </div>
        </div>
        <button>Submit</button>
        </form>
        ';

        return $output;
    }

    public function update(Request $request)
    {
        DB::table('plans')->where('plan_id', '=', $request->plan_id)->update([
            'plan_name' => $request->plan_name,
            'features' => $request->features,
            'plan_price' => $request->plan_price,
            'plan_duration' => $request->plan_duration,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return 1;
    }

    public function delete(Request $request)
    {
        DB::table('plans')->where('plan_id', '=', $request->plan_id)->update([
            'status' => -1,
        ]);
        return 1;
    }
}
