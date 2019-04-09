<?php
include("../../../config.php");
else {
    $strSQL = "SELECT * FROM user WHERE username = '" . trim($_POST['txtUsername']) . "' ";
    $objQuery = mysqli_query($objCon, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    if ($objResult) {
        echo 101;
    } else {
        $strSQL = "INSERT INTO user(username,password,name,email) VALUES ('" . $_POST["txtUsername"] . "',
  '" . $_POST["txtPassword"] . "','" . $_POST["txtName"] . "','" . $_POST["txtEmail"] . "')";
        $objQuery = mysqli_query($objCon, $strSQL);
        $_SESSION["uid"] = $objResult["uid"];
        session_write_close();
        $URL = "index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
}
mysqli_close($objCon);
?> 