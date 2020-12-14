@extends('./layout/user_master')
@section('title',"購物車")
@section('content')
<section class="container-fluid" id="show">
    <div class="row mx-auto">
        <div class="col-lg-7 mx-auto py-3">
            <table class="table table-borderless table-hover mx-auto" style="background-color: #f4a261">
                <thead class="text-center text-nowrap">
                    <tr>
                        <th scope="col">名稱</th>
                        <th scope="col">價格</th>
                        <th scope="col">數量</th>
                    </tr>
                </thead>
                <tbody>
                    @if(session()->has('cart'))
                    @foreach ($products as $product)
                    <tr>
                        <th scope="row">
                            <img class="img-fluid rounded float-left mr-3" width="86px" height="86px"
                                src="{{asset(json_decode($product['product']['photo'])->url1)}}">
                            <span>{{$product['product']['title']}}</span>
                        </th>
                        <td class="text-center pt-3"><span>{{$product['product']['price']}}</span></td>
                        <td class="text-center d-flex justify-content-center">
                            <a href="/cart/decreaseOneProduct/{{$product['product']['id']}}"
                                class="btn btn-link btn-sm ml-1">
                                <i class="fas fa-minus fa-1x" style="color: #161a1d"></i>
                            </a>
                            <span class="py-1">{{$product['qty']}}</span>
                            <a href="/cart/increaseOneProduct/{{$product['product']['id']}}"
                                class="btn btn-link btn-sm mr-1">
                                <i class="fas fa-plus fa-1x" style="color: #161a1d"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    <tr class="font-weight-bold text-right">
                        <td colspan="3">
                            <p class="mt-4">總數量: {{$totalQty}}</p>
                            <p class="mt-4">總金額: {{ $totalPrice}}$</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <a href="/cart/checkout" class="px-3 py-3 btn btn-success float-right">前往結帳</a>
                        </td>
                    </tr>
                    @else
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
