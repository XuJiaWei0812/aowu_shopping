@extends('./layout/user_master')
@section('title',"編號XXXX商品")
@section('content')
<section class="container">
    <div class="row bg-white mt-3 rounded">
        <div class="col-lg-6 my-3">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('./image/測試照片 (2).jpg')}}" class="d-block w-100 rounded" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('./image/測試照片.jpg')}}" class="d-block w-100 rounded" alt="...">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-lg-6 my-3">
            <h1 style="font-size:28px;">【歐式麵包-短棍型】自家純手工製作 純牛奶且無添加防腐劑</h1>
            <p class="pt-3 font-weight-bold" style="font-size:18px;">
                使用高筋麵粉、瑞穗鮮奶、安佳無鹽奶油等好品質的原料製成，無添加任何化學原料，讓顧客買的放心、吃得安心。
            </p>
            <div class="d-flex">
                <p class="pt-3 font-weight-bold" style="font-size:28px;color:#e63946;">
                    NT$35
                </p>
                <p class="pt-3 font-weight-bold ml-auto" style="font-size:28px;color:#e63946;">
                    庫存:50
                </p>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-danger mr-2 btn-block">加入購物車</button>
                <button type="button" class="btn btn-warning m-0 btn-lg btn-block">直接結帳</button>
            </div>
        </div>
    </div>
</section>
@stop
