<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProductNameModel extends Model
{

    protected $table 		= 'prd_name';
    protected $primaryKey   = 'pk_no';
    protected $data  = array();

    public function StoreProductName($request){
            $str  = strtolower($request->name);
            $slug = preg_replace('/\s+/', '-', $str);
            $slugChk = DB::table('prd_name')->where('prd_slug', $slug)->count();
            if ($slugChk > 0) {
              return $resp = 'existerror';
            }
            DB::beginTransaction();
            try {
                $this->data['prd_name']           = $request->name;
                $this->data['prd_unit']           = $request->unit;
                $this->data['min_qty']            = $request->minqty;
                $this->data['prd_slug']           = $slug;
                $this->data['prd_remarks']        = $request->remarks;
                $this->data['created_at']         = date('Y-m-d H:i:s');
                DB::table($this->table)->insert($this->data);

              } catch (\Exception $e) {
                //dd($e);
                DB::rollback();
              return $resp = 'Product name not created successfully !!'.$e;
            }
            DB::commit();
                return $resp = 'Product name has been created successfully !!';
           }

    public function exportProductName($request)
        {
            $query = DB::table('prd_name')
                ->select('pk_no', 'prd_name', 'prd_unit', 'created_at');

            if ($request->prd_name) {
                $query->where('prd_name', $request->prd_name);
            }

            $data = $query->orderBy('pk_no', 'ASC')->get();

            return $data;
        }
    public function exportLiveStock()
        {
            $query = DB::table('prd_stock')
                ->join('prd_name', 'prd_name.pk_no', '=', 'prd_stock.prd_id')
                ->select('prd_stock.prd_id', 'prd_name.prd_name', 'prd_name.prd_unit', 'prd_stock.prd_qty')
                ->get();

            $data = $query->map(function ($item) {
                $minQty = DB::table('prd_name')->where('pk_no', $item->prd_id)->value('min_qty');
                $item->alert = ($item->prd_qty <= $minQty) ? 'Needs to be restocked' : 'Does not need restocking';
                return $item;
            });

            return $data;
        }
        
}
