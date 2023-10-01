<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerificationMail;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AccountContorller extends Controller
{

    public static function verificationToken()
    {
        return  uniqid() . Str::random(16);
    }

    public static function sendVerificationEmail(string $email)
    {
        $mailData = [];
        $user = DB::table('users')->select('username', 'email', 'verification_token')->where('email', '=', $email)->get();
        foreach ($user as $user) {
            $mailData = [
                "username" => $user->username,
                "token" => $user->verification_token,
            ];
        }
        mail::to($email)->send(new AccountVerificationMail($mailData));
        return true;
    }

    public function accountActivator(string $token)
    {
        $user = DB::table('users')->where('verification_token', '=', $token)->get();
        if ($user->count() != 1) {
            return abort(404, "Invalid Token");
        }
        foreach ($user as $user) {
            if ($user->account_status == 1) {
                Session::flash('already_activate', "Your account already activate successfully!!");
                return redirect()->route('login');
            } else {
                DB::table('users')->where('verification_token', '=', $token)->update([
                    'account_status' => '1',
                ]);

                Session::flash('activate', "Account activate successfully!!");
                return redirect()->route('login');
            }
        }
    }

    public function login(Request $request)
    {

        // Authorization Process
        /**
         * 1 = Login Successfull (admin).
         * 2 = Login Successfull (user subscribed).
         * 3 = Login Successfull but (user is not subscribe).
         * 4 = Login Successfull but (account is not activated).
         * 0 = Invalid Password.
         * -1 = User doesn't exsist.
         * -2 = User deleted.
         */

        $username = $request->lg_username;
        $password = $request->lg_password;

        $count = DB::table('users')->where('username', '=', $username)->count();
        if ($count == 1) {
            $user = DB::table('users')->where('username', '=', $username)->get();
            foreach ($user as $user) {
                $encryptedPassword = $user->password;
                $accountStatus = $user->account_status;
                $email = $user->email;

                if (Hash::check($password, $encryptedPassword) && $accountStatus == 1) {
                    session()->put('login', true);
                    session()->put('id', $user->id);
                    session()->put('username', $username);
                    session()->put('email', $email);
                    session()->put('dp', $user->profile_picture);
                    session()->put('subscription_status', $user->subscription_status);
                    session()->put('role', $user->role);
                    //Admin
                    if ($user->role == 1) {
                        return 1;
                    }
                    //Subscriber
                    else if ($user->subscription_status == 1) {
                        return 2;
                    }
                    //New User
                    else {
                        return 3;
                    }
                }
                // account is deleted.
                else if (Hash::check($password, $encryptedPassword) && $accountStatus == -1) {
                    return -2;
                }
                // New User but account is not activated.
                else if (Hash::check($password, $encryptedPassword) && $accountStatus == 0) {
                    self::sendVerificationEmail($email);
                    return 4;
                }
                // User doesn't exsist 
                else {
                    return 0;
                }
            }
        } else {
            return -1;
        }
    }

    public function logout()
    {
        session()->remove('login');
        session()->remove('id');
        session()->remove('username');
        session()->remove('email');
        session()->remove('dp');
        session()->remove('subscription_status');
        session()->remove('role');

        return redirect()->route('login');
    }

    //forget password
    public function sendResetLink(Request $request)
    {
        $is_exsist = DB::table('users')->where('email', '=', $request->email)->count();

        if ($is_exsist) {
            $user = DB::table('users')->where('email', '=', $request->email)->first();

            $username = $user->username;
            $token = self::verificationToken();

            $mailData = [
                'username' => $username,
                'token' => $token,
            ];

            $isTokenExsist = DB::table('reset_passwords_tokens')->where('user_id', '=', $user->id)->count();
            if ($isTokenExsist) {
                DB::table('reset_passwords_tokens')->where('user_id', '=', $user->id)->delete();
            }

            DB::table('reset_passwords_tokens')->insert([
                'user_id' => $user->id,
                'token' => $token,
                'expire_time' => Carbon::now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            mail::to($request->email)->send(new ResetPasswordMail($mailData));

            return 1;
        } else {
            return -1;
        }
    }

    public function verifyResetLink(Request $request)
    {
        $is_token_exsist = DB::table('reset_passwords_tokens')->where('token', '=', $request->token)->count();
        if ($is_token_exsist) {
            $token_details = DB::table('reset_passwords_tokens')->where('token', '=', $request->token)->first();

            if (Carbon::now()->gt($token_details->expire_time)) {
                DB::table('reset_passwords_tokens')->where('token', '=', $token_details->token)->delete();
                Session::flash('token_expire', "Activation link is expired, Please try again!!");
                return redirect()->route('login');
            } else {
                session()->put('forgot_password_user_id', $token_details->user_id);
                return redirect()->route('forget_password.update_password');
            }
        } else {
            Session::flash('token_not_found', "Activation link is expired or invalid, Please try again!!");
            return redirect()->route('login');
        }
    }

    public function changePassword(Request $request)
    {
        $user_id = session()->get('forgot_password_user_id');
        session()->remove('forgot_password_user_id');
        DB::table('users')->where('id', '=', $user_id)->update([
            'password' => bcrypt($request->password),
        ]);
        $token_details = DB::table('reset_passwords_tokens')->where('user_id', '=', $user_id)->first();
        DB::table('reset_passwords_tokens')->where('token', '=', $token_details->token)->delete();
        Session::flash('password_update', "Password change successfully!!");
        return "1";
    }

}