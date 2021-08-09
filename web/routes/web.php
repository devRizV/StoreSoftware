<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/cc', function() {
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
    \Artisan::call('config:cache');
    return 'DONE'; 
});


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//user routes
Route::get('/register-user', 'UserController@CreateUser')->name('register-user');
Route::get('/user-list', 'UserController@getUserList')->name('user-list');
Route::get('/edit-user/{id}', 'UserController@geteditUser')->name('edit-user');
Route::get('/delete-user/{id}', 'UserController@deleteUser')->name('delete-user');
Route::post('/store-user', 'UserController@create')->name('store-user');
Route::post('/update-user', 'UserController@updateUser')->name('update-user');


//product routes
Route::get('/product-store', 'ProductController@getStoreProduct')->name('product-store');
Route::get('/usage-product', 'ProductController@getUsageProduct')->name('usage-product');
Route::post('/save-product', 'ProductController@storeProduct')->name('save-product');
Route::post('/save-storage-product', 'ProductController@storeStorageProduct')->name('save-storage-product');
Route::post('/update-product', 'ProductController@updateProduct')->name('update-product');
Route::get('/update-usage-product/{id}', 'ProductController@updateUsageProduct')->name('update-usage-product');
Route::get('/delete-product/{id}', 'ProductController@deleteProduct')->name('delete-product');
Route::get('/delete-usage-product/{id}', 'ProductController@deleteUsageProduct')->name('delete-usage-product');
Route::get('/view-product/{id}', 'ProductController@viewProduct')->name('view-product');
Route::get('/all-product', 'ProductController@getAllProduct')->name('all-product');
Route::get('/order-list', 'ProductController@getPaginatedList')->name('order.list');
Route::get('/usage.order.list', 'ProductController@getUsageProductList')->name('usage.order.list');
Route::get('/all-usage-product', 'ProductController@getAllUsageProduct')->name('all-usage-product');
Route::get('/get-product-unit', 'ProductController@getProductUnit')->name('get-product-unit');
Route::get('/get-product-usage-unit', 'ProductController@getUsageProductUnit')->name('get-product-usage-unit');
Route::get('/get-product-unit-price', 'ProductController@getProductUnitAndPrice')->name('get-product-unit-price');
Route::get('/get-product-qty', 'ProductController@getProductQty')->name('get-product-qty');
Route::get('/update-product-qty', 'ProductController@updateProductQty')->name('update-product-qty');
Route::get('/live-stock', 'ProductController@getLiveStock')->name('live-store');
Route::get('/edit-product/{id}', 'ProductController@getEditProduct')->name('edit-product');
Route::get('/edit-usage-product/{id}', 'ProductController@getEditUsageProduct')->name('edit-usage-product');
Route::get('get-product-price/', 'ProductController@checkProductPrice')->name('get-product-price');

//product name
Route::get('/save-product-name', 'ProductNameController@getAddProductName')->name('save-product-name');
Route::post('/store-product', 'ProductNameController@saveProductName')->name('store-product');
Route::get('/product-name-list', 'ProductNameController@getAllProductName')->name('product-name-list');
Route::get('/edit-product-name/{id}', 'ProductNameController@geteditProductName')->name('edit-product-name');
Route::post('/update-product-name', 'ProductNameController@updateProductName')->name('update-product-name');
Route::get('/delete-product-name/{id}', 'ProductNameController@deleteProductName')->name('delete-product-name');





//department routes
Route::get('/department-store', 'DepartmentController@getstoreDepartment')->name('department-store');
Route::post('/save-department', 'DepartmentController@storeDepartment')->name('save-department');
Route::get('/all-department', 'DepartmentController@getAllDepartment')->name('all-department');
Route::get('/edit-department/{id}', 'DepartmentController@geteditDepartment')->name('edit-department');
Route::post('/update-department', 'DepartmentController@updateDepartment')->name('update-department');
Route::get('/delete-department/{id}', 'DepartmentController@deleteDepartment')->name('delete-department');

//supplier routes
Route::get('/supplier-store', 'SupplierController@getstoreSupplier')->name('supplier-store');
Route::post('/save-supplier', 'SupplierController@storeSupplier')->name('save-supplier');
Route::get('/all-supplier', 'SupplierController@getAllSupplier')->name('all-supplier');
Route::get('/edit-supplier/{id}', 'SupplierController@geteditSupplier')->name('edit-supplier');
Route::post('/update-supplier', 'SupplierController@updateSupplier')->name('update-supplier');
Route::get('/delete-supplier/{id}', 'SupplierController@deleteSupplier')->name('delete-supplier');