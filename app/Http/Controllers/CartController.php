<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
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
        return redirect('/product/'.$id);
    }
    public function goToCart(Request $request, $id)
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
            if ($input['payment']==0) {//paid=0
                $this-> addOrder($input);
                return redirect('/');
            } elseif ($input['payment']==1) {//paid=1
                return view('user.linePay', [
                    'url'=>$this->linePay(),
                    'title'=>'購物車結帳']);
            } elseif ($input['payment']==2) {//paid=2
                $this-> ECPay($input);
            }
            // return dd($input);
        }
    }
    ////增加訂單order 減庫存 提醒付款成功
    public function addOrder($input)
    {
        $cart = session()->get('cart');
        $order_uuid = str_replace("-", "", substr(Str::uuid()->toString(), 0, 18));
        Order::create([
            'uid' => '1',
            'name' => $input["name"],
            'cart' => serialize($cart),
            'address'=>$input["address"],
            'phone'=>$input["phone"],
            'uuid' =>  $order_uuid,
            ]);
        foreach ($cart->products as $key=>$val) {
            Product::where('id', $key)
                ->decrement('inventory', $val['qty']);
        }
        session()->forget('cart');
        session()->flash('success', '訂單付款成功!');
    }
    ////LINEPAY付款
    public function linePay()
    {
        $cart = session()->get('cart');
        $order_uuid = str_replace("-", "", substr(Str::uuid()->toString(), 0, 18));
        $client = new Client();
        $result = $client->post('https://sandbox-api-pay.line.me/v2/payments/request', [
            'headers' => [
                'Content-Type'=> 'application/json; charset=UTF-8',
                'X-LINE-ChannelId'=> 1655338422,
                'X-LINE-ChannelSecret'=> 'c08aebe4829794bf77cbf2a033954484'
             ],
            'json' => [
                    "productName"     => "Aowu-Life賣場",
                    "productImageUrl" => "image/5fce5005730c4.jpg",
                    "amount"          => $cart->totalPrice,
                    "currency"        => "TWD",
                    "confirmUrl"      => "/cart/confirm",
                    "orderId"         => $order_uuid
            ]
        ]);
        $response =  $result->getBody()->getContents();
        $response=json_decode($response, true);
        return $response['info']['paymentUrl']['web'];
    }
    public function ECPay($input)
    {
        try {
            $cart = session()->get('cart');
            $order_uuid = str_replace("-", "", substr(Str::uuid()->toString(), 0, 18));
            $obj = new \ECPay_AllInOne();
            //服務參數
            $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
            $obj->HashKey     = '5294y06JbISpM5x9' ;                                           //測試用Hashkey，請自行帶入ECPay提供的HashKey
            $obj->HashIV      = 'v77hoKGq4kWxNNIS' ;                                           //測試用HashIV，請自行帶入ECPay提供的HashIV
            $obj->MerchantID  = '2000132';                                                     //測試用MerchantID，請自行帶入ECPay提供的MerchantID
            $obj->EncryptType = '1';                                                           //CheckMacValue加密類型，請固定填入1，使用SHA256加密
            //基本參數(請依系統規劃自行調整)
            $MerchantTradeNo = $order_uuid ;
            $obj->Send['ReturnURL']         = "https://c4383376e4fc.ngrok.io/callback" ;    //付款完成通知回傳的網址
            $obj->Send['PeriodReturnURL']         = "https://c4383376e4fc.ngrok.io/callback" ;    //付款完成通知回傳的網址
            $obj->Send['ClientBackURL'] = " https://c4383376e4fc.ngrok.io/success" ;    //付款完成通知回傳的網址
            $obj->Send['MerchantTradeNo']   = $order_uuid;                          //訂單編號
            $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                       //交易時間
            $obj->Send['TotalAmount']       = $cart->totalPrice;                                      //交易金額
            $obj->Send['TradeDesc']         = "good to drink" ;                          //交易描述
            $obj->Send['ChoosePayment']     = ECPayMethod::Credit ;              //付款方式:Credit
            $obj->Send['IgnorePayment']     = ECPayMethod::GooglePay ;           //不使用付款方式:GooglePay
            //訂單的商品資料
            array_push($obj->Send['Items'], array('Name' => 'Aowu-Life賣場', 'Price' => $cart->totalPrice,
            'Currency' => "元", 'Quantity' => (int) "1", 'URL' => "dedwed"));
            $obj->CheckOut();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    ////付款結束
    public function checkoutEnd()
    {
        return "ok";
    }
    //結帳顯示跟控制器-end
}
