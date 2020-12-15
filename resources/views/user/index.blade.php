@extends('./layout/user_master')
@section('title',$title)
@section('content')

@if ($flash = session('success'))
<div class="alert alert-success alert-dismissible fade show m-4" role="alert">
    {{$flash}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<section class="container-fluid">
    <div class="row mx-auto">
        @foreach ($products as $product)
        @if($product->type===1)
        <div class="col-lg-4 py-3">
            <a href="{{asset('/product/'.$product->id)}}" style="color:#000000;text-decoration: none;transform:scale(1,1);">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="{{asset(json_decode($product->photo)->url1)}}" class="img-fluid d-block rounded"
                            alt="麵包">
                        <div class="card-title text-left font-weight-bold pt-3" style="font-size: 18px">
                            {{$product->title}}
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="card-text" style="font-size: 18px">NT${{$product->price}}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif
        @endforeach
    </div>
</section>
@stop
