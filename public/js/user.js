$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $("#shopping-cart").click(function () {
        window.location.href = "/cart/";
    });
});
