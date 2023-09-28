<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                <p class="status delivered update-form pointer updateuser_popup" id="updateuserBtn" data-update_id="' . $user->id . '">
                    Update
                </p>
                <br>
                <p class="status cancelled delete-btn pointer" id="deleteuserBtn" data-delete_id="' . $user->id . '">
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
                        <option value="0" selected>No Subscription</option>';


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

            if ($check) {
                return "1";
            } else {
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
                $userDetails = DB::table('users')->where('email', '=', $request->email)->first();
                $purchaseDate = Carbon::parse(now());
                $expiredDate = $purchaseDate->addDay($planDetails->plan_duration * 30);

                // Insert the record of the subscription
                DB::table('subscriptions')->insert([
                    'user_id' => $userDetails->id,
                    'offer_id' => null,
                    'plan_id' => $request->plan,
                    'purchase_date' => $purchaseDate,
                    'expire_date' => $expiredDate,
                    'plan_duration' => ($planDetails->plan_duration * 30),
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return "1";
            } else {
                return "0";
            }
        }
    }

    public function getUpdateForm(Request $request)
    {
        $user = DB::table('users')->where('id', '=', $request->userId)->first();
        $plans = DB::table('plans')->get();
        $status = '';
        $role = '';
        $subscription = '';

        foreach ($plans as $plan) {
            $subscription .= '<option value="' . $plan->plan_id . '">extend ' . $plan->plan_duration . ' month</option>';
        }
        if ($user->role == 0) {
            $role = '<select name="role" required>
            <option disabled>Role</option>
            <option selected value="0">User</option>
            <option value="1">Admin</option>
        </select>';
        } else {
            $role = '<select name="role" required>
            <option disabled>Role</option>
            <option value="0">User</option>
            <option selected value="1">Admin</option>
        </select>';
        }

        if ($user->account_status == -1) {
            $status .= '<option value="1">Activated</option>';
            $status .= '<option value="0">Deactivated</option>';
            $status .= '<option value="-1" selected>Deleted</option>';
        } else if ($user->account_status == 1) {
            $status .= '<option value="1" selected>Activated</option>';
            $status .= '<option value="0">Deactivated</option>';
            $status .= '<option value="-1">Deleted</option>';
        } else {
            $status .= '<option value="1">Activated</option>';
            $status .= '<option value="0" selected>Deactivated</option>';
            $status .= '<option value="-1">Deleted</option>';
        }
        $output = '<form class="form" id="update-user-form">
        ' . csrf_field() . '
        <div class="input-box">
            <label>Username</label>
            <input type="text" placeholder="Enter the username" id="update_username" name="username" required value="' . $user->username . '"/>
            <span class="err" id="err-update_username"></span>
        </div>
        <div class="input-box">
            <label>Email Address</label>
            <input type="email" placeholder="Enter email address" id="update_email" name="email" value="' . $user->email . '" required />
            <span class="err" id="err-update_email"></span>
        </div>
        <div class="column">
            <div class="input-box">
                <label>Password</label>
                <input type="password" placeholder="Enter the password" name="password" id="update_password" />
                <span class="err" id="err-update_password"></span>
            </div>
            <div class="input-box">
                <label>Profile Picture</label>
                <input type="file" id="update-profile_picture" name="profile_picture" />
                <span class="err" id="err-update-profile_picture"></span>
            </div>
        </div>
            <div class="input-box address">
                <label>Config of user</label>
                <div class="select-box">
                <select name="status">
                    ' . $status . '                        
                </select>
            </div>

            <div class="column">
                <div class="select-box">
                    ' . $role . '
                </div>
                <div class="select-box">
                    <select name="subscription">
                        <option selected value="" disable>Noting Change</option>
                        ' . $subscription . '                        
                    </select>
                </div>
            </div>
        </div>
        <button>Submit</button>
        </form>';

        return $output;
    }

    public function updateWithSubscription(Request $request)
    {

        /**
         * -1 : user already exsist
         * 1 : user's updated successfully
         */

        //fetching the current details of the user.
        $user = DB::table('users')->where('id', '=', $request->userId)->first();

        //fetching the profile picture if any upload
        $fileName = $user->profile_picture;
        if ($request->hasFile('profile_picture')) {

            $file = $request->file('profile_picture');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/users/profile_pictures/'), $fileName);

            if ($user->profile_picture != "deafult.jpg") {
                unlink(public_path('/users/profile_pictures/' . $user->profile_picture . ''));
            }
        }


        $is_userExist = DB::table('users')
            ->where(function ($query) use ($request) {
                $query->where('username', '=', $request->username)
                    ->orWhere('email', '=', $request->email);
            })
            ->where('email', '!=', $user->email)
            ->where('username', '!=', $user->username)
            ->count();

        $newPassword = "";
        if ($request->password != "") {
            $newPassword = bcrypt($request->password);
        } else {
            $newPassword = $user->password;
        }

        $subscription = '';
        if ($request->subscription != null) {
            $subscription = 1;
        } else {
            $subscription = $user->subscription_status;
        }

        if ($is_userExist) {
            return "-1";
        } else {

            // update the user data
            DB::table('users')->where('id', '=', $request->userId)->update([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $newPassword,
                'profile_picture' => $fileName,
                'account_status' => $request->status,
                'role' => $request->role,
                'subscription_status' => $subscription,
                'updated_at' => now(),
            ]);

            if ($request->subscription != null) {

                //fetch the current user which we are update previous.
                $recentUser = DB::table('users')->where('email', '=', $request->email)->first();

                // fetch the old subscription data if user have.
                $oldSubscription = DB::table('subscriptions')->where('user_id', '=', $recentUser->id)->where('is_active', '=', 1)->first();

                // fetch the plan details
                $planDetails = DB::table('plans')->where('plan_id', '=', $request->subscription)->first();

                //helper variable to insert subscription data.
                $purchaseDate = "";
                $expireDate = "";
                $user_id = $recentUser->id;
                $plan_duration = ($planDetails->plan_duration * 30);

                if ($oldSubscription) {
                    // get the purchase date
                    $purchaseDate = $oldSubscription->purchase_date;

                    // get old expire date
                    $oldExpireDate = Carbon::parse($oldSubscription->expire_date);

                    // extend the expire date
                    $expireDate = $oldExpireDate->addDays($planDetails->plan_duration * 30);

                    // update the data
                    DB::table('subscriptions')->where('user_id', '=', $recentUser->id)->where('is_active','=','1')->update([
                        'plan_id' => $oldSubscription->plan_id,
                        'purchase_date' => $purchaseDate,
                        'expire_date' => $expireDate,
                        'plan_duration' => $plan_duration + $oldSubscription->plan_duration,
                        'updated_at' => now(),
                    ]);

                    return "1";
                } else {
                    // create the purchase date
                    $purchaseDate = Carbon::parse(now());

                    // create the temperory purchase date
                    $tempPurchaseDate = Carbon::parse(now());
                    // create the expire date
                    $expireDate = $tempPurchaseDate->addDays($planDetails->plan_duration * 30);

                    // get a new plan id
                    $plan_id = $request->subscription;

                    // insert the subscription data.
                    DB::table('subscriptions')->insert([
                        'user_id' => $user_id,
                        'offer_id' => null,
                        'plan_id' => $plan_id,
                        'purchase_date' => $purchaseDate,
                        'expire_date' => $expireDate,
                        'plan_duration' => $plan_duration,
                        'is_active' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // update the subscription status of the recent user.
                    DB::table('users')->where('id', '=', $recentUser->id)->update([
                        'subscription_status' => 1,
                    ]);

                    return "1";
                }
            } else {
                return "1";
            }
        }
    }

    public function deleteUser(Request $request){
        $userId = $request->userId;

        DB::table('users')->where('id','=',$userId)->update([
            'account_status'=>'-1',
        ]);

        return "1";
    }
}