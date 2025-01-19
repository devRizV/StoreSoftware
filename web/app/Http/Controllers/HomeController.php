<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductNameModel;
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
        $departments = DB::table('departments')->count();
        $suppliers  = DB::table('suppliers')->count();
        $users = DB::table('users')->count();
        $currentMonth = date('m');
        $purchase = DB::table("prd_master")
            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            ->sum('prd_price');
        $todayPur = DB::table('prd_master')->whereDate('created_at', DB::raw('CURDATE()'))
        ->sum('prd_price');
        

         $data['notify'] = DB::SELECT("SELECT prd_name.*, prd_stock.prd_qty, prd_master.supplier,prd_master.prd_req_dep from prd_name 
            JOIN prd_stock ON prd_stock.prd_id = prd_name.pk_no 
            JOIN prd_master ON prd_master.prd_id = prd_name.pk_no WHERE prd_name.min_qty >= prd_stock.prd_qty ");
         $data['todayPurchaseList'] = DB::table('prd_master')->whereDate('created_at', DB::raw('CURDATE()'))->get();
        return view('home', compact('departments', 'suppliers', 'users', 'purchase', 'todayPur', 'data'));
    }

    
}
