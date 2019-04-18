$(document).ready(function () {
    $("#signupLink").click(function () {
        $("#signup").show(300, function () {
            $("#signin").hide(300);
        });
    });
    $("#signinLink").click(function () {
        $("#signin").show(300, function () {
            $("#signup").hide(300);
        });
    });
});