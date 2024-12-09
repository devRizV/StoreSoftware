<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class DepartmentModel extends Model
{

    protected $table 		= 'departments';
    protected $primaryKey   = 'pk_no';
    protected $data  = array();

    public function StoreDepartment($request){
        DB::beginTransaction();
        try {
            $this->data['dep_name']           = $request->name;
            $this->data['dep_remarks']        = $request->remarks;
            $this->data['created_at']         = date('Y-m-d H:i:s');
           DB::table($this->table)->insert($this->data);
          } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
          return $resp = 'Department not created successfully !!'.$e;
        }
        DB::commit();
        return $resp = 'Department has been created successfully !!';
       }
    

 

    
}
