<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login',[AuthController::class,'login']);

Route::post('verify',[AuthController::class,'verification']);
Route::post('cancel',[AuthController::class,'cancel']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::get('categories',[CategoryController::class,'getAll']);
Route::get('categories/{name}/sub',[CategoryController::class,'getSubCategories'])->middleware('category');
Route::get('categories/{name}/brands',[CategoryController::class,'getBrands'])->middleware('category');
Route::get('categories/{name}/path',[CategoryController::class,'getPath'])->middleware('category');

Route::get('search/{text}/suggestion',[SearchController::class,'suggestion']);
Route::get('search',[SearchController::class,'search']);

// Route::get('product/{name}',[ProductController::class,'showDetail']);