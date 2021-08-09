<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProductUsageModel extends Model
{

    protected $table 		      = 'prd_usage';
    protected $primaryKey     = 'pk_no';
    protected $data           = array();

    public function StoreUsagesProduct($request){
        DB::beginTransaction();
        try {
            $this->data['prd_name_id']        = $request->name;
            $this->data['dept']               = $request->dept;
            $this->data['taken_by']           = $request->takenby;
            $this->data['taken_date']         = date('Y-m-d H:i:s', strtotime($request->takendate));
            $this->data['prd_qty']            = $request->quantity;
            $this->data['prd_qty_price']      = $request->quantityprice;
            $this->data['prd_price']          = $request->totalprice;
            $this->data['prd_grand_price']    = $request->grandtotal;
            $this->data['prd_unit']           = $request->unit;
            $this->data['prd_remarks']        = $request->remarks;
            $this->data['created_at']         = date('Y-m-d H:i:s');
           DB::table('prd_usage')->insert($this->data);

          } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
          return $resp = 'Product not inserted successfully !!'.$e;
        }
        DB::commit();
        return $resp = 'Product has been inserted successfully !!';
       }


       public function updateUsageProduct($request, $id){
        //dd($request);
        DB::beginTransaction();
        try {
            $prdId                            = $id;
            $this->data['prd_name_id']        = $request->name;
            $this->data['dept']               = $request->dept;
            $this->data['taken_by']           = $request->takenby;
            $this->data['taken_date']         = date('Y-m-d H:i:s', strtotime($request->takendate));
            $this->data['prd_qty']            = $request->quantity;
            $this->data['prd_qty_price']      = $request->quantityprice;
            $this->data['prd_price']          = $request->totalprice;
            $this->data['prd_grand_price']    = $request->grandtotal;
            $this->data['prd_unit']           = $request->unit;
            $this->data['prd_remarks']        = $request->remarks;
            $this->data['created_at']         = date('Y-m-d H:i:s');

            //if update prd_usage table then update qty on prd_stock table
            $getrow        = DB::table('prd_usage')->where('pk_no', $prdId)->first();
            $prdQty        = $getrow->prd_qty;
            $prdNameId     = $getrow->prd_name_id;
            $getStockId    = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
            $prdStockQty   = $getStockId->prd_qty;
            $Qty           = $prdStockQty + $prdQty;
            $newQty        = $Qty-$request->quantity;
            $update        = DB::table('prd_usage')->where('pk_no', $prdId)->update($this->data);
           if ($update == 1) {
               DB::table('prd_stock')->where('prd_id', $prdNameId)->update(['prd_qty' => $newQty]);
           }

          } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
          return $resp = 'Product not updated successfully !!'.$e;
        }
        DB::commit();
        return $resp = 'Product has been updated successfully !!';
       }



       public function DeleteProduct($prdId){
        DB::beginTransaction();
        try {
            //if delete prd_master table row then update qty on prd_stock table
            $getrow        = DB::table('prd_usage')->where('pk_no', $prdId)->first();
            $prdQty        = $getrow->prd_qty;
            $prdNameId     = $getrow->prd_name_id;
            $getStock      = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
            $prdStockQty   = $getStock->prd_qty;
            $newQty        = $prdStockQty + $prdQty;
            $delete        = DB::table($this->table)->where('pk_no', $prdId)->delete();
           if ($delete == 1) {
               DB::table('prd_stock')->where('prd_id', $prdNameId)->update(['prd_qty' => $newQty]);
           }

          } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
          return $resp = 'Product not deleted successfully !!'.$e;
        }
        DB::commit();
        return $resp = 'Product has been deleted successfully !!';
       }

 

    
}
