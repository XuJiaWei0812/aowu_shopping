$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    swal.setDefaults({
        confirmButtonText: "確定",
        cancelButtonText: "取消"
    });
    //註冊會員-start
    $("#register").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        swal({
            title: "確認會員資料正確？",
            html: "確定後將會成功註冊!",
            type: "question",
            showCancelButton: true//顯示取消按鈕
        }).then(
            function (result) {
                if (result.value) {
                    register(formData);
                } else if (result.dismiss === "cancel") {
                    //使用者按下「取消」要做的事
                    swal("取消", "取消註冊會員", "error");
                }//end else
            });//end then
    });
    function register(formData) {
        $.ajax({
            type: "POST",
            url: "/register",
            dataType: "json",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    swal("成功!", data.sucess, "success")
                        .then(
                            function (result) {
                                if (result.value) {
                                    window.setTimeout(window.location.href = "/", 100000);
                                }
                            });//end then
                } else {
                    swal("錯誤!", data.error, "error");
                }
            }
        });
    }
    //註冊會員-end

    //登入會員-start
    $("#login").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        login(formData)
    });
    function login(formData) {
        $.ajax({
            type: "POST",
            url: "/login",
            dataType: "text",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == true) {
                    swal({
                        title: "登入成功",
                        type: "success",
                        confirmButtonText: "確定"/*改這裡*/
                    }).then(
                        function () {
                                window.setTimeout(window.location.href = "/", 100000);
                        });//end then;
                } else {
                    swal({
                        title: "登入失敗",
                        html: "帳號密碼錯誤!",
                        type: "error",
                        confirmButtonText: "確定"/*改這裡*/
                    });
                }
            }
        });
    }
    //登入會員-end
});
