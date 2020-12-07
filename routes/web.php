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

Route::group(['prefix' => '/'], function () {
    Route::get('', 'UserProductController@index');//使用者頁面
    Route::get('/sort/{sort}', 'UserProductController@index');
    Route::get('/product/{id}', 'UserProductController@thisProduct');//使用者頁面
});

Route::group(['prefix' => 'cart'], function () {//購物車群組
    Route::get('/', 'CartController@index');//購物車頁面
    Route::get('/addToCart/{id}', 'CartController@getAddToCart');//加入購物車
    Route::get('/increaseOneProduct/{id}', 'CartController@increaseByOne');//新增商品數量
    Route::get('/decreaseOneProduct/{id}', 'CartController@decreaseByOne');//減少商品數量
    Route::get('/removeProduct/{id}', 'CartController@removeProduct');//移除商品
    Route::get('/clearCart', 'CartController@clearCart');//清出購物車
    Route::get('/checkout', 'CartController@checkoutview');//購物車結帳畫面
    Route::post('/checkout', 'CartController@checkoutProcess');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminProductController@index');
    Route::get('/product/{id}', 'AdminProductController@show');
    Route::post('/product', 'AdminProductController@store');
    Route::put('/product/{id}', 'AdminProductController@update');
});
