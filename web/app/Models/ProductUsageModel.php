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
            $this->data['prd_name_id']        = $request['name'];
            $this->data['dept']               = $request['reqdept'];
            $this->data['taken_by']           = $request['takenby'];
            $this->data['taken_date']         = date('Y-m-d H:i:s', strtotime($request['takendate']));
            $this->data['prd_qty']            = $request['quantity'];
            $this->data['prd_qty_price']      = $request['quantityprice'];
            $this->data['prd_price']          = $request['totalprice'];
            $this->data['prd_grand_price']    = $request['totalprice'];
            $this->data['prd_unit']           = $request['unit'];
            $this->data['prd_remarks']        = $request['remarks'];
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
        DB::beginTransaction();
        try {
            $prdId                            = $id;
            $this->data['prd_name_id']        = $request->name;
            $this->data['dept']               = $request->reqdept;
            $this->data['taken_by']           = $request->takenby;
            $this->data['taken_date']         = date('Y-m-d H:i:s', strtotime($request->takendate));
            $this->data['prd_qty']            = $request->quantity;
            $this->data['prd_qty_price']      = $request->quantityprice;
            $this->data['prd_price']          = $request->totalprice;
            $this->data['prd_grand_price']    = $request->totalprice;
            $this->data['prd_unit']           = $request->unit;
            $this->data['prd_remarks']        = $request->remarks;
            $this->data['created_at']         = date('Y-m-d H:i:s');

            /**
             *   if update prd_master table then update qty on prd_stock table
             *   If name is changed it should change qty on prd_stock table for both of the products
             *   To do so, we will first create a flag that will trigger if the name has been changed.
             *   If flag true -> get new prd, change its qty in prd_stock & get previous prd change it's stock in the prd_stock.
             *   If flag false -> change prd qty in prd_stock;
             *   Get flag by comparing the previous prd_id and current prd_id;
             */

            //if update prd_usage table then update qty on prd_stock table
            // $getrow        = DB::table('prd_usage')->where('pk_no', $prdId)->first();
            // $prdQty        = $getrow->prd_qty;
            // $prdNameId     = $getrow->prd_name_id;
            // $getStockId    = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
            // $prdStockQty   = $getStockId->prd_qty;
            // $Qty           = $prdStockQty + $prdQty;
            // $newQty        = $Qty - $request->quantity;

            $product          = DB::table('prd_usage')->where('pk_no', $prdId)->first();

            $oldProductId     = $product->prd_name_id;
            $oldProductQty    = $product->prd_qty;
            $newProductQty    = (float) $request->quantity;
            $isChanged        = ($oldProductId != $request->name); // check if name has been changed or not

            $update        = DB::table('prd_usage')->where('pk_no', $prdId)->update($this->data);

           if ($update == 1) {
               if ($isChanged) {
                $updateNewPrdStock = $this->handleStockUpdate($request->name, $request->quantity);
                $updateOldPrdStock = $this->handleStockUpdate($oldProductId, -$oldProductQty);
                // dd($updateNewPrdStock, $updateOldPrdStock);
                if (!$updateNewPrdStock && $updateOldPrdStock) {
                  DB::rollback();
                  return 'Product not updated successfully !!! Please check product stock before updating !!!';
                }
                
              } else {
                $newQty = $oldProductQty - $newProductQty;
                $this->handleStockUpdate($request->name, -$newQty);
              }
           }
          } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            return 'Product not updated successfully !!'.$e;
        }
        DB::commit();
        return 'Product has been updated successfully !!';
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
          return 'Product not deleted successfully !!'.$e;
        }
        DB::commit();
        return 'Product has been deleted successfully !!';
       }


  /**
   * Updates or creates a product for given ID 
   */
  private function updateStock($productId, $newQuantity)
  {
    // Updating stock
    $update = DB::table('prd_stock')
    ->where('prd_id', $productId)
    ->update(['prd_qty' => $newQuantity]);
  }

  /**
   * Fetches stock quantity for a given product ID 
   */

  private function getStockQuantity($productId)
  {
    return DB::table('prd_stock')
              ->where('prd_id', $productId)
              ->value('prd_qty') ?? 0;
  }

  /**
   * Adjust the stock quantity for given product ID 
   */

  private function handleStockUpdate($productId, $quantityChange)
  {
    $currentStock = $this->getStockQuantity($productId);
    // dd("product id: " . $productId, "current stock: " . $currentStock, "change: " . $quantityChange );
    // dd(!$currentStock < $quantityChange);
    if (!$currentStock < $quantityChange) {
      $newStock = $currentStock - $quantityChange;
      $update = $this->updateStock($productId, $newStock);
      return true;
    } else {
      return false;
    }
  }
      
}
