<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;


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

Route::get('search/{text}/suggestion',[SearchController::class,'suggestion']);

// Route::get('search/{text}',[SearchController::class,'search']);

// Route::get('search/{term?}/{sort?}/{available?}/{priceMin?}/{priceMax?}',[SearchController::class,'search']);
    // ->whereIn('sort', ['newest', 'cheap', 'expensive', 'favorite'])
    // ->whereIn('available', ['yes', 'no'])
    // ->whereNumber('priceMin')
    // ->whereNumber('priceMax');