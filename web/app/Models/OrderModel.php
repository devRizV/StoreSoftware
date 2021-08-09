<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class OrderModel extends Model
{

    protected $table 		    = 'prd_master';
    protected $primaryKey   = 'pk_no';
    protected $data         = array();



 public function fetchData($request){
      //dd($request->All());
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

        $data = $query->orderBy('prd_master.pk_no','DESC')->get();
        return $data;
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
