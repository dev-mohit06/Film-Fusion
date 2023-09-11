<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerificationMail;
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

    public static function sendEmail(string $email)
    {
        $mailData = [];
        $user = DB::table('users')->select('username', 'email', 'verification_token')->get();
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

    // Authorization Process
    /**
     * 1 = Login Successfull (admin).
     * 2 = Login Successfull (user subscribed).
     * 3 = Login Successfull (user not subscribe).
     * 4 = Login Successfull but account is not activated.
     * 0 = Invalid Password.
     * -1 = User doesn't exsist.
     */
    public function login(Request $request)
    {
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
                    session()->put('dp',$user->profile_picture);
                    session()->put('subscription_status', $user->subscription_status);
                    session()->put('role',$user->role);
                    //Admin
                    if($user->role == 1){
                        return 1;
                    }
                    //Subscriber
                    else if($user->subscription_status == 1){
                        return 2;
                    }
                    //New User
                    else{
                        return 3;
                    }
                } 
                // New User but account is not activated.
                else if (Hash::check($password, $encryptedPassword) && $accountStatus == 0) {
                    self::sendEmail($email);
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

    public function logout(){
        session()->remove('login');
        session()->remove('id');
        session()->remove('username');
        session()->remove('email');
        session()->remove('dp');
        session()->remove('subscription_status');
        session()->remove('role');

        return redirect()->route('login');
    }
}
