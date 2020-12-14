$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    swal.setDefaults({
        confirmButtonText: "確定",
        cancelButtonText: "取消"
    });
    //admin上傳照片
    $("#photo").change(function () {
        $('#productsImage').html("");
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files.length >= 0) {
            console.log(input.files.length);
            if (input.files.length > 8) {
                console.log('超過數量8');
            } else {
                for (var i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img class='float-left rounded mx-2 my-2 d-block' width='100px' height='100px'>").attr('src', e.target.result);
                        $('#productsImage').append(img);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }
    }
    //admin上傳照片
    //addProductModel新增商品表單
    $("#addProductForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        // console.log(formData.getAll('upload'));
        //confirm dialog範例
        swal({
            title: "確定新增此商品？",
            html: "確定後將會新增商品!",
            type: "question",
            showCancelButton: true//顯示取消按鈕
        }).then(
            function (result) {
                if (result.value) {
                    addProduct(formData);
                } else if (result.dismiss === "cancel") {
                    //使用者按下「取消」要做的事
                    swal("取消", "取消新增此商品", "error");
                }//end else
            });//end then
    });
    function addProduct(formData) {
        $.ajax({
            type: "POST",
            url: "/admin/product/",
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
                                    window.setTimeout(window.location.href = "/admin", 100000);
                                }
                            });//end then
                } else {
                    swal("錯誤!", data.error, "error");
                }
            }
        });
    }
    //addProductModel新增商品表單
    $("#editProductForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        // console.log(formData.getAll('upload'));
        var id = this.name;
        swal({
            title: "確定編輯此商品資訊？",
            html: "確定後商品資訊將會更新",
            type: "question",
            showCancelButton: true//顯示取消按鈕
        }).then(
            function (result) {
                if (result.value) {
                    editProduct(formData, id);
                } else if (result.dismiss === "cancel") {
                    //使用者按下「取消」要做的事
                    swal("取消", "取消編輯此商品資訊", "error");
                }//end else
            });//end then
    });
    function editProduct(formData, id) {
        $.ajax({
            type: "POST",
            url: "/admin/product/" + id,
            dataType: "json",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    swal("成功!", data.success, "success")
                        .then(
                            function (result) {
                                if (result.value) {
                                    window.setTimeout(window.location.href = "/admin", 100000);
                                }
                            });//end then
                } else {
                    swal("錯誤!", data.error, "error");
                }
            }
        });
    }
    $("#logout").click(function (event) {
        event.preventDefault();
        logout();
    });
    function logout() {
        $.ajax({
            type: "GET",
            url: "/logout",
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if ($.isEmptyObject(data.error)) {
                    swal({
                        title: "登出成功",
                        type: "success",
                        confirmButtonText: "確定"/*改這裡*/
                    }).then(
                        function () {
                            window.setTimeout(window.location.href = "/", 100000);
                        });//end then;
                }
            }
        });
    }
});
