<?php
session_start();
include("../../../config.php");
$_POST['txtUsername'] = mysqli_real_escape_string($objCon, $_POST['txtUsername']);
$_POST['txtPassword'] = mysqli_real_escape_string($objCon, $_POST['txtPassword']);

$sql = "SELECT * FROM user WHERE username ='" . $_POST['txtUsername'] . "' AND password = '" . $_POST['txtPassword'] . "'";
$objQuery = mysqli_query($objCon, $sql);
$objResult = mysqli_fetch_array($objQuery);
if (!$objResult) {
    echo 101;
} else {
    $_SESSION["uid"] = $objResult["uid"];
    $_SESSION["name"] = $objResult["name"];
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