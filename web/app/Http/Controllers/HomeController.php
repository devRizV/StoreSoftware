<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $department = DB::table('departments')->count();
        $users = DB::table('users')->count();
        $currentMonth = date('m');
        $purchase = DB::table("prd_master")
            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            ->sum('prd_price');
        $todayPur = DB::table('prd_master')->whereDate('created_at', DB::raw('CURDATE()'))
        ->sum('prd_price');
        return view('home', compact('department', 'users', 'purchase', 'todayPur'));
    }

    
}
