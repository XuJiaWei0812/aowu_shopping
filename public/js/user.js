$(document).ready(function () {
    if (!!window.performance && window.performance.navigation.type === 2) {
        window.location.assign(window.location.href);
    }
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $("#shopping-cart").click(function () {
        location.replace("/cart/");
    });
    $("button[name='whatDoCart']").click(function (event) {
        event.preventDefault();
        var action = $(this).data('action');//加入商品OR直接結帳
        var key = $(this).data('key');//被增減的商品編號
        // console.log(action+key);
        whatDoCart(action, key);
    });
    function whatDoCart(action, key) { //購物車增加減少AJAX
        var url = '/cart/' + action + '/' + key;
        $.ajax({
            type: "post",
            url: url,
            dataType: "text",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == "getAddToCart") {
                    location.replace("/product/" + key);
                } else if (data == "goToCart") {
                    location.replace("/cart/");
                }
            }
        });
    }
    $("button[name='calculation']").click(function (event) {
        event.preventDefault();
        var action = $(this).data('action');//購物車增減動作
        var key = $(this).data('key');//被增減的商品編號
        calculation(action,key);
    });
    function calculation(action, key) { //購物車增加減少AJAX
        var url = '/cart/' + action + '/' + key;
        $.ajax({
            type: "post",
            url: url,
            dataType: "text",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data==true){
                    location.replace("/cart/");
                } else if (data == false){
                    swal({
                        title: "超過庫存量!",
                        type: "error",
                        confirmButtonText: "確定"/*改這裡*/
                    })
                }
            }
        });
    }
    $("#logout").click(function (event) { //登出按鈕點擊事件
        event.preventDefault();
        logout();
    });
    function logout() { //登出AJAX方法
        $.ajax({
            type: "GET",
            url: "/logout",
            dataType: "text",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == true) {
                    swal({
                        title: "登出成功",
                        type: "success",
                        confirmButtonText: "確定"/*改這裡*/
                    }).then(
                        function () {
                            window.setTimeout(window.location.href = "/login", 100000);
                        });//end then;
                }
            }
        });
    }
});
