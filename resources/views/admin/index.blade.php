@extends('./layout/admin_master')
@section('title',"後臺管理系統")
@section('content')
<section class="container-fluid" id="show">
    <div class="row mx-auto py-3">
        <div class="col-lg-8 mx-auto">
            <a class="btn  btn-link btn-block text-light font-weight-bold" data-toggle="modal"
                data-target="#addProductModal" id="addProduct">
                新增商品
            </a>
        </div>
    </div>
    @extends('admin/addProductModel')
</section>
@stop
