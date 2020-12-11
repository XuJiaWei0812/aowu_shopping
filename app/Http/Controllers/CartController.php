<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use GuzzleHttp\Client;
use Validator;
use Session;

class CartController extends Controller
{
    public function index()
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        return view('user.cart', [
            'products'=> $cart->products,
            'totalPrice'=> $cart->totalPrice,
            'totalQty'=>$cart->totalQty,
            'title'=>'購物車',]);
        // return dd($cart);
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
    public function increaseByOne(Request $request, $id)
    {
        $cart = new Cart(Session::get('cart'));
        $cart->increaseByOne($id);
        session()->put('cart', $cart);
        return redirect()->action('CartController@index');
    }

    public function decreaseByOne(Request $request, $id)
    {
        $cart = new Cart(Session::get('cart'));
        $cart->decreaseByOne($id);
        session()->put('cart', $cart);
        if ($cart->totalQty===0) {
            session()->forget('cart');
            return redirect()->action('CartController@index');
        } else {
            return redirect()->action('CartController@index');
        }
    }

    public function clearCart()
    {
        if (session()->has('cart')) {
            session()->forget('cart');
        }
        return redirect()->action('CartController@index');
    }
    //結帳顯示跟控制器-start
    public function checkoutview()
    {
        $oldCart = session()->has('cart') ? session()->get('cart') : null;
        $cart = new Cart($oldCart);
        if ($oldCart) {
            return view('user.checkout', [
            'products'=> $cart->products,
            'totalPrice'=> $cart->totalPrice,
            'totalQty'=>$cart->totalQty,
            'title'=>'購物車結帳']);
        } else {
            return response('404 Not Found', 404);
        }
    }
    ////結帳過程(判斷結帳方式之後新增訂單)
    public function checkout(Request $request)
    {
        $input=$request->all();
        //驗證規則
        $rules = [
            'name' => ['required', 'min:3', 'max:18'],
            'phone' => ['required'],
            'address' => ['required'],
        ];
        //驗證資料
        $validatedData = Validator::make($input, $rules);

        if ($validatedData->fails()) {
            //傳送失敗JSON回應
            return response()->json(['error' => $validatedData->errors()->all()]);
        } else {
            if ($input['payment']==0) {
                return dd('貨到付款');
            } elseif ($input['payment']==1) {
                return dd('linepay');
            } elseif ($input['payment']==2) {
                return dd('綠界付款');
            }
        }
    }
    ////增加訂單order
    public function addOrder($request)
    {
        $cart = session()->get('cart');
        $order_uuid = str_replace("-", "", substr(Str::uuid()->toString(), 0, 18));
        Order::create([
            'name' => $input["name"],
            'email' => $input["email"],
            'cart' => serialize($cart),
            'address'=>$input["address"],
            'uuid' =>  $order_uuid,
            ]);
    }
    ////LINEPAY付款
    public function linePay()
    {
        $client = new Client();
        $result = $client->post('https://sandbox-api-pay.line.me/v2/payments/request', [
            'headers' => [
                'Content-Type'=> 'application/json; charset=UTF-8',
                'X-LINE-ChannelId'=> 1655338422,
                'X-LINE-ChannelSecret'=> 'c08aebe4829794bf77cbf2a033954484'
             ],
            'json' => [
                    "productName"     => "測試商品",
                    "productImageUrl" => "image/5fce5005730c4.jpg",
                    "amount"          => "150",
                    "currency"        => "TWD",
                    "confirmUrl"      => "/cart/confirm",
                    "orderId"         => "test123456789"
            ]
        ]);
        $response =  $result->getBody()->getContents();
        $response=json_decode($response, true);

        return dd($response['info']['paymentUrl']['web']);
    }
    ////付款結束
    public function checkoutEnd()
    {
        return "ok";
    }
    //結帳顯示跟控制器-end
}
