// public function UpdateProduct($request){
// //dd($request->all());
// DB::beginTransaction();
// try {
// $prdId = $request->prdid;
// $this->data['prd_id'] = $request->name;
// $this->data['prd_brand'] = $request->brand;
// $this->data['prd_qty'] = $request->quantity;
// $this->data['prd_unit'] = $request->unit;
// $this->data['prd_qty_price'] = $request->quantityprice;
// $this->data['prd_price'] = $request->totalprice;
// $this->data['prd_grand_price'] = $request->grandtotal;
// $this->data['prd_purchase_from'] = $request->purchasefrom;
// $this->data['prd_purchase_date'] = date('Y-m-d H:i:s', strtotime($request->purchasedate));
// $this->data['prd_req_dep'] = $request->reqdept;
// $this->data['supplier'] = $request->supplier;
// if ($request->expirydate) {
// $this->data['expiry_date'] = date('Y-m-d H:i:s', strtotime($request->expirydate));
// }
// if ($request->expiryalert) {
// $this->data['date_alert'] = date('Y-m-d H:i:s', strtotime($request->expiryalert));
// }

// $this->data['prd_details'] = $request->remarks;
// $this->data['updated_at'] = date('Y-m-d H:i:s');
// //if update prd_master table then update qty on prd_stock table
// $getrow = DB::table('prd_master')->where('pk_no', $prdId)->first();
// $prdQty = $getrow->prd_qty;
// $prdNameId = $getrow->prd_id;
// $getStockId = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
// $prdStockQty = $getStockId->prd_qty;
// $Qty = $prdStockQty - $prdQty;
// $newQty = $Qty+$request->quantity;
// $update = DB::table($this->table)->where('pk_no', $prdId)->update($this->data);
// if ($update == 1) {
// DB::table('prd_stock')->where('prd_id', $prdNameId)->update(['prd_qty' => $newQty]);
// }

// } catch (\Exception $e) {
// //dd($e);
// DB::rollback();
// return $resp = 'Product not updated successfully !!'.$e;
// }
// DB::commit();
// return $resp = 'Product has been updated successfully !!';
// }

// public function DeleteProduct($prdId){
// DB::beginTransaction();
// try {
// //if delete prd_master table row then update qty on prd_stock table
// $getrow = DB::table('prd_master')->where('pk_no', $prdId)->first();
// $prdQty = $getrow->prd_qty;
// $prdNameId = $getrow->prd_id;
// $getStock = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
// $prdStockQty = $getStock->prd_qty;
// $newQty = $prdStockQty - $prdQty;
// $delete = DB::table($this->table)->where('pk_no', $prdId)->delete();
// if ($delete == 1) {
// DB::table('prd_stock')->where('prd_id', $prdNameId)->update(['prd_qty' => $newQty]);
// }

// } catch (\Exception $e) {
// //dd($e);
// DB::rollback();
// return $resp = 'Product not deleted successfully !!'.$e;
// }
// DB::commit();
// return $resp = 'Product has been deleted successfully !!';
// }