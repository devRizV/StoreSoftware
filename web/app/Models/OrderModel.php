<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class OrderModel extends Model
{

    protected $table 		    = 'prd_master';
    protected $primaryKey   = 'pk_no';
    protected $data         = array();



 public function fetchDate($request){
      //dd($request->All());
      if (empty($request->fix_date)) {
            if (empty($request->department)) {
                $from   = $request->from_date;
                $to     = $request->to_date;
               $data = DB::table('prd_master')
               ->whereBetween('prd_purchase_date', [$from, $to])
               ->get();
               return $data;
            }else{
              $from   = $request->from_date;
                $to     = $request->to_date;
               $data = DB::table('prd_master')
               ->whereBetween('prd_purchase_date', [$from, $to])
               ->where('prd_req_dep', $request->department)
               ->get();
               return $data;
            }
            
        }else{
            $fixdate   = $request->fix_date;
            $data = DB::table('prd_master')->whereDate('prd_purchase_date', $fixdate)->get();
            return $data;
        }
 }
 public function fetchUsagePrdDate($request){
      if (empty($request->fix_date)) {
            $from   = $request->from_date;
            $to     = $request->to_date;
           $data = DB::table('prd_usage')->whereBetween('created_at', [$from, $to])->get();
           return $data;
        }else{
            $fixdate   = $request->fix_date;
            $data = DB::table('prd_usage')->whereDate('created_at', $fixdate)->get();
            return $data;
        }
 }   

 

    
}
