<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;

// Route::post('login',[AuthController::class,'login']);

// Route::post('verify',[AuthController::class,'verification']);
// Route::post('cancel',[AuthController::class,'cancel']);

// Route::group(['middleware' => ['auth:api']], function () {

//     Route::post('logout', [AuthController::class, 'logout']);

// });


Route::get('categories',[CategoryController::class,'getAll']);

Route::group(['middleware' => ['category']], function () {

    Route::get('categories/{name}/sub',[CategoryController::class,'getSubCategories']);
    Route::get('categories/{name}/brands',[CategoryController::class,'getBrands']);
    Route::get('categories/{name}/path',[CategoryController::class,'getPath']);

});

Route::get('search/{text}/suggestion',[SearchController::class,'suggestion']);
Route::get('search',[SearchController::class,'search']);

Route::group(['middleware' => ['product']], function () {

    Route::get('product/{hash}',[ProductController::class,'showDetail']);
    Route::get('product/{hash}/sales',[ProductController::class,'getShopsOffers']);
    Route::get('product/{hash}/similars',[ProductController::class,'getSimilarProducts']);

});