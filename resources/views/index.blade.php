<!doctype html>
<html lang="ch">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>阿梧生活賣場</title>
</head>

<body style="background-color:#90be6d;">
    <header class="navbar navbar-expand-lg navbar-dark" id="headers">
        <a class="navbar-brand" href="/">Aowu-Life賣場</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">首頁</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/farmer">小農產品</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/bread">手工麵包</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">登入</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">註冊</a>
                </li>
            </ul>
        </div>
    </header>

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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
</body>

</html>
