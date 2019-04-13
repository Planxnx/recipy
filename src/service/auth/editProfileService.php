<?php
session_start();
include("../../../config.php");
$strSQL = "SELECT * FROM user WHERE password = '" . $_POST["txtPassword"] . "' AND uid = '" . $_SESSION["uid"] . "' ";
$objQuery = mysqli_query($objCon, $strSQL);
$result = mysqli_fetch_array($objQuery);
if (!isset($result)) {
    echo 101;
} else {
    $strSQL = "UPDATE user SET password = '" . $_POST['txtnewPassword'] . "' WHERE uid = '" . $_SESSION["uid"] . "'";
    $objQuery = mysqli_query($objCon, $strSQL);
    header("location: ../../../index.php");
}
?>