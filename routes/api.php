<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
  'prefix' => 'v1', 
  'as' => 'api.', 
  'namespace' => 'api/v1', 
], function () {
   Route::post('user/register', [UserController::class,'register']); 
   Route::post('user/login', [UserController::class,'login']); 
});

Route::group([
  'prefix' => 'v1', 
  'as' => 'api.', 
  'namespace' => 'api/v1', 
  'middleware' => ['auth:api']
], function () {
    Route::post('user/logout', [UserController::class,'logout']);
    Route::post('master/category', [CategoryController::class,'create']);
    Route::put('master/category/{id}', [CategoryController::class,'edit']);
    Route::delete('master/category', [CategoryController::class,'delete']);
    Route::get('master/category', [CategoryController::class,'get_category']);
    Route::get('master/category/{id}', [CategoryController::class,'get_category_detail']);

    Route::post('master/product', [ProductController::class,'create']);
    Route::put('master/product/{id}', [ProductController::class,'edit']);
    Route::delete('master/product', [ProductController::class,'delete']);
    Route::get('master/product', [ProductController::class,'get_product']);
    Route::get('master/product/{id}', [ProductController::class,'get_product_detail']);
});
