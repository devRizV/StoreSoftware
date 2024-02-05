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
    

 

    
}
