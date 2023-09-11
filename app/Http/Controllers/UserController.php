<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

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
        if($check){
            if ($request->hasFile('profile_picture')) {
                $request->file('profile_picture')->move(public_path('/users/profile_pictures/'), $fileName);
            }            
            if(AccountContorller::sendEmail($request->email)){
                return 1;
            }
        }else{
            return 0;
        }
    }
}
