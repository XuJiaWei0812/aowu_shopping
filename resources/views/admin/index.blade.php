@extends('./layout/admin_master')
@section('title',"後臺管理系統")
@section('content')
<section class="container-fluid">
    <div class="row py-3">
        <div class="col-lg-8 mx-auto">
            <a class="btn btn-link btn-block text-light font-weight-bold" data-toggle="modal"
                data-target="#addProductModal" id="addProductButton">
                新增商品
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <table class="table table-borderless table-hover table-responsive-sm mx-auto"
                style="background-color: #f4a261" id="productTable">
                <thead>
                    <tr class="font-weight-bold text-center mx-auto">
                        <th scope="col">圖片</th>
                        <th scope="col">狀態</th>
                        <th scope="col">價格</th>
                        <th scope="col">庫存</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                   <tr class="font-weight-bold text-center mx-auto" style="vertical-align:middle;">
                        <td scope="row" class="w-50">
                            <img class="img-fluid rounded d-block mx-auto"
                                src="{{asset(json_decode($product->photo)->url1)}}">
                        </td>
                        <td>
                            @if ($product->type=='0')
                            下架
                            @else
                            上架
                            @endif
                        </td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->inventory}}</td>
                        <td width="50px">
                            <a class="btn btn-link" href="/admin/product/{{$product->id}}">
                                <i class="fas fa-edit fa-2x" style="color: #d90429;"></i>
                            </a>
                        </td>
                    </a>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @extends('admin/addProductModel')
    <div class="d-flex justify-content-center">
        {!! $products->links() !!}
    </div>
</section>
@stop
