<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductStorageRequest;
class ProductController extends Controller
{
    protected $product;
    public function __construct(ProductModel $product)
    {
        $this->middleware('auth');
        $data = array();

        $this->product = $product;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function CreateUser()
    {
        return view('pages.user.index');
    }

    //get store product
    public function getPaginatedList(Request $request){
        if (empty($request->fix_date)) {
            $from   = $request->from_date;
            $to     = $request->to_date;
           $data['products'] = DB::table('prd_master')->whereBetween('created_at', [$from, $to])->get();
        }else{
            $fixdate   = $request->fix_date;
            $data['products'] = DB::table('prd_master')->whereDate('created_at', $fixdate)->get();
        }

        if($request->download_excel == 1){
             $prd_data = DB::table('prd_master')->get()->toArray();
             $prd_array[] = array('Product Name', 'Quantity', 'Unit', 'Quantity Price', 'Price');
             foreach($prd_data as $product)
             {
              $prd_array[] = array(
               'Product Name'  => $product->prd_id,
               'Quantity'   => $product->prd_qty,
               'Unit'    => $product->prd_unit,
               'Quantity Price'  => $product->prd_qty_price,
               'Price'   => $product->prd_price
              );
             }
             Excel::create('Product Data', function($excel) use ($prd_array){
              $excel->setTitle('Product Data');
              $excel->sheet('Product Data', function($sheet) use ($prd_array){
              $sheet->fromArray($prd_array, null, 'A1', false, false);
              });
             })->download('xlsx');
                    
        }
        
        return view('pages.product.product-list', compact('data'));
    }

    //get store product
    public function getStoreProduct(){
        $data['productsname'] = DB::table('prd_name')->orderBy('pk_no', 'DESC')->get();
        return view('pages.product.index', compact('data'));
    }

    //get usage product
    public function getUsageProduct(){
        $data['productsname'] = DB::table('prd_name')->orderBy('pk_no', 'DESC')->get();
        return view('pages.product.usage-product', compact('data'));
    }
    //get product unit
    public function getProductUnit(Request $request){
        $prdNameId = $request->nameid;
        $productUnit = DB::table('prd_name')->where('pk_no', $prdNameId)->first();
        echo $productUnit->prd_unit;
    }
    //get product unit
    public function getProductQty(Request $request){
        $prdNameId = $request->nameid;
        $quantity = $request->quantity;
        $productUnit = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
        if ($quantity > $productUnit->prd_qty) {
            echo "over";
        }else{
            echo "success";
        }
        
    }
    //get all product
    public function getAllProduct(){
        $data['products'] = DB::table('prd_master')->orderBy('pk_no', 'DESC')->paginate(10);
        return view('pages.product.product-list', compact('data'));
    }
    //get get All Usage Product
    public function getAllUsageProduct(){
        $data['products'] = DB::table('prd_usage')->orderBy('pk_no', 'DESC')->paginate(10);
        return view('pages.product.product-usage-list', compact('data'));
    }

    //get live stock
    public function getLiveStock(){
        $data['products'] = DB::table('prd_stock')->join('prd_name', 'prd_name.pk_no', '=', 'prd_stock.prd_id')->get();
        return view('pages.product.live-stock', compact('data'));
    }

    //get edit product 
    public function getEditProduct($prdId){
        $data['products'] = DB::table('prd_master')->where('pk_no', $prdId)->first();

        $data['prdnames'] = DB::table('prd_name')->get();
        return view('pages.product.edit-product', compact('data'));
    }
    //get edit usage product
    public function getEditUsageProduct($prdId){
        $data['products'] = DB::table('prd_usage')->where('pk_no', $prdId)->first();

        $data['prdnames'] = DB::table('prd_name')->get();
        return view('pages.product.edit-usage-product', compact('data'));
    }

    //get live stock
    public function viewProduct($prdId){
        $data['products'] = DB::table('prd_master')->where('pk_no', $prdId)->first();

        $data['prdnames'] = DB::table('prd_name')->get();
        return view('pages.product.view-product', compact('data'));
    }

    //store product
    public function storeProduct(ProductRequest $request){
           $resp = $this->product->StoreProduct($request); 
           return redirect()->back()->with('msg', $resp);
    }
    //store Storage Product
    public function storeStorageProduct(ProductStorageRequest $request){
           $resp = $this->product->StoreStorageProduct($request); 
           return redirect()->back()->with('msg', $resp);
    }

    //update product
    public function updateProduct(ProductRequest $request){
           $resp = $this->product->UpdateProduct($request); 
           return redirect()->back()->with('msg', $resp);
    }
    //delete product
    public function deleteProduct($prdid){
           $resp = $this->product->DeleteProduct($prdid); 
           return redirect()->back()->with('msg', $resp);
    }
}
