<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductModel extends Model
{

    protected $table 		= 'prd_master';
    protected $primaryKey   = 'pk_no';
    protected $data  = array();

    public function StoreProduct($request)
    {
        DB::beginTransaction(); 
        try {
            $this->data['prd_id']             = $request['name'];
            $this->data['prd_brand']          = $request['brand'];
            $this->data['prd_qty']            = $request['quantity'];
            $this->data['prd_unit']           = $request['unit'];
            $this->data['prd_qty_price']      = $request['quantityprice'];
            $this->data['prd_price']          = $request['totalprice'];
            $this->data['prd_grand_price']    = $request['totalprice'];
            $this->data['prd_purchase_from']  = $request['purchasefrom'];
            $this->data['prd_purchase_date']  = date('Y-m-d H:i:s', strtotime($request['purchasedate']));
            $this->data['prd_req_dep']        = $request['reqdept'];
            $this->data['supplier']           = $request['supplier'];
            if ($request['expirydate']) {
                $this->data['expiry_date']        = date('Y-m-d H:i:s', strtotime($request['expirydate']));
            }
            if ($request["expiryalert"]) {
                $this->data['date_alert']         = date('Y-m-d H:i:s', strtotime($request['expiryalert']));
            }
            $this->data['prd_details']        = $request['remarks'];
            $this->data['created_at']         = date('Y-m-d H:i:s');
            DB::table($this->table)->insert($this->data);
        } catch (\Exception $e) {
            DB::rollback();
            return 'Product was not created successfully !!' . $e;
        }
        DB::commit();
        return 'Product(s) has been created successfully !!';
    }

    public function StoreStorageProduct($request)
    {
        DB::beginTransaction();
        try {
            $this->data['prd_name_id']        = $request->name;
            $this->data['prd_brand']          = $request->brand;
            $this->data['taken_by']           = $request->takenby;
            $this->data['taken_date']         = date('Y-m-d H:i:s', strtotime($request->takendate));
            $this->data['prd_qty']            = $request->quantity;
            $this->data['prd_unit']           = $request->unit;
            $this->data['prd_qty_price']      = $request->quantityprice;
            $this->data['prd_price']          = $request->totalprice;
            $this->data['prd_grand_price']    = $request->totalprice;
            $this->data['prd_remarks']        = $request->remarks;
            $this->data['created_at']         = date('Y-m-d H:i:s');
            DB::table('prd_usage')->insert($this->data);
        } catch (\Exception $e) {
            DB::rollback();
            return 'Product not inserted successfully !!' . $e;
        }
        DB::commit();
        return 'Product has been inserted successfully !!';
    }


    public function UpdateProduct($request)
    {
        DB::beginTransaction();
        try {
            $prdId                            = $request->prdid;
            $this->data['prd_id']             = $request->name;
            $this->data['prd_brand']          = $request->brand;
            $this->data['prd_qty']            = $request->quantity;
            $this->data['prd_unit']           = $request->unit;
            $this->data['prd_qty_price']      = $request->quantityprice;
            $this->data['prd_price']          = $request->totalprice;
            $this->data['prd_grand_price']    = $request->totalprice;
            $this->data['prd_purchase_from']  = $request->purchasefrom;
            $this->data['prd_purchase_date']  =  date('Y-m-d H:i:s', strtotime($request->purchasedate));
            $this->data['prd_req_dep']        = $request->reqdept;
            $this->data['supplier']           = $request->supplier;
            if ($request->expirydate) {
                $this->data['expiry_date']    = date('Y-m-d H:i:s', strtotime($request->expirydate));
            }
            if ($request->expiryalert) {
                $this->data['date_alert']     = date('Y-m-d H:i:s', strtotime($request->expiryalert));
            }

            $this->data['prd_details']        = $request->remarks;
            $this->data['updated_at']         = date('Y-m-d H:i:s');

            /**
            *   if update prd_master table then update qty on prd_stock table
            *   If name is changed it should change qty on prd_stock table for both of the products
            *   To do so we wiil first create a flag that will trigger if the name has been changed.
            *   If flag true -> get new prd, change its qty in prd_stock & get previous prd change it's stock in the prd_stock.
            *   If flag false -> change prd qty in prd_stock;
            *   Get flag by comparing the previous prd_id and current prd_id;
            */

            $product        = DB::table('prd_master')->where('pk_no', $prdId)->first();
            $oldProductId   = $product->prd_id;
            $oldProductQty  = $product->prd_qty;

            $isChanged = ($oldProductId != $request->name); // Checks if name has been changed or not 

            $update    = DB::table($this->table)->where('pk_no', $prdId)->update($this->data);

            if ($update) {
                if ($isChanged) {
                    $this->handleStockUpdate($oldProductId, -$oldProductQty);
                    $this->handkeStockUpdate($request->name, $request->quantity);

                } else {
                    $newQty = $request->quantity - $oldProductQty;
                    $this->handleStockUpdate($request->name, $newQty);
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            return 'Product not updated successfully!!!\n' . $e;
        }
        DB::commit();
        return [
            'msg' => 'Product update successfully.',
            'data' => $this->data,
        ];
    }

    public function DeleteProduct($prdId)
    {
        DB::beginTransaction();
        try {
            //if delete prd_master table row then update qty on prd_stock table
            $getrow        = DB::table('prd_master')->where('pk_no', $prdId)->first();
            $prdQty        = $getrow->prd_qty;
            $prdNameId     = $getrow->prd_id;
            $prdName       = $getrow->prd_name;
            $prdQty        = $getrow->prd_qty;
            $prdPrice      = $getrow->prd_qty_price;
            $purchasedAt   = $getrow->prd_purchase_date;

            $delete        = DB::table($this->table)->where('pk_no', $prdId)->delete();
            
            if ($delete) {
                $this->handleStockUpdate($prdNameId, $prdQty);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return "Product ({$prdName}) not deleted successfully !!" . $e;
        }
        DB::commit();
        return "Product has been deleted successfully !! ( Name: {$prdName} - Quantity: {$prdQty} - Price: {$prdPrice} - Purchased - {$purchasedAt})";
    }

    /**
     * Updates or creates a product for given ID 
     */
    private function updateOrCreateStock($productId, $newQuantity) {
        $stockExists = DB::table('prd_stock')->where('prd_id', $productId)->exists();

        if ($stockExists) {
            // Updating stock
            $update = DB::table('prd_stock')
            ->where('prd_id', $productId)
            ->update(['prd_qty' => $newQuantity]);
        } else {
            // Create new Stock
            DB::table('prd_stock')->insert([
                'prd_id' => $productId,
                'prd_qty' => $newQuantity,
            ]);
        }
    }

    /**
     * Fetches stock quantity for a given product ID 
     */

    private function getStockQuantity($productId) {
        return DB::table('prd_stock')->where('prd_id', $productId)->value('prd_qty') ?? 0;
    }

    /**
     * Adjust the stock quantity for given product ID 
     */

    private function handleStockUpdate($productId, $quantityChange) {
        $currentStock = $this->getStockQuantity($productId);
        $newStock     = $currentStock + $quantityChange;

        $this->updateOrCreateStock($productId, $newStock);
    }
}
