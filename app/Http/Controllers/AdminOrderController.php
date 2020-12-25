<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthorityAdmin', ['only'=>['index']]);
        $this->middleware('TokenCheck', ['only'=>['orderUpdate']]);
    }
    public function index()
    {
        $orders = Order::orderBy('created_at', 'asc')->get();
        if ($orders!==null) {
            foreach ($orders as $order) {
                if ($order->paid==0) {
                    $order->paid="未付款";
                } elseif ($order->paid==1) {
                    $order->paid="已付款";
                }
                if ($order->transport==0) {
                    $order->transport="待出貨";
                } elseif ($order->transport==1) {
                    $order->transport="出貨中";
                } elseif ($order->transport==2) {
                    $order->transport="已送達";
                }
            }
            $binding = [
                'orders' => $orders,
            ];
            return view('admin.adminOrder', $binding);
        } else {
            abort(404);
        }
    }
    public function orderUpdate(Request $request)
    {
        $data=$request->all();
        if ($data!==null) {
            $update=Order::where('id', $data['orderId'])
                   ->update(['transport' => $data['transport']]);
            if ($update!==null) {
                return true;
            }
        } else {
            return false;
        }
    }
}
