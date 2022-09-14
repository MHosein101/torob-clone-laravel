<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::post('login', [AuthController::class,'login']);
Route::post('verify', [AuthController::class,'verification']);
Route::post('cancel', [AuthController::class,'cancel']);
Route::get('restricted', [AuthController::class,'restricted']);

Route::get('check', [AuthController::class,'checkCookie']);

Route::group([ 'middleware' => ['auth:api'] ], function () {

    Route::get('user/analytics', [UserController::class,'getAnalytics']);
    Route::get('user/favorites', [UserController::class,'getFavorites']);

    Route::get('user/history', [UserController::class,'getHistory']);
    Route::delete('user/history', [UserController::class,'clearHistory']);

    Route::post('logout', [AuthController::class, 'logout']);

    Route::group( ['middleware' => ['product'] ], function () {

        Route::post('user/{hash}/analytics', [UserController::class,'createAnalytic']);
        Route::delete('user/{hash}/analytics', [UserController::class,'deleteAnalytic']);
        
        Route::post('user/{hash}/favorites', [UserController::class,'createFavorite']);
        Route::delete('user/{hash}/favorites', [UserController::class,'deleteFavorite']);
        
        Route::post('user/{hash}/history', [UserController::class,'createHistory']);

    });
    
});


Route::get('categories', [CategoryController::class,'getAll']);

Route::group( ['middleware' => ['category'] ], function () {

    Route::get('categories/{name}/sub' ,[CategoryController::class,'getSubCategories']);
    Route::get('categories/{name}/brands' ,[CategoryController::class,'getBrands']);
    Route::get('categories/{name}/path' ,[CategoryController::class,'getPath']);

});

Route::get('search/{text}/suggestion' ,[SearchController::class,'suggestion']);
Route::get('search' ,[SearchController::class,'search']);

Route::group( ['middleware' => ['product'] ], function () {

    Route::get('product/{hash}' ,[ProductController::class,'showDetail']);
    Route::get('product/{hash}/sales' ,[ProductController::class,'getShopsOffers']);
    Route::get('product/{hash}/similars' ,[ProductController::class,'getSimilarProducts']);

});