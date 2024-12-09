<?php

namespace App\Http\Controllers;

use DB;
use App\Models\ProductNameModel;
use Illuminate\Http\Request;
use App\Http\Requests\ProductNameRequest;
class ProductNameController extends Controller
{
    protected $product;
    public function __construct(ProductNameModel $product)
    {
        $this->middleware('auth');
        $data = array();

        $this->product = $product;
    }

    //get product name form
    public function getAddProductName(){
        return view('pages.product.save-product-name');
    }

    //get all product name form
    public function getAllProductName(){
        $data['products'] = DB::table('prd_name')->orderBy('pk_no', 'DESC')->get();
        return view('pages.product.product-name-list', compact('data'));
    }
    //store product
    public function saveProductName(ProductNameRequest $request){
           $resp = $this->product->StoreProductName($request);
           if ($resp == 'existerror') {
               $resp = "Product name already taken !!";
               return redirect()->back()->with('error', $resp);
            }else{
              return redirect()->back()->with('success', $resp);
            } 
           
        }

    //get edit department
    public function geteditProductName($id){
        $data['products'] = DB::table('prd_name')->orderBy('pk_no', 'DESC')->where('pk_no', $id)->first();
        return view('pages.product.edit-product-name', compact('data'));
    }

    //get update department
    public function updateProductName(Request $request){
     
       $str  = strtolower($request->name);
       $slug = preg_replace('/\s+/', '-', $str);
       $slugChk = DB::table('prd_name')
       ->where('prd_slug', $slug)
       ->where('pk_no', '!=', $request->id)
       ->count();
        if ($slugChk > 0) {
           $resp = "Product name already taken !!";
           return redirect()->back()->with('error', $resp);
        }
       $update = DB::table('prd_name')->where('pk_no', $request->id)->update([ 'prd_name' => $request->name, 'prd_slug' => $slug, 'prd_remarks' => $request->remarks, 'prd_unit' => $request->unit,'min_qty' => $request->minqty ]);
       if ($update) {
           return redirect()->back()->with('success', 'Updated Successfully.');
        }else{
           return redirect()->back()->with('error', 'You did not give any new value !!');
        } 

    }

    //delete department 
    public function deleteProductName(Request $request){
           $delete = DB::table('prd_name')->where('pk_no', $request->id)->delete();
           if ($delete) {
               return redirect()->back()->with('msg', 'Deleted Successfully.');
            }else{
               return redirect()->back()->with('msg', 'Someting wrong !!');
            } 
    }
}
