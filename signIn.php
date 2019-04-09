<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<h3>Sign In</h3>
<form name="form1" id="userData" >
    <table border="0" style="width: 300px">
        <tbody>
        <tr>
            <td>&nbsp;Username</td>
        </tr>
        <tr>
            <td><input required name="txtUsername" type="text" id="txtUsername"></td>
        </tr>
        <tr>
            <td>&nbsp;Password</td>
        </tr>
        <tr>
            <td><input required name="txtPassword" type="password" id="txtPassword"></td>
        </tr>
        <tr>
            <td><input type="submit" name="Submit" id="btnSignIn" value="submit"> &nbsp;</td>
        </tr>
        </tbody>
    </table>
</form>
<a href="forgetPassword.php">Forget Your password?</a> <br>
<a href="signUp.php">Don't have an account?</a>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btnSignIn").click(function () {
            var valid = this.form.checkValidity();
            if (valid) {
                event.preventDefault();
                $.ajax({
                    url: "./src/service/auth/signInService.php",
                    type: "post",
                    data: $("#userData").serialize(),
                    success: function (data) {
                        if (data == 101) {
                            alert("Username or Password Incorrect!");
                        } else {
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