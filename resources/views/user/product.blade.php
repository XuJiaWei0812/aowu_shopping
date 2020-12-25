@extends('./layout/user_master')
@section('title',$title)
@section('content')
<section class="container">
    <div class="row bg-white my-3 mx-auto rounded">
        <div class="col-lg-6 my-3">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @php
                    $i=0;
                    @endphp
                    @foreach (json_decode($product->photo) as $url)
                    <div class="carousel-item @if($i==0) active @endif ">
                        <img src="{{asset($url)}}" class="d-block w-100 rounded h-50" alt="...">
                    </div>
                    @php
                    $i++;
                    @endphp
                    @endforeach
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
        <div class="d-flex align-items-start flex-column bd-highlight mb-3 col-lg-6 my-3">
            <div class="mb-auto p-2">
                <h1 style="font-size:28px;">{{$product->title}}</h1>
                <p class="pt-3 font-weight-bold" style="font-size:18px;">
                    {{$product->description}}
                </p>
            </div>
            <div class="d-flex p-2 w-100">
                <p class="pt-3 font-weight-bold" style="font-size:28px;color:#e63946;">
                    NT${{$product->price}}
                </p>
                <p class="pt-3 font-weight-bold ml-auto" style="font-size:28px;color:#e63946;">
                    庫存:{{$product->inventory}}
                </p>
            </div>
            <div class="d-flex p-2 w-100">
                <button name="whatDoCart" data-action="addToCart" data-key="{{$product->id}}"
                    class="font-weight-bold btn btn-danger mr-2 btn-lg btn-block float-left">
                    加入購物車
                </button>
                <button name="whatDoCart" data-action="goToCart" data-key="{{$product->id}}"
                    class="font-weight-bold btn btn-warning m-0 btn-lg btn-block float-right">
                    直接結帳
                </button>
            </div>
        </div>
    </div>
</section>
@stop
