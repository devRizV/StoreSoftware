<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ProductUsageModel;
use App\Models\SupplierModel;
use App\Models\OrderExport;
use App\Models\UsageOrderExport;
use App\Models\DepartmentModel;
use App\Models\OrderModel;
use Maatwebsite\Excel\Excel;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductStorageRequest;
class ProductController extends Controller
{
    protected $product;
    protected $supplier;
    protected $prdusage;
    protected $getProductList;
    public function __construct(ProductModel $product, ProductUsageModel $prdusage, OrderModel $getProductList,SupplierModel $supplier)
    {
        $this->middleware('auth');
        $data = array();

        $this->getProductList = $getProductList;
        $this->product = $product;
        $this->supplier = $supplier;
        $this->prdusage = $prdusage;
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
        //dd($request->All());
        $data['products'] = $this->getProductList->fetchData($request);

        if($request->download_excel == 1){
            //dd($data['products']);
             return \Excel::download(new OrderExport($data), date('d-m-Y').'_order.xlsx');
        }
        $data['department'] = DepartmentModel::all();
        $data['supplier'] = SupplierModel::all();
        return view('pages.product.product-list', compact('data'));
    }
    //get usage product list
    public function getUsageProductList(Request $request){
        $data['products'] = $this->getProductList->fetchUsagePrdDate($request);
        if($request->download_excel == 1){
             return \Excel::download(new UsageOrderExport($data), date('d-m-Y').'_order.xlsx');
        }
        $data['department'] = DepartmentModel::all();
        return view('pages.product.product-usage-list', compact('data'));
    }

    //get store product
    public function getStoreProduct(){
        $data['department'] = DepartmentModel::all();
        $data['supplier'] = SupplierModel::all();
        $data['productsname'] = DB::table('prd_name')->orderBy('pk_no', 'DESC')->get();
        return view('pages.product.index', compact('data'));
    }

    //get usage product
    public function getUsageProduct(){
        $data['productsname'] = DB::table('prd_stock as S')
        ->leftJoin('prd_name as N', 'N.pk_no', '=', 'S.prd_id')
        ->select('N.prd_name', 'N.pk_no')
        ->orderBy('N.pk_no', 'DESC')
        ->get();
        $data['department'] = DepartmentModel::all();
        return view('pages.product.usage-product', compact('data'));
    }
    //get product unit
    public function getProductUnit(Request $request){
        $prdNameId = $request->nameid;
        $productUnit = DB::table('prd_name')->where('pk_no', $prdNameId)->first();
        echo $productUnit->prd_unit;
    }

    //get product unit and price for usage page
    public function getUsageProductUnit(Request $request){
        $prdNameId = $request->nameid;
        $productdata = DB::table('prd_master')
        ->where('prd_id', $prdNameId)
        ->orderBy('pk_no', 'DESC')
        ->first();
        $data['unit']  = $productdata->prd_unit;
        $data['qtyprice']  = $productdata->prd_qty_price;
        $data['dep']  = $productdata->prd_req_dep;
        $data['status'] = 'over';
        return response()->json($data);
    }
    //get product unit
    public function getProductUnitAndPrice(Request $request){
        $prdNameId = $request->nameid;
        $productUnit = DB::table('prd_name')->where('pk_no', $prdNameId)->first();
        $data['productUnit'] = DB::table('prd_name as N')
        ->leftJoin('prd_master as M', 'M.prd_id', '=', 'N.pk_no')
        ->select('N.prd_unit', 'M.prd_qty_price')
        ->first();
        return $data;
    }
    //get product unit
    public function getProductQty(Request $request){
        $prdNameId = $request->nameid;
        $quantity = $request->quantity;
        $productUnit = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
        if ($quantity > $productUnit->prd_qty) {
            $data['qty']  = $productUnit->prd_qty;
            $data['status'] = 'over';
            return response()->json($data);
        }else{
            echo "success";
        }
        
    }
    //get product qty
    public function updateProductQty(Request $request){
        $prdNameId = $request->nameid;
        $quantity = $request->quantity;
        $productStockUnit = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
        $productUsageUnit = DB::table('prd_usage')->where('prd_name_id', $prdNameId)->first();
        $TotalQuantity = $productStockUnit->prd_qty+$productUsageUnit->prd_qty;
        if ($quantity > $TotalQuantity) {
            $data['qty']  = $TotalQuantity;
            $data['status'] = 'over';
            return response()->json($data);
        }else{
            echo "success";
        }
        
    }
    //get all product
    public function getAllProduct(){
        $data['products'] = DB::table('prd_master')->orderBy('pk_no', 'DESC')->get();
        $data['department'] = DepartmentModel::all();
        $data['supplier'] = SupplierModel::all();
        return view('pages.product.product-list', compact('data'));
    }
    //get get All Usage Product
    public function getAllUsageProduct(){
        $data['products'] = DB::table('prd_usage')->orderBy('pk_no', 'DESC')->paginate(10);
        $data['department'] = DepartmentModel::all();
        return view('pages.product.product-usage-list', compact('data'));
    }

