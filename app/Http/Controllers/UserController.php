<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\Table\Table;

class UserController extends Controller
{

    // For registration
    public function insert(Request $request)
    {
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = uniqid() . time() . '.' .  $file->getClientOriginalExtension();
        } else {
            $fileName = "deafult.jpg";
        }

        $check = DB::table('users')->insertOrIgnore([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile_picture' => $fileName,
            'verification_token' => AccountContorller::verificationToken(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if ($check) {
            if ($request->hasFile('profile_picture')) {
                $request->file('profile_picture')->move(public_path('/users/profile_pictures/'), $fileName);
            }
            if (AccountContorller::sendEmail($request->email)) {
                return 1;
            }
        } else {
            return 0;
        }
    }

    // For Admin Panel
    public function getUsersTable()
    {
        $users = DB::table('users')->get();
        $output = '';
        $count = 1;
        foreach ($users as $user) {
            $account_status = ($user->account_status == 1 && $user->role == 1) ? '<p class="status shipped">Admin</p>' : (($user->account_status == 1) ? '<p class="active">Activated</p>' : (($user->account_status == 0) ? '<p class="deactive">Deactivated</p>' : '<p class="deactive">Deleted</p>'));
            $subscription_status = ($user->subscription_status == 1) ? '<td class="active">Activated</td>' : '<td class="deactive">Deactivated</td>';
            $profilePictureUrl = asset("users/profile_pictures/{$user->profile_picture}");
            $output .= '<tr>
            <td>' . $count . '</td>
            <td class="multifield">
                <div class="profile-pic">
                    <img src="' . $profilePictureUrl . '" alt="">
                </div>
                <div class="username">
                    ' . $user->username . '
                </div>
            </td>
            <td>' . $user->email . '</td>
            <td>
                ' . $account_status . '
            </td>
            ' . $subscription_status . '
            <td>
                <p class="status delivered update-form pointer updateuser_popup" data-update_id="' . $user->id . '">
                    Update
                </p>
                <br>
                <p class="status cancelled delete-btn pointer" data-delete_id="' . $user->id . '">
                    Delete
                </p>
            </td>
        </tr>';
            $count++;
        }

        return $output;
    }

    public function getInsertForm()
    {
        $plans = DB::table('plans')->get();
        $output = '<form class="form" id="insert-user-form">
        ' . csrf_field() . '
        <div class="input-box">
            <label>Username</label>
            <input type="text" placeholder="Enter the username" name="username" id="user-name" required />
            <span class="err" id="err-user-name"></span>
        </div>
        <div class="input-box">
            <label>Email Address</label>
            <input type="email" placeholder="Enter email address" name="email" id="email" required />
            <span class="err" id="err-email"></span>
        </div>
        <div class="input-box">
            <label>Password</label>
            <input type="password" placeholder="Enter the password" name="password" id="password" autocomplete="new-password" required />
            <span class="err" id="err-password"></span>
        </div>
        <div class="gender-box">
            <h3>Gender</h3>
            <div class="select-box">
                <select name="gender" required>
                    <option>Gender</option>
                    <option value="Male" selected>Male</option>
                    <option value="Female">Female</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>
            </div>
        </div>
        <div class="input-box address">
            <label>Config of user</label>
            <div class="column">
                <div class="select-box">
                    <select name="role" required>
                        <option disabled>Role</option>
                        <option selected value="0">User</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
                <div class="select-box">
                    <select name="plan" required>
                        <option value="0" selected>no subscription</option>';


        foreach ($plans as $plan) {
            $output .= '<option value="' . $plan->plan_id . '">' . $plan->plan_duration . ' month</option>';
        }

        $output .= '                            </select>
        </div>
            </div>
                </div>
                    <button>Submit</button>
                        </form>';

        return $output;
    }

    public function insertWithSubscription(Request $request)
    {
        $fileName = "deafult.jpg";

        $check = false;
        if ($request->plan == 0) {
            $check = DB::table('users')->insertOrIgnore([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'profile_picture' => $fileName,
                'verification_token' => AccountContorller::verificationToken(),
                'role' => $request->role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if($check){
                return "1";
            }else{
                return "0";
            }

        } else if ($request->plan > 0) {
            $check = DB::table('users')->insertOrIgnore([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'profile_picture' => $fileName,
                'verification_token' => AccountContorller::verificationToken(),
                'role' => $request->role,
                'subscription_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($check) {
                $planDetails = PlanController::getPlanData($request->plan);
                $userDetails = DB::table('users')->first();
                $purchaseDate = Carbon::parse(now());
                $expiredDate = $purchaseDate->addDay($planDetails->plan_duration * 30);

                // Insert the record of the subscription
                DB::table('subscriptions')->insert([
                    'user_id' => $userDetails->id,
                    'offer_id' => null,
                    'plan_id' => $request->plan,
                    'purchase_date' => $purchaseDate,
                    'expire_date' => $expiredDate,
                    'plan_duration' => $planDetails->plan_duration,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return "1";
            }else{
                return "0";
            }
        }
    }
}
