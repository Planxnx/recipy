<?php
session_start();
include("../../../config.php");
$strSQL = "SELECT * FROM user WHERE username =
'" . mysqli_real_escape_string($objCon, $_POST['txtUsername']) . "'
and password = '" . mysqli_real_escape_string($objCon, $_POST['txtPassword']) . "'";
$objQuery = mysqli_query($objCon, $strSQL);
$objResult = mysqli_fetch_array($objQuery);
if (!$objResult) {
    echo "Username or Password Incorrect!";
} else {
    $_SESSION["UserID"] = $objResult["UserID"];
    $_SESSION["Status"] = $objResult["Status"];
    session_write_close();
    $URL = "mainpage.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
mysqli_close($objCon);
?>