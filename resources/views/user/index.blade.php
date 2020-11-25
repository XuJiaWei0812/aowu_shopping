@extends('./layout/user_master')
@section('title',"阿梧的生活賣場")
@section('content')
<section class="container-fluid">
    <div class="row mx-auto">
        <div class="col-lg-4 py-3">
            <a href="/product" style="color:#000000;text-decoration: none;transform:scale(1,1);">
                <div class="card">
                    <div class="card-body">
                        <img src="{{asset('./image/測試照片 (2).jpg')}}" class="img-fluid d-block rounded"
                            alt="this is the product photo">
                        <div class="card-title text-left font-weight-bold pt-3">
                            【歐式麵包-短棍型】自家純手工製作 純牛奶且無添加防腐劑
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text">NT $35
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
@stop
