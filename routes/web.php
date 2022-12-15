<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/store', function () {
    return view('store');
});
Route::get('/store/{id}', function ($id) {
    return view('store');
});
Route::get('/product/{id}', function ($id) {
    return view('product');
});
require 'api.php';