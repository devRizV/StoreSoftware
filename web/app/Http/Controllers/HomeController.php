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
        $department = DB::table('departments')->count();
        $users = DB::table('users')->count();
        $currentMonth = date('m');
        $purchase = DB::table("prd_master")
            ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            ->sum('prd_price');
        $todayPur = DB::table('prd_master')->whereDate('created_at', DB::raw('CURDATE()'))
        ->sum('prd_price');

        //  $data['notify'] = DB::table('prd_name as prdname')
        // ->join('prd_stock as stock', 'stock.prd_id', '=', 'prdname.pk_no')
        // ->join('prd_master as prdmaster', 'prdmaster.prd_id', '=', 'prdname.pk_no')
        // ->select('prdname.pk_no as pk_no', 'prdname.prd_name as product_name', 'stock.prd_qty as stock_qty', 'prdmaster.expiry_date as expired_date', 'prdmaster.date_alert as date_alert')
        // ->where('stock.prd_qty', '<=', 'prdname.min_qty')
        // ->where('prdname.min_qty', '!=', null)
        //->get();

        // $data['notify'] = DB::table('prd_name')
        // ->join('prd_stock', 'prd_stock.prd_id', '=', 'prd_name.pk_no')
        // ->where('prd_stock.prd_qty', '>', 'prd_name.min_qty')
        // ->get();
        // dd($data);
        $data['notify'] = ProductNameModel::select("prd_name.*")
            ->join("prd_stock","prd_stock.prd_id","=","prd_name.pk_no")
            ->where("prd_stock.prd_qty","=","prd_name.min_qty")
            ->get();
            dd($data);
        return view('home', compact('department', 'users', 'purchase', 'todayPur', 'data'));
    }

    
}
