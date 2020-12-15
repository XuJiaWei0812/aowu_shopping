$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $("#shopping-cart").click(function () {
        window.location.href = "/cart/";
    });
    $("#logout").click(function (event) {
        event.preventDefault();
        logout();
    });
    function logout() {
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
