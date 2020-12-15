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
Route::get('test', function () {
    dd(Auth::guard('web'));
});

Route::group(['prefix' => '/'], function () {
    Route::get('', 'UserProductController@index');//使用者全部商品頁面
    Route::get('/sort/{sort}', 'UserProductController@index');//商品分類頁面
    Route::get('/product/{id}', 'UserProductController@thisProduct');//商品詳細資訊頁面
    Route::get('order', 'UserProductController@orderView');//商品詳細資訊頁面
    Route::get('login', 'authController@loginView')->name('login');//登入頁面
    Route::post('login', 'authController@login');//登入資料送出
    Route::get('logout', 'authController@logout');//登出帳號
    Route::get('register', 'authController@registerView');//註冊頁面
    Route::post('register', 'authController@register');//註冊資料送出
});

Route::group(['prefix' => 'cart'], function () {//購物車群組
    Route::get('/', 'CartController@index');//購物車頁面
    Route::get('/addToCart/{id}', 'CartController@getAddToCart');//加入購物車
    Route::get('/goToCart/{id}', 'CartController@goToCart');//加入購物車
    Route::get('/increaseOneProduct/{id}', 'CartController@increaseByOne');//新增商品數量
    Route::get('/decreaseOneProduct/{id}', 'CartController@decreaseByOne');//減少商品數量
    Route::get('/removeProduct/{id}', 'CartController@removeProduct');//移除商品
    Route::get('/checkout', 'CartController@checkoutview');//購物車結帳畫面
    Route::post('/checkout', 'CartController@checkout');
    Route::get('/success', 'CartController@checkoutEnd');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('', 'AdminProductController@index');
    Route::get('/product/{id}', 'AdminProductController@show');
    Route::post('/product', 'AdminProductController@store');
    Route::put('/product/{id}', 'AdminProductController@update');
    Route::get('order', 'AdminOrderController@index');//商品詳細資訊頁面
    Route::get('/order/update', 'AdminOrderController@orderUpdate');//商品詳細資訊頁面
});
