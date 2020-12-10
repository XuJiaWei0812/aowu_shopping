@extends('layout/auth_master')

@section('title',$title)

@section('content')
<section class="container-fluid" id="show">
    <div class="row mx-auto">
        <div class="col-lg-7 mx-auto py-3">
            <form method="POST" id="register" class="bg-light rounded border border-dark mx-auto p-3">
                @csrf
                <div class="form-group">
                    <h1 class="text-center">{{$title}}</h1>
                </div>
                <div class="form-group">
                    <label for="name">暱稱:</label>
                    <input required type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                        placeholder="暱稱" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email">信箱:</label>
                    <input required type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                        placeholder="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">密碼:</label>
                    <input required type="password" class="form-control" id="password" name="password"
                        aria-describedby="emailHelp" placeholder="密碼">
                </div>

                <div class="form-group">
                    <label for="password_confirmatiom">確認密碼:</label>
                    <input required type="password" class="form-control" id="c_password" name="c_password" placeholder="確認密碼">
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">送出</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