    //get live stock
    public function getLiveStock(){
        // $data['products'] = DB::table('prd_stock')
        // ->join('prd_name', 'prd_name.pk_no', '=', 'prd_stock.prd_id')
        // ->join('prd_master', 'prd_master.prd_id', '=', 'prd_stock.prd_id')
        // ->get();
        //  $data['products'] = DB::table('prd_stock')
        //         ->join('prd_master','prd_stock.prd_id', '=', 'prd_master.prd_id')
        //         ->select('prd_stock.prd_id','prd_stock.prd_qty', 'prd_master.prd_qty_price')
        //         ->groupBy('prd_stock.prd_id', 'prd_stock.prd_qty','prd_master.prd_qty_price')
        //         ->limit(10)
        //         ->get();
        
        // dd($data['products']);

        $sql = "SELECT pk_no FROM prd_name LEFT JOIN prd_stock ON prd_name.pk_no = prd_stock.prd_id LEFT JOIN prd_master ON prd_name.pk_no = prd_master.prd_id limit 50";
        $data['products'] = DB::select($sql);
        dd($data['products']);
        return view('pages.product.live-stock', compact('data'));
    }

    //get edit product 
    public function getEditProduct($prdId){
        $data['products'] = DB::table('prd_master')->where('pk_no', $prdId)->first();
         $data['department'] = DepartmentModel::all();
         $data['supplier'] = SupplierModel::all();
        $data['prdnames'] = DB::table('prd_name')->get();
        return view('pages.product.edit-product', compact('data'));
    }
    //get edit usage product
    public function getEditUsageProduct($prdId){
        $data['products'] = DB::table('prd_usage')->where('pk_no', $prdId)->first();
        $data['department'] = DepartmentModel::all();
        $data['prdnames'] = DB::table('prd_stock as S')
        ->leftJoin('prd_name as N', 'N.pk_no', '=', 'S.prd_id')
        ->select('N.prd_name', 'N.pk_no')
        ->orderBy('N.pk_no', 'DESC')
        ->get();
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
           $resp = $this->prdusage->StoreUsagesProduct($request); 
           return redirect()->back()->with('msg', $resp);
    }

    //update storage product
    public function updateUsageProduct(ProductStorageRequest $request, $id){
           $resp = $this->prdusage->updateUsageProduct($request, $id); 
           return redirect()->back()->with('msg', $resp);
    }

    //update product
    public function updateProduct(ProductRequest $request){
           $resp = $this->product->UpdateProduct($request); 
           return redirect()->back()->with('msg', $resp);
    }

    
    //delete product
    public function deleteUsageProduct($prdid){
           $resp = $this->prdusage->DeleteProduct($prdid); 
           return redirect()->back()->with('msg', $resp);
    }

//delete product
    public function deleteProduct($prdid){
           $resp = $this->product->DeleteProduct($prdid); 
           return redirect()->back()->with('msg', $resp);
    }

    //check product price
    public function checkProductPrice(Request $request){
            $productPrice  = $request->prdprice;
            $productId = $request->productId;
            $getPrdPrice = DB::table('prd_master')
            ->where('prd_id', $productId)
            ->orderBy('pk_no', 'DESC')
            ->first();
            if ($getPrdPrice == null) {
                $data['status'] = 'fentry';
                return response()->json($data);
            }else{
                if ($productPrice != $getPrdPrice->prd_qty_price) {
                $data['price']  = $getPrdPrice->prd_qty_price;
                $data['status'] = 'error';
                return response()->json($data);
                }else{
                    $data['status'] = 'success';
                    return response()->json($data);
                }
            }
            

    }
}
