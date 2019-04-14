<?php
include("../../../config.php");
session_start();

$_POST["txtUsername"] = mysqli_real_escape_string($objCon, $_POST["txtUsername"]);
$_POST["txtPassword"] = mysqli_real_escape_string($objCon, $_POST["txtPassword"]);
$_POST["txtName"] = mysqli_real_escape_string($objCon, $_POST["txtName"]);
$_POST["txtEmail"] = mysqli_real_escape_string($objCon, $_POST["txtEmail"]);

$strSQL = "SELECT * FROM user WHERE username = '" . trim($_POST['txtUsername']) . "' ";
$objQuery = mysqli_query($objCon, $strSQL);
$objResult = mysqli_fetch_array($objQuery);
if ($objResult) {
    echo 101;
} else {
    $strSQL = "INSERT INTO user(username,password,name,email) VALUES ('" . $_POST["txtUsername"] . "',
  '" . $_POST["txtPassword"] . "','" . $_POST["txtName"] . "','" . $_POST["txtEmail"] . "')";
    $objQuery = mysqli_query($objCon, $strSQL);
    $_SESSION["uid"] = mysqli_insert_id($objCon);
    $strSQL = "SELECT name FROM user WHERE uid = '" . $_SESSION["uid"] . "' ";
    $objQuery = mysqli_query($objCon, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $_SESSION["name"] = $objResult["name"];

    session_write_close();
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

mysqli_close($objCon);
?> 