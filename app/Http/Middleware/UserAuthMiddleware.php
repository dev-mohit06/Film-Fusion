<?php

namespace App\Http\Middleware;

use App\Mail\SendOffers;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('login')) {
            $isSubscriberOrAdmin = session()->get('subscription_status') == 1 || session()->get('role') == 1;
            if ($isSubscriberOrAdmin) {

                //Collection the current loggedin user data
                $user = DB::table('users')->where('id', '=', session()->get('id'))->get();
                foreach ($user as $user) {
                    // Collection the current subscription Details with it's count
                    $subscriptionsDetails = DB::table('subscriptions')->where('user_id', '=', $user->id)->where('is_active', '=', 1)->get();
                    $subscriptionsDetailsCount = DB::table('subscriptions')->where('user_id', '=', $user->id)->where('is_active', '=', 1)->count();

                    if ($subscriptionsDetailsCount == 1) {
                        foreach ($subscriptionsDetails as $subscriptionsDetails) {

                            // Checking the plan is expired or not
                            if (Carbon::now()->toDateString() == $subscriptionsDetails->expire_date) {
                                DB::table('users')->where('id', '=', $user->id)->update([
                                    'subscription_status' => 0
                                ]);

                                DB::table('subscriptions')->where('user_id', '=', $user->id)->where('is_active', '=', 1)->update([
                                    'is_active' => 0
                                ]);

                                $offers = DB::table('offers')->where('offer_status','=',1)->get();
                            
                                $mailData = [
                                    'offers' => $offers,
                                ];

                                $userData = DB::table('users')->where('id','=',$user->id)->first();

                                mail::to($userData->email)->send(new SendOffers($mailData));                             

                                session()->put('subscription_status', 0);
                                return redirect()->route('pricing');
                            }
                        }
                    }
                }

                $redirectPaths = [
                    'home',
                    'login',
                    'pricing',
                    'discount/*',
                    'checkout',
                    'afterCheckout',
                    'applyCoupn',
                    'forget-password',
                    'change-password',
                ];

                if ($isSubscriberOrAdmin && $request->is('home')) {
                    return redirect()->route('user.home');
                }

                foreach ($redirectPaths as $pattern) {
                    if ($request->is($pattern)) {
                        return redirect()->back();
                    }
                }
            } else {
                $redirectPaths = [
                    'user/*',
                    'admin/*',
                    'home',
                    'user-create',
                    'activate/*',
                    'login',
                    'forget-password',
                    'change-password',
                ];
                foreach ($redirectPaths as $pattern) {
                    if ($request->is($pattern)) {
                        return redirect()->route('pricing');
                    }
                }
            }

            if (session()->get('role') == 0 && $request->is('admin/*')) {
                return redirect()->back();
            }
        } else {

            if ($request->is('admin/*') || $request->is('user/*')) {
                return redirect()->route('login');
            }

            $restrictedPaths = [
                'pricing',
                'discount',
                'logout',
                'checkout',
                'afterCheckout',
                'applyCoupn',
            ];

            foreach ($restrictedPaths as $pattern) {
                if ($request->is($pattern)) {
                    return redirect()->back();
                }
            }
        }
        return $next($request);
    }
}
