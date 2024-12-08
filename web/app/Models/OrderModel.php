<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class OrderModel extends Model
{

    protected $table        = 'prd_master';
    protected $primaryKey   = 'pk_no';
    protected $data         =  array();
    
    public function fetchData($request){
           $query = DB::table('prd_master');
           if($request->fix_date){
                $query->whereDate('prd_purchase_date', $request->fix_date);
            }else{
               if ($request->from_date && $request->to_date) {
                  $from   = $request->from_date;
                  $to     = $request->to_date;
                  $query->whereBetween('prd_purchase_date', [$from, $to]);
               }               
            }
    
            if($request->department){
                $query->where('prd_req_dep', $request->department);
            }
            if($request->supplier){
                $query->where('supplier', $request->supplier);
            }

            $sum = $query->sum('prd_price');
    
            $data = $query->orderBy('prd_master.pk_no','DESC')
                ->join('prd_stock', 'prd_stock.prd_id', '=', 'prd_master.prd_id')
                ->select(
                    'prd_master.*',
                    'prd_stock.prd_qty as stock',
                )
                ->orderBy('prd_master.pk_no', 'DESC')
                ->get();
            return [
                    'products' => $data,
                    'sum' => $sum,
                ];
         }
    
     public function fetchUsagePrdDate($request){
          $query = DB::table('prd_usage');
           if($request->fix_date){
                $query->whereDate('taken_date', $request->fix_date);
            }else{
               if ($request->from_date && $request->to_date) {
                  $from   = $request->from_date;
                  $to     = $request->to_date;
                  $query->whereBetween('taken_date', [$from, $to]);
               }
                
            }
    
            if($request->department){
                $query->where('dept', $request->department);
            }
            $sum = $query->sum('prd_price');
            $data = $query->orderBy('prd_usage.pk_no','DESC')
                ->join('prd_stock', 'prd_stock.prd_id', '=', 'prd_usage.prd_name_id')
                ->select(
                    'prd_usage.*',
                    'prd_stock.prd_qty as stock'
                )
                ->get();
            // dd($data);
            return [
                'products'  => $data,
                'sum'       => $sum,
            ];
     }    
}
