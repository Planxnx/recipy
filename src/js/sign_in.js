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

    $(document).ready(function () {
        $("#txtNewPassword, #txtConPassword").keyup(checkPasswordMatch);
    });

});

function checkPasswordMatch() {
    var password = $("#txtNewPassword").val();
    var confirmPassword = $("#txtConPassword").val();
    var conPassword = $("#txtConPassword")[0];
    if (password != confirmPassword) {
        $("#divCheckPasswordMatch").html("Passwords do not match!");
        conPassword.setCustomValidity('Passwords do not match!');
    } else {
        conPassword.setCustomValidity('');
        $("#divCheckPasswordMatch").html("Passwords match.");
    }
}
