<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use \ECPay_PaymentMethod as ECPayMethod;
use Validator;
use Session;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('TokenCheck', ['only'=>['checkout']]);
    }
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
    public function checkInventory($id)
    {
        $product = Product::find($id);
        $cart=Session::get('cart');
        if (empty($cart->products[$id])) {//確認購物車中是否有相同商品
            return true;
        } elseif ($product->inventory<=$cart->products[$id]['qty']) {
            return false;
        } else {
            return true;
        }
    }
    public function getAddToCart(Request $request, $id)
    {
        try {
            //取得符合$id的商品
            $product = Product::find($id);
            //確認Session當中是否有cart
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            //使用Cart並將$oldCart帶入
            $cart = new Cart($oldCart);
            if ($oldCart==null) {//還沒建立購物車
                //使用Cart的add 方法 將 商品 以及 商品編號 帶入
                $cart->add($product, $product->id);
            } elseif ($this->checkInventory($id)) {//購買商品庫存不夠
                $cart->add($product, $product->id);
            }
            Session::put('cart', $cart);
            return "getAddToCart";
        } catch (\Exception $e) {
            abort(403, '錯誤回應');
        }
    }
    public function goToCart(Request $request, $id)
    {
        try {
            //取得符合$id的商品
            $product = Product::find($id);
            //確認Session當中是否有cart
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            //使用Cart並將$oldCart帶入
            $cart = new Cart($oldCart);
            if (empty($cart->products[$id])) {//確認購物車中是否有相同商品
                $cart->add($product, $product->id);
            }
            //將$cart放入Session中的cart
            Session::put('cart', $cart);
            return "goToCart";
        } catch (\Exception $e) {
            abort(403, '錯誤回應');
        }
    }
    public function increaseByOne(Request $request, $id)
    {
        try {
            if ($this->checkInventory($id)) {//購買商品庫存不夠
                $cart = new Cart(Session::get('cart'));
                $cart->increaseByOne($id);
                session()->put('cart', $cart);
                return true;
            } else {
                return $this->checkInventory($id);
            }
        } catch (\Exception $e) {
            abort(403, '錯誤回應');
        }
    }

    public function decreaseByOne(Request $request, $id)
    {
        try {
            $cart = new Cart(Session::get('cart'));
            $cart->decreaseByOne($id);
            session()->put('cart', $cart);
            if ($cart->totalQty===0) {
                session()->forget('cart');
            }
            return true;
        } catch (\Exception $e) {
            abort(403, '錯誤回應');
        }
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
            abort(404);
        }
    }
    ////結帳過程(判斷結帳方式之後新增訂單)
    public function checkout(Request $request)
    {
        try {
            $cart = session()->get('cart');
            $input=$request->all();
            $order_uuid = str_replace("-", "", substr(Str::uuid()->toString(), 0, 18));
            if ($input['payment']==0) {//payment=0
                $this-> addOrder(Auth::user()->id, $input, $cart, $order_uuid, 0);
                return redirect('/cart/success');
            } elseif ($input['payment']==1) {//payment=1
                $this-> addOrder(Auth::user()->id, $input, $cart, $order_uuid, 0);
                return view('user.linePay', [
                    'url'=>$this->linePay($cart->totalPrice, $order_uuid),
                    'title'=>'購物車結帳']);
            } elseif ($input['payment']==2) {//payment=2
                $this-> addOrder(Auth::user()->id, $input, $cart, $order_uuid, 0);
                $this-> ECPay($cart->totalPrice, $order_uuid);
            }
        } catch (\Exception $e) {
            abort(403, '錯誤回應');
        }
    }
    ////增加訂單order 減庫存 提醒付款成功
    public function addOrder($uid, $input, $cart, $uuid, $paid=null)
    {
        try {
            Order::create([
            'uid' => $uid,
            'name' => $input["name"],
            'cart' => serialize($cart),
            'address'=>$input["address"],
            'phone'=>$input["phone"],
            'uuid' =>  $uuid,
            'paid' =>$paid
            ]);
            foreach ($cart->products as $key=>$val) {
                Product::where('id', $key)
                ->decrement('inventory', $val['qty']);
            }
        } catch (\Exception $e) {
            abort(403, '錯誤回應');
        }
    }
    ////LINEPAY付款
    public function linePay($totalPrice, $order_uuid)
    {
        $client = new Client();
        $result = $client->post('https://sandbox-api-pay.line.me/v2/payments/request', [
            'headers' => [
                'Content-Type'=> 'application/json; charset=UTF-8',
                'X-LINE-ChannelId'=> 1655338422,
                'X-LINE-ChannelSecret'=> 'c08aebe4829794bf77cbf2a033954484'
             ],
            'json' => [
                    "productName"     => "Aowu-Life賣場",
                    "productImageUrl" => "https://i.imgur.com/ez0kIJe.jpg",
                    "amount"          => $totalPrice,
                    "currency"        => "TWD",
                    "confirmUrl"      =>  asset("/cart/callback/?").'uuid='.$order_uuid,
                    "orderId"         => $order_uuid
            ]
        ]);
        $response =  $result->getBody()->getContents();
        $response=json_decode($response, true);
        session()->forget('cart');
        return $response['info']['paymentUrl']['web'];
    }
    public function ECPay($totalPrice, $order_uuid)
    {
        try {
            $obj = new \ECPay_AllInOne();

            //服務參數
            $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
            $obj->HashKey     = '5294y06JbISpM5x9' ;                                           //測試用Hashkey，請自行帶入ECPay提供的HashKey
            $obj->HashIV      = 'v77hoKGq4kWxNNIS' ;                                           //測試用HashIV，請自行帶入ECPay提供的HashIV
            $obj->MerchantID  = '2000132';                                                     //測試用MerchantID，請自行帶入ECPay提供的MerchantID
            $obj->EncryptType = '1';                                                           //CheckMacValue加密類型，請固定填入1，使用SHA256加密
            //基本參數(請依系統規劃自行調整)
            $MerchantTradeNo = $order_uuid ;
            $obj->Send['ReturnURL']         = "http://59.127.54.30:80/callback" ;    //付款完成通知回傳的網址
            $obj->Send['PeriodReturnURL']         = "http://59.127.54.30:80/callback" ;    //付款完成通知回傳的網址
            $obj->Send['ClientBackURL'] = " http://59.127.54.30:80/cart/success" ;    //付款完成通知回傳的網址
            $obj->Send['MerchantTradeNo']   = $MerchantTradeNo;                          //訂單編號
            $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                       //交易時間
            $obj->Send['TotalAmount']       = $totalPrice;                                      //交易金額
            $obj->Send['TradeDesc']         = "good to drink" ;                          //交易描述
            $obj->Send['ChoosePayment']     = ECPayMethod::Credit ;              //付款方式:Credit
            $obj->Send['IgnorePayment']     = ECPayMethod::GooglePay ;           //不使用付款方式:GooglePay
            //訂單的商品資料
            array_push($obj->Send['Items'], array('Name' => "Aowu-Life賣場", 'Price' => $totalPrice,
            'Currency' => "元", 'Quantity' => (int) "1", 'URL' => "dedwed"));
            session()->forget('cart');
            $obj->CheckOut();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    ////付款結束
    public function callback()
    {
        $order = Order::where('uuid', '=', $_GET['uuid'])->firstOrFail();
        $order->paid = !$order->paid;
        $order->save();
        return redirect('/cart/success');
    }
    public function ECPayCallback()
    {
        $order = Order::where('uuid', '=', request('MerchantTradeNo'))->firstOrFail();
        $order->paid = !$order->paid;
        $order->save();
    }
    public function success()
    {
        session()->forget('cart');
        session()->flash('success', '訂單建立成功!');
        return redirect('/');
    }
}
