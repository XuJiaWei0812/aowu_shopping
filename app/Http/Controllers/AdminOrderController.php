<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class AdminOrderController extends Controller
{
     public function index()
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
                'orders' => $orders,
            ];
            return view('admin.adminOrder', $binding);
        } else {
            return response('404 Not Found', 404);
        }
    }
}
