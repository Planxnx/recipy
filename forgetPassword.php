<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="src/img/icon.png" />
    <title>Recipy</title>
    <script src="https://cdn.jsdelivr.net/npm/mobile-detect@1.4.3/mobile-detect.min.js"></script>
    <script src="./src/js/display_check.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./src/css/default.css">
    <link rel="stylesheet" href="./src/css//forget_password.css">
</head>
<body>
<div id="main">
    <div id="forget" class="shadow">
        <div class="form-header">
            <img src="./src//img/logo.png" alt=""> <br>
            <span>Forget Password</span>
        </div>
        <form name="form1" id="userData">
            <div class="form-data">
                <label for="txtUsername">Username</label><br>
                <input required name="txtUsername" type="text" id="txtUsername"><br>
                <label for="txtEmail">Email</label><br>
                <input required name="txtEmail" pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$"
                       type="email" id="txtEmail" size="35"> <br>
                <label for="txtNewPassword">New Password</label><br>
                <input required name="txtNewPassword" type="password" pattern="(?=.*[A-Za-z0-9]).{4,16}"
                       id="txtNewPassword" onChange="checkPasswordMatch();"><br>
                <label for="txtconNewPassword">Repeat Password</label><br>
                <input required name="txtconNewPassword" type="password" pattern="(?=.*[A-Za-z0-9]).{4,16}"
                       id="txtconNewPassword" onChange="checkPasswordMatch();"><br>
                <input type="submit" name="btnConfirm" id="btnConfirm" value="Confirm"> <br>
            </div>
        </form>
        <div class="signup-button">
            <a href="sign_in.php">Back</a>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    function checkPasswordMatch() {
        var password = $("#txtNewPassword").val();
        var confirmPassword = $("#txtconNewPassword").val();
        var conPassword = $("#txtconNewPassword")[0];

        if (password != confirmPassword) {
            $("#divCheckPasswordMatch").html("Passwords do not match!");
            conPassword.setCustomValidity('Passwords do not match!');
        } else {
            conPassword.setCustomValidity('');
            $("#divCheckPasswordMatch").html("Passwords match.");
        }
    }

    $(document).ready(function () {
        $("#txtnewPassword, #txtconNewPassword").keyup(checkPasswordMatch);
    });
    $(document).ready(function () {
        $("#btnConfirm").click(function () {
            var valid = this.form.checkValidity();
            if (valid) {
                event.preventDefault();
                $.ajax({
                    url: "./src/service/auth/forgetPassService.php",
                    type: "post",
                    data: $("#userData").serialize(),
                    success: function (data) {
                        if (data == 101) {
                            alert("Username or Email Incorrect");
                        } else {
                            alert("Your password has been changed successfully");
                            $("#userData").html(data);
                        }
                    }
                });
            }
        });
    });
</script>
</body>

</html>
