<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        $totalUsersCount = DB::table('users')->where('account_status','!=','-1')->count();
        
        $totalMovieCount = DB::table('movies')->count();
        
        
        $totalActiveAdmins = DB::table('users')->where('account_status','!=','-1')->where('role','=','1')->get();
        $totalAdminCount = DB::table('users')->where('account_status','!=','-1')->where('role','=','1')->count();


        $totalCounts = [
            'userCount' => $totalUsersCount,
            'movieCount' => $totalMovieCount,
            'adminCount' => $totalAdminCount,
        ];
        return view('admin.dashboard',['counts'=>$totalCounts,'admin'=>$totalActiveAdmins]);
    }
}
