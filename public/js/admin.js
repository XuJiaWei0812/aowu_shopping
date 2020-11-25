$(document).ready(function () {
    //addProductModel 上傳照片
    $("#upload").change(function () {
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
    //addProductModel 上傳照片
});
