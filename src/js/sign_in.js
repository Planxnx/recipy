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

    $("#btnSignIn").click(function () {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            $.ajax({
                url: "./src/service/auth/signInService.php",
                type: "post",
                data: $("#signinData").serialize(),
                success: function (data) {
                    if (data == 101) {
                        alert("Username or Password Incorrect!");
                    } else {
                        $("#signinData").html(data);
                    }
                }
            });
        }
    });
    $("#btnSignUp").click(function () {
        var valid = this.form.checkValidity();
        if (valid) {
            event.preventDefault();
            $.ajax({
                url: "./src/service/auth/signUpService.php",
                type: "post",
                data: $("#userData").serialize(),
                success: function (data) {
                    if (data == 101) {
                        alert("Username already exists");
                    } else if (data == 102) {
                        alert("Email already exists");
                    } else {
                        $("#userData").html(data);
                    }
                }
            });
        }
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
