<?php

namespace App\Http\Controllers;

use App\Mail\SendInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReferralController extends Controller
{

    public function sendInvitation(Request $request)
    {

        $reciver_email = $request->reciver_email;

        $is_exsist = DB::table('users')->where('email', '=', $reciver_email)->count();

        if ($is_exsist) {
            return 0;
        } else {
            $code = Str::random(6);
            DB::table('referrals')->insert([
                'referrer_id' => session()->get('id'),
                'referee_id' => "",
                'referral_code' => $code,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $mailData = [
                'code' => $code,
            ];

            Mail::to($reciver_email)->send(new SendInvitation($mailData));

            return 1;
        }
    }

    public function verify(string $refCode = null)
    {
        if ($refCode == null) {
            if (session()->has('refree_person')) {
                session()->remove('refree_person');
                session()->remove('refrel_code');
            }
            return view('login');
        } else {
            $referral_data = DB::table('referrals')->where('referral_code', '=', $refCode)->where('status', '=', '0')->first();
            if ($referral_data) {
                $user_data = DB::table('users')->where('id', '=', $referral_data->referrer_id)->first();
                session()->put('refree_person', $user_data);
                session()->put('refrel_code', $referral_data->referral_code);
                return view('login');
            } else {
                return redirect('/');
            }
        }
    }

    //for admin panel
    public function getReferralTable()
    {
        $users = DB::table('referrals')->join('users', 'referrals.referrer_id', '=', 'users.id')->select('users.username', 'referrals.*')->get();
        $output = '';
        $count = 1;

        foreach ($users as $user) {

            $status = $user->status == 1 ? '<td class="deactive">Referred</td>' : '<td class="active">Unreferred</td>';

            $output .= '<tr>
            <td>' . $count . '</td>
            <td>' . $user->username . '</td>
            <td>' . $user->referral_code . '</td>
            <td>' . $user->created_at . '</td>
            ' . $status . '
            </tr>';
            $count++;

        }
        return $output;
    }
}
