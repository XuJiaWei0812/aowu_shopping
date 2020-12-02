<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Session;

class CartController extends Controller
{
    public function index()
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        // return view('cart.cart', [
        //     'products'=> $cart->products,
        //     'totalPrice'=> $cart->totalPrice,
        //     'totalQty'=>$cart->totalQty,
        //     'title'=>'購物車',]);
        return dd($cart);
    }
    public function getAddToCart(Request $request, $id)
    {
        //取得符合$id的商品
        $product = Product::find($id);
        //確認Session當中是否有cart
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        //使用Cart並將$oldCart帶入
        $cart = new Cart($oldCart);
        //使用Cart的add 方法 將 商品 以及 商品編號 帶入
        $cart->add($product, $product->id);
        //將$cart放入Session中的cart
        Session::put('cart', $cart);
        return redirect()->action('CartController@index');
    }
}
