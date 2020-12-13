@extends('./layout/user_master')
@section('title',"購物車")
@section('content')
<section class="container-fluid" id="show">
    <div class="row mx-auto">
        <div class="col-lg-8 mx-auto py-3 px-0">
            <table class="table table-borderless table-hover mx-auto" style="background-color: #f4a261">
                <thead class="text-center text-nowrap">
                    <tr>
                        <th scope="col">訂單編號</th>
                        <th scope="col">商品明細</th>
                        <th scope="col">付款資料</th>
                        <th scope="col">運送狀況</th>
                    </tr>
                </thead>
                <tbody class="font-weight-bold">
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row" class="text-center">
                            {{$order->uuid}}
                        </th>
                        <td class="text-center">
                            <div class="accordion" id="accordionExample">
                                <a class="btn btn-link text-primary font-weight-bold" type="button"
                                    data-toggle="collapse" data-target="#collapseOne{{$order->id}}" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    點擊閱讀
                                </a>
                                <div id="collapseOne{{$order->id}}" class="collapse" aria-labelledby="headingOne">
                                    @foreach(unserialize($order->cart)->products as $product)
                                    <p>{{$product['product']['title']}} ×
                                        {{$product['qty']}}</p>
                                    @endforeach
                                    <p> 總金額 : {{unserialize($order->cart)->totalPrice}} 元
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="accordion" id="accordionExample">
                                <a class="btn btn-link text-primary font-weight-bold" type="button"
                                    data-toggle="collapse" data-target="#collapseTwo{{$order->id}}" aria-expanded="true"
                                    aria-controls="collapseTwo">
                                    點擊閱讀
                                </a>
                                <div id="collapseTwo{{$order->id}}" class="collapse" aria-labelledby="headingOne">
                                    <p>收件人 : {{$order->name}}</p>
                                    <p>地址 : {{$order->address}}</p>
                                    <p>電話 : {{$order->phone}}</p>
                                    <p>付款方式 : {{$order->paid}}</p>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            {{$order->transport}}
                        </td>
                    </tr>
                    @endforeach
                    @if($orders==null)
                    <tr class="h5 text-center">
                        <td colspan="4">
                            您尚未選購商品
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
@stop
