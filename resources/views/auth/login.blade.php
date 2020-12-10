@extends('layout/auth_master')

@section('title',$title)

@section('content')
<section class="container-fluid" id="show">
    <div class="row mx-auto">
        <div class="col-lg-7 mx-auto py-3">
            <form method="POST" id="login" class="bg-light rounded border border-dark mx-auto p-3">
                @csrf
                <div class="form-group">
                    <h1 class="text-center">{{$title}}</h1>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                        placeholder="Email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">密碼:</label>
                    <input type="password" class="form-control" id="password" name="password"
                        aria-describedby="emailHelp" placeholder="密碼">
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">送出</button>
                    <small class="form-text text-muted text-center pt-3">
                        <p>
                            還不是會員?
                            <a href="/register" class="btn btn-link p-0 pb-1">加入會員</a>
                        </p>
                    </small>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
