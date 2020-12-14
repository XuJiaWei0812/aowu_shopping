@extends('./layout/user_master')

@section('title',$title)

@section('content')

@if ($flash = session('tokenNull'))
<div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
    {{$flash}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<section class="container-fluid" id="show">
    <div class="row mx-auto">
        <div class="col-lg-7 mx-auto py-3">
            <table class="table table-borderless table-hover mx-auto rounded" style="background-color: #f4a261">
                <thead class="text-center text-nowrap">
                    <tr>
                        <th scope="col">名稱</th>
                        <th scope="col">價格</th>
                        <th scope="col">數量</th>
                        <th scope="col">金額</th>
                    </tr>
                </thead>
                <tbody>
                    @if(session()->has('cart'))
                    @foreach ($products as $product)
                    <tr class="h5 text-center">
                        <td>{{$product['product']['title']}}</td>
                        <td>{{$product['product']['price']}}</td>
                        <td>{{$product['qty']}}</td>
                        <td>{{$product['qty']*$product['product']['price']}}</td>
                    </tr>
                    @endforeach
                    @endif
                    <tr class="font-weight-bold text-right">
                        <td colspan="4">
                            <p class="mt-4">總金額: {{ $totalPrice}}$</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col-lg-7 mx-auto py-3">
            <form method="POST" class="mx-auto bg-white rounded p-3 font-weight-bold" method="/cart/checkout">
                <h5 class="font-weight-bold text-center">訂購人資料</h1>
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="exampleInputName1">收貨姓名</label>
                        <input required type="text" name="name" class="form-control" id="name" placeholder="輸入姓名">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputAddress1">送件地址</label>
                        <input required type="text" name="address" class="form-control" id="phone" placeholder="輸入地址">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">手機號碼</label>
                        <input required type="text" name="phone" class="form-control" id="phone" placeholder="輸入姓名">
                    </div>
                    <div class="form-group">
                        <label for="type">付款方式:</label>
                        <select class="form-control" name="payment" id="payment">
                            <option value="0" selected>
                                貨到付款
                            </option>
                            <option value="1">
                                Line Pay
                            </option>
                            <option value="2">
                                綠界付款
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">送出訂單</button>
            </form>
        </div>
    </div>
</section>
@endsection
