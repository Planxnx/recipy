<?php
session_start();
include("./config.php");
if (!isset($_SESSION["uid"])) {
    $URL = "sign_in.php";
    echo "<script type='text/javascript'> alert('Please SignIn') </script>";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

$strSQL = "SELECT * FROM user WHERE uid = '" . trim($_SESSION["uid"]) . "' ";
$objQuery = mysqli_query($objCon, $strSQL);
$userResult = mysqli_fetch_array($objQuery);

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="src/img/icon.png"/>
    <title>Recipy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./src/css/default.css">
    <link rel="stylesheet" href="./src/css/edit_profile.css">
    <script src="./src/js/jquery-3.4.0.min.js"></script>
</head>
<body>
<div id="main">
    <div id="edit">
        <div class="detail-column">
            <div class="detail-header">
                <span>Your Profile</span>
            </div>
            <div class="detail-body">
                <span>Name : </span> <span style="float:right;"> <?php echo $userResult['name']; ?> </span> <br>
                <span>Email :</span> <span style="float:right;"> <?php echo $userResult['email']; ?> </span> <br>
            </div>
            <div class="detail-footer">
                <img src="./src//img/logo.png" alt=""> <br>
            </div>
        </div>
        <div class="form-column">
            <div class="form-header">
                <span>Reset Your Password</span>
            </div>
            <form name="form1" id="userData">
                <div class="form-data">
                    <label for="txtPassword">Your Password</label><br>
                    <input required name="txtPassword" type="password" id="txtPassword"><br>
                    <label for="txtnewPassword">New Password</label><br>
                    <input required name="txtnewPassword" type="password" pattern="(?=.*[A-Za-z0-9]).{4,16}"
                           id="txtnewPassword" onChange="checkPasswordMatch();"><br>
                    <label for="txtConPassword">Repeat Password</label><br>
                    <input required name="txtConPassword" type="password" pattern="(?=.*[A-Za-z0-9]).{4,16}"
                           id="txtConPassword" onChange="checkPasswordMatch();"><br>
                    <input type="submit" name="btnConfirm" id="btnConfirm" value="Confirm">
                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                    </div>
                </div>
            </form>
            <div class="back-button">
                <a href="index.php">Back</a>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
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