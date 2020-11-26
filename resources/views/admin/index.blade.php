@extends('./layout/admin_master')
@section('title',"後臺管理系統")
@section('content')
<section class="container-fluid">
    <div class="row mx-auto py-3">
        <div class="col-lg-8 mx-auto">
            <a class="btn btn-link btn-block text-light font-weight-bold" data-toggle="modal"
                data-target="#addProductModal" id="addProductButton">
                新增商品
            </a>
        </div>
    </div>
    <div class="row mx-auto">
        <div class="col-lg-8 mx-auto">
            <table class="table table-borderless table-hover table-responsive-sm mx-auto"
                style="background-color: #f4a261">
                <thead class="text-center font-weight-bold">
                    <tr class="font-weight-bold">
                        <th scope="col">圖片</th>
                        <th scope="col">狀態</th>
                        <th scope="col">價格</th>
                        <th scope="col">庫存</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="font-weight-bold text-center">
                    @foreach ($products as $product)
                    <tr>
                        <td scope="row">
                            <img class="rounded d-block vw-75 mx-auto px-3" width="500px"
                                src="{{asset(json_decode($product->photo)->url1)}}">
                        </td>
                        <td>
                            @if ($product->type=='0')
                            下架中
                            @else
                            上架中
                            @endif
                        </td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->inventory}}</td>
                        <td>
                            <a href="/admin/product/{{$product->id}}">
                                編輯
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @extends('admin/addProductModel')
    {{ $products->links() }}
</section>
@stop
