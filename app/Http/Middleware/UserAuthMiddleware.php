<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if(session()->has('login')){
            $isSubscriberOrAdmin = session()->get('subscription_status') == 1 || session()->get('role') == 1;
            if($isSubscriberOrAdmin){
                $redirectPaths = [
                    'home',
                    'login',
                    'pricing',
                    'discount',
                ];

                foreach ($redirectPaths as $pattern) {
                    if($request->is($pattern)){
                        return redirect()->back();
                    }
                }
            }
            else{
                $redirectPaths = [
                    'user/*',
                    'admin/*',
                    'home',
                    'user-create',
                    'activate/*',
                    'login'
                ];
                foreach($redirectPaths as $pattern){
                    if($request->is($pattern)){
                        return redirect()->back();
                    }
                }
            }

            if(session()->get('role') == 0 && $request->is('admin/*')){
                return redirect()->back();
            }
        }else{
            $restrictedPaths = [
                'admin/*',
                'user/*',
                'pricing',
                'discount',
                'logout',
            ];

            foreach($restrictedPaths as $pattern){
                if($request->is($pattern)){
                    return redirect()->back();
                }
            }
        }
        return $next($request);
    }
}
