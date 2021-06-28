<?php

namespace App\Http\Controllers;

use DB;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
class SupplierController extends Controller
{
    protected $suppliers;
    public function __construct(SupplierModel $suppliers)
    {
        $this->middleware('auth');
        $data = array();

        $this->suppliers = $suppliers;
    }

    //get store product
    public function getstoreSupplier(){
        return view('pages.supplier.index');
    }
    //get all product
    public function getAllSupplier(){
        $data['suppliers'] = DB::table('suppliers')->orderBy('pk_no', 'DESC')->get();
        return view('pages.supplier.supplier-list', compact('data'));
    }
    //get edit supplier
    public function geteditSupplier($id){
        $data['suppliers'] = DB::table('suppliers')->orderBy('pk_no', 'DESC')->where('pk_no', $id)->first();
        return view('pages.supplier.edit-supplier', compact('data'));
    }
    //get update supplier
    public function updateSupplier(Request $request){
       $update = DB::table('suppliers')->where('pk_no', $request->id)->update([ 'supplier_name' => $request->name, 'supplier_remarks' => $request->remarks ]);
       if ($update) {
           return redirect()->back()->with('msg', 'Updated Successfully.');
        }else{
           return redirect()->back()->with('msg', 'You did not give any new value !!');
        } 

    }

    //store product
    public function storeSupplier(SupplierRequest $request){
           $resp = $this->suppliers->StoreSupplier($request); 
           return redirect()->back()->with('msg', $resp);
    }
    //delete supplier 
    public function deleteSupplier(Request $request){
           $delete = DB::table('suppliers')->where('pk_no', $request->id)->delete();
           if ($delete) {
               return redirect()->back()->with('msg', 'Deleted Successfully.');
            }else{
               return redirect()->back()->with('msg', 'Someting wrong !!');
            } 
    }
}
