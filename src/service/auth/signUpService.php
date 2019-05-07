<?php
session_start();
include("../../../config.php");
$_POST["txtUsername"] = mysqli_real_escape_string($objCon, $_POST["txtUsername"]);
$_POST["txtNewPassword"] = mysqli_real_escape_string($objCon, $_POST["txtNewPassword"]);
$_POST["txtName"] = mysqli_real_escape_string($objCon, $_POST["txtName"]);
$_POST["txtEmail"] = mysqli_real_escape_string($objCon, $_POST["txtEmail"]);

$strSQL = "SELECT * FROM user WHERE username = '" . trim($_POST['txtUsername']) . "' ";
$objQuery = mysqli_query($objCon, $strSQL);
$usernameResult = mysqli_fetch_array($objQuery);

$strSQL = "SELECT * FROM user WHERE email = '" . trim($_POST['txtEmail']) . "' ";
$objQuery = mysqli_query($objCon, $strSQL);
$emailResult = mysqli_fetch_array($objQuery);
if ($usernameResult) {
    echo 101;
} else if ($emailResult) {
    echo 102;
} else {
    $sql = "INSERT INTO user(username,password,name,email) VALUES ('" . $_POST["txtUsername"] . "', '" . $_POST["txtNewPassword"] . "','" . $_POST["txtName"] . "','" . $_POST["txtEmail"] . "')";
    $objQuery = mysqli_query($objCon, $sql);
    $_SESSION["uid"] = mysqli_insert_id($objCon);
    $strSQL = "SELECT name FROM user WHERE uid = '" . $_SESSION["uid"] . "' ";
    $objQuery = mysqli_query($objCon, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $_SESSION["name"] = $objResult["name"];
    $_SESSION["role"] = $objResult["role"];

    session_write_close();
    if (isset($_SESSION['currentPage'])) {
        $URL = $_SESSION['currentPage'];
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    } else {
        $URL = "index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
}

mysqli_close($objCon);
?> 