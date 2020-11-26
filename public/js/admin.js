$(document).ready(function () {
    //addProductModel上傳照片
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
    //addProductModel上傳照片

    //addProductModel新增商品表單
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $("html").click(function () {
        $("#validatorMsg").find("ul").html('');
        $("#validatorMsg").css('display', 'none');
    });
    $("#addProductForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        // console.log(formData.getAll('upload'));
        addProduct(formData)
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
                    validatorMsg(data, "ok")
                } else {
                    validatorMsg(data, "no")
                }
            }
        });
    }
    function validatorMsg(msg, type) {
        $("#validatorMsg").find("ul").html('');
        $("#validatorMsg").css('display', 'block');
        if (type == "ok") {
            $("#validatorMsg").attr('class','alert alert-success');
            $("#validatorMsg").html(msg.success);
            window.setTimeout(window.location.href = "/admin", 5000);
        } else {
            $("#validatorMsg").attr('class','alert alert-danger');
            $("#validatorMsg").html(msg.error);
        }
    }
    //addProductModel新增商品表單
});
