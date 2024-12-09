<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductNameModel;
use DB;

class RequisationController extends Controller
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
    public function getIndex()
    {
          $data['reqlist'] = DB::SELECT("SELECT prd_name.*, prd_stock.prd_qty from prd_name JOIN prd_stock ON prd_stock.prd_id = prd_name.pk_no WHERE prd_name.min_qty >= prd_stock.prd_qty ");
        return view('pages.requisation.index', compact('data'));
    }
    
}
