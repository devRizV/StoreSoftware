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
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductStorageRequest;
use App\Exports\ProductsExport;
use App\Exports\LiveStockExport;
use App\Http\Requests\MultiProductRequest;
use App\Http\Requests\MultiProductStorageRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\UsageProductUpdateRequest;
use App\Models\ProductNameModel;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $product;
    protected $supplier;
    protected $prdusage;
    protected $getProductList;
    public function __construct(ProductModel $product, ProductUsageModel $prdusage, OrderModel $getProductList, SupplierModel $supplier)
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
    public function getPaginatedList(Request $request)
    {
        $data = $this->getProductList->fetchData($request);
        if ($request->download_excel == 1) {
            return \Excel::download(new OrderExport($data), date('d-m-Y') . '_purchase_order.xlsx');
        }

        $query = $data['products'];
        
        // Initialize variables for server-side DataTables processing
        $start = $request->input('start', 0); // Starting point for pagination
        $length = $request->input('length', 10); // Number of records per page
        $search = $request->input('search.value'); // Search query from DataTables
        $orderColumn = $request->input('order.0.column'); // Column index for ordering
        $orderDirection = $request->input('order.0.dir', 'desc'); // Sorting direction

        $columnName = $this->getColumnNameForOrderingPurchaseProducts($orderColumn);

        // Sorting the collection dynamically
        $query = $query->sortBy(function ($product) use ($columnName) {
            return data_get($product, $columnName); // Get nested or dot-notated properties
        });

        if ($orderDirection == 'desc') {
            $query = $query->reverse();
        }

        // Get total records
        $totalRecords = $query->count();
        $filteredQuery = clone $query;
        $recordsFiltered = $filteredQuery->count();

        // Calculate the total price of all the products
        $totalPriceSum = $query->sum('prd_price');
        // // Apply search term if exists
        if (!empty($search)) {
             $query = $query->filter(function($item) use ($search) {
                return Str::contains(strtolower($item->prd_name), strtolower($search)) ||
                Str::contains(strtolower($item->prd_unit), strtolower($search)) ||
                Str::contains(strtolower($item->prd_req_dep), strtolower($search)) ||
                Str::contains(strtolower($item->prd_qty), strtolower($search));
            });
        }

        $products = $query->slice($start, $length)->values();

        // Calculate the total price sum of the loaded pages
        $loadedTotalPriceSum = $products->sum('prd_price');

        // Return the results in suitable format for DataTables
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $products,
            'totalPriceSum' => $totalPriceSum,
            'loadedTotalPriceSum' => $loadedTotalPriceSum,
        ]);
    }
    //get usage product list
    public function getUsageProductList(Request $request)
    {
        $data = $this->getProductList->fetchUsagePrdDate($request);
        if ($request->download_excel == 1) {
            return \Excel::download(new UsageOrderExport($data), date('d-m-Y') . '_usage_order.xlsx');
        }
        $data['department'] = DepartmentModel::all();
        return view('pages.product.product-usage-list', compact('data'));
    }
    // Export as excel or csv
    public function export(Request $request)
    {
        $format = $request->get('format');

        if ($format === 'excel') {
            return Excel::download(new ProductsExport, 'products.xlsx');
        } elseif ($format === 'csv') {
            return Excel::download(new ProductsExport, 'products.csv');
        }

        // Handle unsupported formats or invalid requests
        abort(400, 'Invalid format or request');
    }
    //get store product
    public function getStoreProduct()
    {
        $data['supplier'] = SupplierModel::all();
        // dd($data['supplier']);
        $data['department'] = DepartmentModel::all();
        $data['productsname'] = DB::table('prd_name')->orderBy('pk_no', 'DESC')->get();
        return view('pages.product.index', compact('data'));
    }
    //get store product
    public function getMultiStoreProduct()
    {
        $data['supplier'] = SupplierModel::all();
        // dd($data['supplier']);
        $data['department'] = DepartmentModel::all();
        $data['productsname'] = DB::table('prd_name')->orderBy('pk_no', 'DESC')->get();
        return view('pages.product.store-multi-product', compact('data'));
    }

    //get usage product
    public function getUsageProduct()
    {
        $data['productsname'] = DB::table('prd_stock as S')
            ->leftJoin('prd_name as N', 'N.pk_no', '=', 'S.prd_id')
            ->select('N.prd_name', 'N.pk_no')
            ->orderBy('N.pk_no', 'DESC')
            ->get();
        $data['department'] = DepartmentModel::all();
        return view('pages.product.usage-multi-product', compact('data'));
    }
    public function getMultiUsageProduct()
    {
        $data['productsname'] = DB::table('prd_stock as S')
            ->leftJoin('prd_name as N', 'N.pk_no', '=', 'S.prd_id')
            ->select('N.prd_name', 'N.pk_no')
            ->orderBy('N.pk_no', 'DESC')
            ->get();
        $data['department'] = DepartmentModel::all();
        return view('pages.product.usage-multi-product', compact('data'));
    }
    //get product unit
    public function getProductUnit(Request $request)
    {
        $prdNameId = $request->nameid;
        $productUnit = DB::table('prd_name')->where('pk_no', $prdNameId)->first();
        return response()->json([
            "unit" => $productUnit->prd_unit,
        ]);
    }
    //get edit product 
    public function getEditProduct(Request $request, $prdId)
    {
        
        $product = DB::table('prd_master')->where('pk_no', $prdId)->first();
        $departments = DepartmentModel::all();
        $suppliers = SupplierModel::all();
        $productNames = ProductNameModel::all();

        $data = [
                'product' => $product,
                'department' => $departments,
                'supplier' => $suppliers,
                'prdnames' => $productNames
            ];

        if ($request->ajax()) {
            $editPage = view('pages.product.edit-product', compact('data'))->render();
            return response()->json([
                "html" => $editPage,
                'data' => $data,
                "message" => "THis is message",
            ]);
        }

        return view('pages.product.edit-product', compact('data'));
    }
    //get edit usage product
    public function getEditUsageProduct($prdId)
    {
        $data['products'] = DB::table('prd_usage')->where('pk_no', $prdId)->first();
        $data['department'] = DepartmentModel::all();
        $data['prdnames'] = DB::table('prd_stock as S')
            ->leftJoin('prd_name as N', 'N.pk_no', '=', 'S.prd_id')
            ->select('N.prd_name', 'N.pk_no')
            ->orderBy('N.pk_no', 'DESC')
            ->get();
        return view('pages.product.edit-usage-product', compact('data'));
    }
    //get product unit and price for usage page
    public function getUsageProductUnit(Request $request)
    {
        $prdNameId = $request->nameid;

        $productdata = DB::table('prd_master')
            ->where('prd_id', $prdNameId)
            ->orderBy('pk_no', 'DESC')
            ->first();
        $stock = DB::table('prd_stock')
            ->where('prd_id', $prdNameId)
            ->get('prd_qty')
            ->first();

        $data['name'] = $productdata->prd_name;
        $data['unit']  = $productdata->prd_unit;
        $data['qtyprice']  = $productdata->prd_qty_price;
        $data['dep']  = $productdata->prd_req_dep;
        $data['stock'] = $stock;
        $data['status'] = 'over';

        return response()->json($data);
    }
    
    //get product unit
    public function getProductUnitAndPrice(Request $request)
    {
        $prdNameId = $request->nameid;
        $productUnit = DB::table('prd_name')->where('pk_no', $prdNameId)->first();
        $data['productUnit'] = DB::table('prd_name as N')
            ->leftJoin('prd_master as M', 'M.prd_id', '=', 'N.pk_no')
            ->select('N.prd_unit', 'M.prd_qty_price')
            ->first();
        return $data;
    }
    //get product unit
    public function getProductQty(Request $request)
    {
        $prdNameId = $request->nameid;
        $quantity = $request->quantity;
        $productUnit = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
        if ($quantity > $productUnit->prd_qty) {
            $data['qty']  = $productUnit->prd_qty;
            $data['status'] = 'over';
            return response()->json($data);
        } else {
            $data['qty']  = $productUnit->prd_qty;
            $data['status'] = 'success';
            return response()->json($data);
        }
    }
    //get product qty
    public function updateProductQty(Request $request)
    {
        $prdNameId = $request->nameid;
        $quantity = $request->quantity;
        $productStockUnit = DB::table('prd_stock')->where('prd_id', $prdNameId)->first();
        $productUsageUnit = DB::table('prd_usage')->where('prd_name_id', $prdNameId)->first();
        $TotalQuantity = $productStockUnit->prd_qty + $productUsageUnit->prd_qty;
        if ($quantity > $TotalQuantity) {
            $data['qty']  = $TotalQuantity;
            $data['status'] = 'over';
            return response()->json($data);
        } else {
            echo "success";
        }
    }
    //update storage product
    public function updateUsageProduct(UsageProductUpdateRequest $request, $id)
    {
        $resp = $this->prdusage->updateUsageProduct($request, $id);
        return redirect()->back()->with('msg', $resp);
    }
    //update product
    public function updateProduct(ProductUpdateRequest $request)
    {
        $resp = $this->product->UpdateProduct($request);
        $message = $resp['msg'];
        $data = DB::table('prd_name')
            ->where('pk_no', $resp['data']['prd_id'])
            ->value('prd_name');
        
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'msg'    => $message,
                'data'   => $data,
            ]);
        }
        return redirect()->back()->with('msg', $resp);
    }
    public function getAllProduct(Request $request)
    {
        $data['department'] = DepartmentModel::all();
        $data['supplier'] = SupplierModel::all();

        return view('pages.product.product-list', compact('data'));
    }

    // get purchase product list for in data table format
    public function getPurchaseProductList(Request $request)
    {
        // Initialize variables for server-side DataTables processing
        $start = $request->input('start', 0); // Starting point for pagination
        $length = $request->input('length', 10); // Number of records per page
        $search = $request->input('search.value'); // Search query from DataTables
        $orderColumn = $request->input('order.0.column'); // Column index for ordering
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction

        $query = DB::table('prd_master')
        ->join('prd_stock', 'prd_stock.prd_id', '=', 'prd_master.prd_id')
        ->select(
            DB::raw("ROW_NUMBER() OVER(ORDER BY prd_master.created_at DESC) as sl"), // Fixed SL based on latest product purchase
            'prd_master.*',
            'prd_stock.prd_qty as stock')
        ->orderBy($this->getColumnNameForOrderingPurchaseProducts($orderColumn), $orderDirection); // Dynamic sorting for all columns

        // get total records
        $totalRecords = $query->count();
        $filteredQuery = clone $query;
        $recordsFiltered = $filteredQuery->count();
        // Calculate the total price sum of all products
        $totalPriceSum = $query->sum('prd_price');
        // Apply search term if exists
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('prd_master.prd_name', 'like', "%{$search}%")
                ->orWhere('prd_master.prd_req_dep', 'like', "%{$search}%")
                ->orWhere('prd_master.prd_qty', 'like', "%{$search}%")
                ->orWhere('prd_master.prd_unit', 'like', "%{$search}%");
            });
        }
        // Apply Pagination
        $products = $query->offset($start)->limit($length)->get();


        // calculate the total price sum of the loaded page's products
        $loadedTotalPriceSum = $products->sum('prd_price');

        // Return the results in suitable format for DataTables
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $products,
            'totalPriceSum' => $totalPriceSum,
            'loadedTotalPriceSum' => $loadedTotalPriceSum,
        ]);
    }

    // Helper function to map all the column indexes to actual column names
    private function getColumnNameForOrderingPurchaseProducts($columnIndex)
    {
        // Array of column names corresponding to DataTables column indexes
        $columns = [
            'prd_master.pk_no',
            'prd_master.prd_name',
            'prd_master.prd_req_dep',
            'prd_master.prd_qty',
            'prd_master.prd_unit',
            'prd_master.prd_qty_price',
            'prd_master.prd_price',
            'prd_master.prd_grand_price',
            'prd_master.prd_purchase_date',
            'prd_master.created_at',
            'prd_stock.prd_qty',
        ];

        // Return column name based on the passed index
        return isset($columns[$columnIndex]) ? $columns[$columnIndex] : 'prd_master.pk_no';
    }

    //get get All Usage Product
    public function getAllUsageProduct()
    {
        $data['products'] = DB::table('prd_usage')
                ->join('prd_stock', 'prd_stock.prd_id', '=', 'prd_usage.prd_name_id')
                ->select(
                    'prd_usage.*',
                    'prd_stock.prd_qty as stock')
                ->orderBy('pk_no', 'DESC')->get();
        $data['sum'] = $data['products']->sum('prd_price');
        $data['department'] = DepartmentModel::all();
        return view('pages.product.product-usage-list', compact('data'));
    }

    // Get usage product list in DataTable format
    public function getUsageProducts(Request $request)
    {
        // Initialize variables for server-side DataTables processing
        $start = $request->input('start', 0); // Starting point for pagination
        $length = $request->input('length', 10); // Number of records per page
        $search = $request->input('search.value'); // Search query from DataTables
        $orderColumn = $request->input('order.0.column'); // Column index for ordering
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction

        $query =DB::table('prd_usage')
                    ->join('prd_stock', 'prd_stock.prd_id', '=', 'prd_usage.prd_name_id')
                    ->select(
                        DB::raw("ROW_NUMBER() OVER(ORDER BY prd_usage.created_at DESC) as sl"), // Fixed SL based on Latest product usage
                        'prd_usage.*',
                        'prd_stock.prd_qty as stock')
                    ->orderBy($this->getColumnNameForOrderingUsageProducts($orderColumn), $orderDirection);
                
        // get total records 
        $totalRecords = $query->count();
        $filteredQuery = clone $query;
        $recordsFiltered = $filteredQuery->count();
        // Calculate the total price sum of all products
        $totalPriceSum = $query->sum('prd_price');
        // Apply search term if exists
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('prd_usage.prd_name', 'like', "%{$search}%")
                ->orWhere('prd_usage.dept', 'like', "%{$search}%")
                ->orWhere('prd_usage.prd_qty', 'like', "%{$search}%")
                ->orWhere('prd_usage.prd_unit', 'like', "%{$search}%");
            });
        }
        // Apply pagination
        $products = $query->offset($start)->limit($length)->get();

        // Calculate the total price sum of the loaded page's products
        $loadedTotalPriceSum = $products->sum('prd_price');

        // Return the results in suitable format for DataTable
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $products,
            'totalPriceSum' => $totalPriceSum,
            'loadedTotalPriceSum' => $loadedTotalPriceSum,
        ]);
    }

    // Helper function to map all the column indexes to actual column names
    private function getColumnNameForOrderingUsageProducts($columnIndex) {
        // Array of column names corresponding to DataTables column indexes
        $columns = [
            'prd_usage.pk_no',
            'prd_usage.prd_name',
            'prd_usage.dept',
            'prd_usage.prd_qty',
            'prd_usage.prd_unit',
            'prd_usage.prd_qty_price',
            'prd_usage.prd_grand_price',
            'prd_usage.takendate',
            'prd_usage.created_at',
            'prd_stock.prd_qty',
        ];

        return $columns;
    }

    //get live stock
    public function getLiveStock()
    {
        $data['products'] = DB::table('prd_stock')
            ->join('prd_name', 'prd_name.pk_no', '=', 'prd_stock.prd_id')
            ->get();
        return view('pages.product.live-stock', compact('data'));
    }
    

    //export liveStock
    public function exportLiveStock()
    {
        return Excel::download(new LiveStockExport, 'livestock.xlsx');
    }

    // View product
    public function viewProduct(Request $request, $prdId)
    {
        $data['products'] = DB::table('prd_master')->where('pk_no', $prdId)->first();
        $data['prdnames'] = DB::table('prd_name')->get();

        if ($request->ajax()) {
            return view('pages.product.view-product', compact('data'))->render();
        }

        return view('pages.product.view-product', compact('data'));
    }

    //store product
    public function storeProduct(ProductRequest $request)
    {
        foreach ($request->name as $product => $value) {
            $prdinfo = [
                'name'              => $request->name[$product],
                'brand'             => $request->brand[$product] ?? '',
                'quantity'          => $request->quantity[$product],
                'unit'              => $request->unit[$product],
                'quantityprice'     => $request->quantityprice[$product],
                'totalprice'        => $request->totalprice[$product],
                'purchasefrom'      => $request->purchasefrom ?? '',
                'purchasedate'      => $request->purchasedate,
                'reqdept'           => $request->reqdept,
                'supplier'          => $request->supplier,
                'expirydate'        => $request->expirydate ?? '',
                'expiryalert'       => $request->expiryalert ?? '',
                'remarks'           => $request->remarks ?? '',
            ];

            $resp = $this->product->StoreProduct($prdinfo);
        }

        // Optionally handle responses and provide more detail if needed
        return redirect()->back()->with('msg', $resp);
    }

    //store Storage Product
    public function storeStorageProduct(ProductStorageRequest $request)
    {
        foreach ($request->name as $product => $value) {
            $prdinfo = [
                'name'              => $request->name[$product],
                'quantity'          => $request->quantity[$product],
                'unit'              => $request->unit[$product],
                'quantityprice'     => $request->quantityprice[$product],
                'totalprice'        => $request->totalprice[$product],
                'takendate'         => $request->takendate,
                'reqdept'           => $request->reqdept,
                'takenby'           => $request->takenby,
                'remarks'           => $request->remarks ?? '',
            ];

            $resp = $this->prdusage->StoreUsagesProduct($prdinfo);
        }
        return redirect()->back()->with('msg', $resp);
    }
    // Store multiple purchase product
    public function storeMultiProduct(MultiProductRequest $request)
    {
        foreach ($request->name as $product => $value) {
            $prdinfo = [
                'name'              => $request->name[$product],
                'brand'             => $request->brand[$product] ?? '',
                'quantity'          => $request->quantity[$product],
                'unit'              => $request->unit[$product],
                'quantityprice'     => $request->quantityprice[$product],
                'totalprice'        => $request->totalprice[$product],
                'purchasefrom'      => $request->purchasefrom ?? '',
                'purchasedate'      => $request->purchasedate,
                'reqdept'           => $request->reqdept,
                'supplier'          => $request->supplier,
                'expirydate'        => $request->expirydate ?? '',
                'expiryalert'       => $request->expiryalert ?? '',
                'remarks'           => $request->remarks ?? '',
            ];

            $resp = $this->product->StoreProduct($prdinfo);
        }

        return response()->json([
            'msg' => $resp,
        ], 200);
    }

    //store Storage Product
    public function storeMultiStorageProduct(MultiProductStorageRequest $request)
    {
        foreach ($request->name as $product => $value) {
            $prdinfo = [
                'name'              => $request->name[$product],
                'quantity'          => $request->quantity[$product],
                'unit'              => $request->unit[$product],
                'quantityprice'     => $request->quantityprice[$product],
                'totalprice'        => $request->totalprice[$product],
                'takendate'         => $request->takendate,
                'reqdept'           => $request->reqdept,
                'takenby'           => $request->takenby,
                'remarks'           => $request->remarks ?? '',
            ];

            $resp = $this->prdusage->StoreUsagesProduct($prdinfo);
        }
        return response()->json([
            'msg' => $resp,
        ], 200);
    }
    //delete usage product
    public function deleteUsageProduct($prdid)
    {
        $resp = $this->prdusage->DeleteProduct($prdid);
        return redirect()->back()->with('msg', $resp);
    }
    //delete product
    public function deleteProduct($prdid)
    {
        $resp = $this->product->DeleteProduct($prdid);
        // return redirect()->back()->with('msg', $resp);
        return response()->json(['msg'=> $resp], 200);
    }
    //check product price
    public function checkProductPrice(Request $request)
    {
        $productPrice  = $request->prdprice;
        $productId = $request->productId;
        $getPrdPrice = DB::table('prd_master')
            ->where('prd_id', $productId)
            ->orderBy('pk_no', 'DESC')
            ->first();
        if ($getPrdPrice == null) {
            $data['status'] = 'fentry';
            $data['message'] = 'First entry!!!';
            return response()->json($data);
        } else {
            if ($productPrice != $getPrdPrice->prd_qty_price) {
                $data['price']  = $getPrdPrice->prd_qty_price;
                $data['status'] = 'error';
                $data['message'] = 'The previous price was -' . $data['price'];
                return response()->json($data);
            } else {
                $data['status'] = 'success';
                $data['message'] = 'The prices are the same.';
                return response()->json($data);
            }
        }
    }
}
 