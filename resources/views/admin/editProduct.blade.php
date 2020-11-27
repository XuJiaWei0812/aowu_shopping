@extends('./layout/admin_master')
@section('title',"商品編輯")
@section('content')
<section class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mx-auto my-3">
            <form class="bg-light rounded p-3 vw-75 mx-auto font-weight-bold" id="editProductForm"
                name="{{$products->id}}" enctype="multipart/form-data">
                {{method_field('PUT')}}
                <div class="form-group">
                    <label class="btn btn-info">
                        <input id="photo" name="photo[]" style="display:none;" type="file" multiple>
                        <i class="fas fa-upload"></i> 上傳圖片
                    </label>
                </div>
                <div class="form-group clearfix" id="productsImage">
                    @foreach (json_decode($products->photo) as $url)
                    <img src="{{asset($url)}}" class="float-left rounded mx-2 my-2 d-block" width='100px' height='100px'
                        alt="this is the product photo">
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="title">名稱:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="商品名稱"
                        value="{{ old('title',$products->title) }}">
                </div>
                <div class="form-group">
                    <label for="type">分類:</label>
                    <select class="form-control" name="sort" id="sort">
                        <option value="0" @if (old('sort',$products->sort=='0'))
                            selected
                            @endif>
                            小農產品
                        </option>
                        <option value="1" @if (old('sort',$products->sort=='1'))
                            selected
                            @endif>
                            手工麵包
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">介紹:</label>
                    <textarea class="form-control" id="description" name="description"
                        rows="3">{{old('description',$products->description)}}</textarea>
                </div>
                <div class="form-group">
                    <label for="price">價格:</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="商品價格"
                        value="{{ old('price',$products->price) }}">
                </div>
                <div class="form-group">
                    <label for="inventory">庫存:</label>
                    <input type="text" class="form-control" id="inventory" name="inventory" placeholder="商品價格"
                        value="{{ old('inventory',$products->inventory) }}">
                </div>
                <div class="form-group">
                    <label for="type">狀態:</label>
                    <select class="form-control" name="type" id="type">
                        <option value="0" @if (old('type',$products->type=='0'))
                            selected
                            @endif>
                            下架
                        </option>
                        <option value="1" @if (old('type',$products->type=='1'))
                            selected
                            @endif>
                            上架
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="alert alert-danger" id="validatorMsg" role="alert" style="display:none">

                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">編輯</button>
                </div>
            </form>
        </div>
    </div>
</section>
@stop
