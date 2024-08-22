<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class SupplierModel extends Model
{

    protected $table 		= 'suppliers';
    protected $primaryKey   = 'pk_no';
    protected $data  = array();

    public function StoreSupplier($request){
        DB::beginTransaction();
        try {
            $this->data['supplier_name']           = $request->name;
            $this->data['supplier_remarks']        = $request->remarks;
            $this->data['created_at']              = date('Y-m-d H:i:s');
           DB::table($this->table)->insert($this->data);
          } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
          return $resp = 'Supplier not created successfully !!'.$e;
        }
        DB::commit();
        return $resp = 'Supplier has been created successfully !!';
       }
    

 

    
}
