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
    <h3>Reset Password</h3>
    Username <br>
    <input required name="txtUsername" type="text" id="txtUsername"> <br>
    Email <br>
    <input required name="txtEmail" type="email" id="txtEmail"> <br>
    New Password <br>
    <input required name="txtnewPassword" pattern="(?=.*[A-Za-z0-9]).{4,16}" title="Please Enter Password 4-16 letters"
           type="password" id="txtnewPassword"> <br>
    Confirm New Password <br>
    <input required name="txtconNewPassword" type="password" id="txtconNewPassword"> <br>
    <div id="divCheckPasswordMatch"></div>
    <input id="btnSubmit" type="submit" name="Submit" value="Reset"> &nbsp;
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnSubmit").click(function () {
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
