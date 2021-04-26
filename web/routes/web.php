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

//registration routes
Route::get('/register-user', 'ProductController@CreateUser')->name('register-user');

//product routes
Route::get('/product-store', 'ProductController@getStoreProduct')->name('product-store');
Route::get('/usage-product', 'ProductController@getUsageProduct')->name('usage-product');
Route::post('/save-product', 'ProductController@storeProduct')->name('save-product');
Route::post('/save-storage-product', 'ProductController@storeStorageProduct')->name('save-storage-product');
Route::post('/update-product', 'ProductController@updateProduct')->name('update-product');
Route::get('/delete-product/{id}', 'ProductController@deleteProduct')->name('delete-product');
Route::get('/view-product/{id}', 'ProductController@viewProduct')->name('view-product');
Route::get('/all-product', 'ProductController@getAllProduct')->name('all-product');
Route::get('/all-usage-product', 'ProductController@getAllUsageProduct')->name('all-usage-product');
Route::get('/get-product-unit', 'ProductController@getProductUnit')->name('get-product-unit');
Route::get('/get-product-qty', 'ProductController@getProductQty')->name('get-product-qty');
Route::get('/live-stock', 'ProductController@getLiveStock')->name('live-stock');
Route::get('/edit-product/{id}', 'ProductController@getEditProduct')->name('edit-product');
Route::get('/edit-usage-product/{id}', 'ProductController@getEditUsageProduct')->name('edit-usage-product');

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