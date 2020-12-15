<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class UserProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthorityUser');
    }
    public function index($sort=null)
    {
        $title="";
        if ($sort=="farmer") {
            $product_paginate = Product::where('sort', 0)->orderBy('created_at', 'asc')->Paginate(5);
            $title="小農產品";
        } elseif ($sort=="bread") {
            $product_paginate = Product::where('sort', 1)->orderBy('created_at', 'asc')->Paginate(5);
            $title="手工麵包";
        } else {
            $product_paginate = Product::orderBy('created_at', 'asc')->Paginate(5);
            $title="首頁";
        }
        $binding = [
            'title' => $title,
            'products' => $product_paginate,
        ];
        return view('user.index', $binding);
    }
    public function thisProduct($id)
    {
        $product = Product::where('id', $id)->first();
        if ($product!==null) {
            $binding = [
                'title' => $product->title,
                'product' => $product,
            ];
            return view('user.product', $binding);
        } else {
            return response('404 Not Found', 404);
        }
    }
    public function orderView()
    {
        $orders = Order::where('uid', 1)->orderBy('created_at', 'asc')->get();
        foreach ($orders as $order) {
            if ($order->paid==0) {
                $order->paid="貨到付款";
            } elseif ($order->pid==1) {
                $order->paid="LINE PAY";
            } elseif ($order->pid==2) {
                $order->paid="綠界付款";
            }
            if ($order->transport==0) {
                $order->transport="待出貨";
            } else {
                $order->transport="已出貨";
            }
        }
        // return dd($orders);
        if ($orders!==null) {
            $binding = [
                'title' => '我的訂單',
                'orders' => $orders,
            ];
            return view('user.order', $binding);
        } else {
            return response('404 Not Found', 404);
        }
    }
}
