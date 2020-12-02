<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserProductController extends Controller
{
    public function index($sort=null)
    {
        if ($sort=="farmer") {
            $product_paginate = Product::where('sort',0)->orderBy('created_at', 'asc')->Paginate(5);
        } elseif ($sort=="bread") {
            $product_paginate = Product::where('sort',1)->orderBy('created_at', 'asc')->Paginate(5);
        } else {
            $product_paginate = Product::orderBy('created_at', 'asc')->Paginate(5);
        }
        $binding = [
            'title' => '首頁',
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
}
