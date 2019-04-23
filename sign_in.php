<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="src/img/icon.png" />
    <title>Recipy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./src/css/default.css">
    <link rel="stylesheet" href="./src/css/sign_in.css">
</head>

<body>
<div id="main">
    <div id="signin" class="shadow">
        <div class="form-header">
            <img src="./src//img/logo.png" alt=""> <br>
            <span>Sign in</span>
        </div>
        <form name="form1" id="signinData">
            <div class="form-data">
                <label for="txtUsername">Username</label><br>
                <input required name="txtUsername" type="text" id="txtUsername"><br>
                <label for="txtPassword">Password</label><br>
                <input required name="txtPassword" type="password" id="txtPassword"><br>
                <input type="submit" name="btnSignIn" id="btnSignIn" value="Sign in"> <br>
                <a href="forgetPassword.php">Forgot your password ?</a>
            </div>
        </form>
        <div class="signup-button">
            <a href="#signup" id="signupLink">Don't have an account?</a>
        </div>
    </div>
    <div id="signup">
        <div class="detail-column">
            <div class="detail-header">
                <span>Sign up</span>
            </div>
            <div class="detail-body">
                <p>
                    Recipy is better way to <br> find new ideas.
                </p>
                <p>
                    Make your life a little easier. <br> Join us :)
                </p>
            </div>
            <div class="detail-footer">
                <img src="./src//img/logo.png" alt=""> <br>
            </div>
        </div>
        <div class="form-column">
            <form name="form1" id="userData">
                <div class="form-data">
                    <label for="txtName">Name</label><br>
                    <input required name="txtName" type="text" id="txtName" size="35"><br>
                    <label for="txtUsername">Username</label><br>
                    <input required name="txtUsername" pattern="([A-Z]*)(?=.*[a-z])([0-9]*).{4,12}" type="text"
                           id="txtUsername" size="20">
                    <div class="tooltip" style="font-size: 17px;">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span class="tooltiptext tooltip-right " style="width: 1700%;">
                                username length: 4 - 12 character
                            </span>
                    </div>
                    <br>
                    <label for="txtEmail">Email</label><br>
                    <input required name="txtEmail" pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$"
                           type="email" id="txtEmail" size="35"> <br>
                    <label for="txtNewPassword">Password</label>
                    <br>
                    <input required name="txtNewPassword" type="password" pattern="(?=.*[A-Za-z0-9]).{4,16}"
                           id="txtNewPassword" onChange="checkPasswordMatch();">
                    <div class="tooltip" style="font-size: 17px;">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span class="tooltiptext tooltip-right " style="width: 1700%;">
                                password length: 4 - 16 character
                            </span>
                    </div>
                    <br>
                    <label for="txtConPassword">Repeat Password</label><br>
                    <input required name="txtConPassword" type="password" pattern="(?=.*[A-Za-z0-9]).{4,16}"
                           id="txtConPassword" onChange="checkPasswordMatch();"><br>
                    <input type="submit" name="btnSignUp" id="btnSignUp" value="Sign up">
                    <div class="tooltip" style="font-size: 17px;">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span class="tooltiptext tooltip-right " style="width: 2000%;">
                                Will alert message ,when you don't follow the rules
                            </span>
                    </div>
                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                         
                    </div>
                </div>
            </form>
            <div class="signin-button">
                <a href="#signin" id="signinLink">Do you have a Recipy account?</a>
            </div>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="./src/js/sign_in.js"></script>
</body>

</html>