@extends('./layout/user_master')
@section('title',"LINE PAY結帳條碼")
@section('content')
<section class="container-fluid" id="show">
    <div class="row mx-auto">
        <div class="col-lg-7 mx-auto py-3">
            <div class="visible-print text-center">
                {!! QrCode::size(300)->generate($url); !!}
                <a class="btn btn-primary btn-lg btn-block mt-3" href="{{$url}}" role="button">前往LINE PAY付款頁面</a>
            </div>
        </div>
    </div>
</section>
@stop
