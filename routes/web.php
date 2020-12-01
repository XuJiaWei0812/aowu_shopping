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
    return view('user/index');
});
Route::get('/farmer', function () {
    return view('user/farmer');
});
Route::get('/bread', function () {
    return view('user/bread');
});
Route::get('/product', function () {
    return view('user/product');
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'ProductController@index');
    Route::get('/product/{id}', 'ProductController@show');
    Route::post('/product', 'ProductController@store');
    Route::put('/product/{id}', 'ProductController@update');
});
