<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/register', [UserController::class, 'Register']);
Route::post('/user/login', [UserController::class, 'Login']);
Route::post('/user/token', [UserController::class, 'VerifyToken']);
Route::post('/product/add', [ProductController::class, 'AddProduct']);
Route::post('/store/register', [StoreController::class, 'RegisterStore']);
Route::post('/stock/add', [StockController::class, 'Add']);
