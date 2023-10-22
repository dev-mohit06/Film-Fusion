<?php

namespace App\Http\Controllers;

use App\Mail\SuccessfullyInvited;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
            'verification_token' => AccountContorller::getVerificationToken(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($check) {
            if ($request->hasFile('profile_picture')) {
                $request->file('profile_picture')->move(public_path('/users/profile_pictures/'), $fileName);
            }
            if (AccountContorller::sendVerificationEmail($request->email)) {
                if (session()->has('refree_person')) {
                    $referrer_preson_data = session()->get('refree_person');
                    $referrer_preson_code = session()->get('referral_code');
                    $referrer_preson_active_subscription = DB::table('subscriptions')->where('user_id', '=', $referrer_preson_data->id)->where('is_active', '=', '1')->first();

                    if ($referrer_preson_active_subscription) {

                        DB::table('subscriptions')->where('user_id', '=', $referrer_preson_data->id)->where('is_active', '=', '1')->update([
                            'expire_date' => Carbon::parse($referrer_preson_active_subscription->expire_date)->addDay(10),
                        ]);

                        $current_user_data = DB::table('users')->where('email', '=', $request->email)->first();

                        DB::table('referrals')->where('referrer_id', '=', $referrer_preson_data->id)->where('referral_code','=',$referrer_preson_code)->update([
                            'referee_id' => $current_user_data->id,
                            'status' => 1,
                        ]);

                        mail::to($referrer_preson_data->email)->send(new SuccessfullyInvited());
                    }
                }
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
                'verification_token' => AccountContorller::getVerificationToken(),
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
                'verification_token' => AccountContorller::getVerificationToken(),
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
                    DB::table('subscriptions')->where('user_id', '=', $recentUser->id)->where('is_active', '=', '1')->update([
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

    public function deleteUser(Request $request)
    {
        $userId = $request->userId;

        DB::table('users')->where('id', '=', $userId)->update([
            'account_status' => '-1',
        ]);

        return "1";
    }

    // for website aka withlogin
    public function returnSettings()
    {
        $user_data = DB::table('users')->where('id', '=', session()->get('id'))->first();

        return view('with-login.settings', ['user_data' => $user_data]);
    }

    public function returnEditProfile()
    {
        $user_data = DB::table('users')->where('id', '=', session()->get('id'))->first();

        return view('with-login.edit-profile', ['user_data' => $user_data]);
    }

    public function updateProfile(Request $request)
    {


        $is_userExist = DB::table('users')
            ->where(function ($query) use ($request) {
                $query->where('username', '=', $request->username)
                    ->orWhere('email', '=', $request->email);
            })
            ->where('email', '!=', session()->get('email'))
            ->where('username', '!=', session()->get('username'))
            ->count();

        if ($is_userExist) {
            return -1;
        } else {
            $oldData = DB::table('users')->where('id', '=', session()->get('id'))->first();

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $profilePicture = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/users/profile_pictures/'), $profilePicture);

                if ($oldData->profile_picture != "deafult.jpg") {
                    unlink(public_path('/users/profile_pictures/' . $oldData->profile_picture . ''));
                }
            } else {
                $profilePicture = $oldData->profile_picture;
            }

            if ($request->password != "") {
                $newPassword = bcrypt($request->password);
            } else {
                $newPassword = $oldData->password;
            }

            DB::table('users')->where('id', '=', session()->get('id'))->update([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $newPassword,
                'profile_picture' => $profilePicture
            ]);

            session()->remove('username');
            session()->put('username', $request->username);
            session()->remove('email');
            session()->put('email', $request->email);
            session()->remove('dp');
            session()->put('dp', $profilePicture);

            return 1;
        }
    }

    public function deleteCurrentUser()
    {
        $id = session()->get('id');

        DB::table('users')->where('id', '=', $id)->update([
            'account_status' => -1,
        ]);

        return redirect()->route('logout');
    }

    public static function checkWatchLator(Request $request)
    {
        $user_id = session()->get('id');
        $movie_id = $request->movie_id;

        $is_exsist = DB::table('watch_lator')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->count();

        if ($is_exsist) {
            return "1";
        } else {
            return "0";
        }
    }

    public function addWatchLator(Request $request)
    {
        $user_id = session()->get('id');
        $movie_id = $request->movie_id;

        if (self::checkWatchLator($request)) {
            DB::table('watch_lator')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->delete();
        } else {
            DB::table('watch_lator')->insert([
                'user_id' => $user_id,
                'movie_id' => $movie_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function getWatchLator()
    {
        $user_id = session()->get('id');

        $records = DB::table('movies')
            ->join('watch_lator', 'movies.id', '=', 'watch_lator.movie_id')
            ->where('watch_lator.user_id', $user_id) // Filter by user_id
            ->select('movies.*') // Select all columns from the "movies" table
            ->get();

        return view('with-login.history', ['histroy' => $records, 'movie_count' => $records->count()]);
    }


    public static function checkFavorite(Request $request)
    {
        $user_id = session()->get('id');
        $movie_id = $request->movie_id;

        $is_exsist = DB::table('favorites')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->count();

        if ($is_exsist) {
            return "1";
        } else {
            return "0";
        }
    }

    public function addFavorite(Request $request)
    {
        $user_id = session()->get('id');
        $movie_id = $request->movie_id;

        if (self::checkFavorite($request)) {
            DB::table('favorites')->where('user_id', '=', $user_id)->where('movie_id', '=', $movie_id)->delete();
        } else {
            DB::table('favorites')->insert([
                'user_id' => $user_id,
                'movie_id' => $movie_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function getFavorite()
    {
        $user_id = session()->get('id');

        $records = DB::table('movies')
            ->join('favorites', 'movies.id', '=', 'favorites.movie_id')
            ->where('favorites.user_id', $user_id) // Filter by user_id
            ->select('movies.*') // Select all columns from the "movies" table
            ->get();

        return view('with-login.favorite', ['favorites' => $records, 'movie_count' => $records->count()]);
    }
}
