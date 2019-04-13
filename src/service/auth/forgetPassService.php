<?php
include("../../../config.php");
$strSQL = "SELECT * FROM user WHERE username =
'".mysqli_real_escape_string($objCon,$_POST['txtUsername'])."'
and email = '".mysqli_real_escape_string($objCon,$_POST['txtEmail'])."'";
$objQuery = mysqli_query($objCon,$strSQL);
$objResult = mysqli_fetch_array($objQuery);

if($objResult){
$strSQL = "UPDATE user SET password = '" .$_POST['txtnewPassword']."' WHERE username = '" .$_POST['txtUsername']."'";
$objQuery = mysqli_query($objCon,$strSQL);
header("location: ../../../signIn.php");
}
else{
    echo 101;
}
?>

