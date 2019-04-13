<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function checkPasswordMatch() {
            var password = $("#txtPassword").val();
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

        $(document).ready(function () {
            $("#txtPassword, #txtConPassword").keyup(checkPasswordMatch);
        });
    </script>

</head>
<body>
<div id="signUpForm">
    <form name="form1" id="userData">
        Sign Up <br>
        <table border="0" style="width: 300px">
            <tbody>
            <tr>
                <td>Name</td>
            </tr>
            <tr>
                <td><input required name="txtName" type="text" id="txtName" size="35"></td>
            </tr>
            <tr>
                <td>&nbsp;Username</td>
            </tr>
            <tr>
                <td><input required name="txtUsername" pattern="([A-Z]*)(?=.*[a-z])([0-9]*).{4,8}" type="text"
                           title="Please Enter Username" id="txtUsername"
                           size="20">
                </td>
            </tr>
            <tr>
                <td>&nbsp;Password</td>
            </tr>
            <tr>
                <td><input required name="txtPassword" pattern="(?=.*[A-Za-z0-9]).{4,16}" title="Please Enter Password"
                           type="password" id="txtPassword">
                </td>
            </tr>
            <tr>
                <td>&nbsp;Confirm Password</td>
            </tr>
            <tr>
                <td>
                    <input required name="txtConPassword" type="password" id="txtConPassword"
                           onChange="checkPasswordMatch();"></td>
            </tr>
            <tr>
                <td>&nbsp;Email</td>
            </tr>
            <tr>
                <td><input required name="txtEmail" pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$"
                           type="email" id="txtEmail" size="35"></td>
            </tr>
            </tbody>
        </table>
        <div class="registrationFormAlert" id="divCheckPasswordMatch">
        </div>
        <input type="submit" name="Submit" value="submit" id="btnSignUp"> &nbsp; or <a href="signIn.php">&nbsp;Sign
            In</a>
    </form>
    <script type="text/javascript">
        $(document).ready(function () {
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
                            } else {
                                $("#userData").html(data);
                            }
                        }
                    });
                }
            });
        });
    </script>
</div>
</body>
</html> 