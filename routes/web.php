<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;

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

Route::get('/login', [AuthController::class,'index'])->name('login');
Route::post('/login', [AuthController::class,'postLogin']);

Route::get('/logout', [AuthController::class,'logout']);

Route::group(['middleware' => 'auth'], function(){
    
    Route::get('/', [WelcomeController::class,'index']);
    
    Route::resource('/seting/user', 'UsersController');
    Route::resource('/seting/product', 'ProductsController');
    Route::resource('/transaction/sales', 'SalesController');

    Route::get('/transaction/sales/search-product/{search}', 'SalesController@searchProduct');
    Route::get('/transaction/report/sales-by-date', 'SalesReportController@index');
    Route::get('/product/barcode', 'ProductsController@generateBarcode');
    
    Route::get('/logout', [AuthController::class,'logout']);
});
