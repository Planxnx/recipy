<?php
session_start();
if (!isset($_SESSION["uid"])) {
    $URL = "sign_in.php";
    echo "<script type='text/javascript'> alert('Please SignIn') </script>";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function checkPasswordMatch() {
            var password = $("#txtnewPassword").val();
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
    </script>
</head>
<body>
<form id="userData">
    Edit Profile <br>
    Your Password <br>
    <input required name="txtPassword" pattern="(?=.*[A-Za-z0-9]).{4,16}" title="Please Enter Password" type="password"
           id="txtPassword"> <br>
    New Password <br>
    <input required name="txtnewPassword" pattern="(?=.*[A-Za-z0-9]).{4,16}" title="Please Enter Password"
           type="password" id="txtnewPassword"> <br>
    Comfirm New Password <br>
    <input required name="txtconNewPassword" pattern="(?=.*[A-Za-z0-9]).{4,16}" title="Please Enter Password"
           type="password" id="txtconNewPassword"> <br>
    <input id="btnSubmit" type="submit" name="Submit" value="Reset"> &nbsp;
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnSubmit").click(function () {
            var valid = this.form.checkValidity();
            if (valid) {
                event.preventDefault();
                $.ajax({
                    url: "./src/service/auth/editProfileService.php",
                    type: "post",
                    data: $("#userData").serialize(),
                    success: function (data) {
                        if (data == 101) {
                            alert("Your Old Password Incorrect");
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