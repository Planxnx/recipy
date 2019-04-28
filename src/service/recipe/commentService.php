<?php
session_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["uid"])) {
        echo 102;
        exit();
    }
    if (strlen($_POST['txtComment']) < 155 && strlen($_POST['txtComment']) > 1) {
        date_default_timezone_set('Asia/Bangkok');
        $timestamp = time();
        $date = date("F d, Y h:i:s A", $timestamp);
        $strSQL = "INSERT INTO recipe_comment(uid,recipeId,comment,comment_date,name) VALUES ('" . $_SESSION['uid'] . "','" . $_POST["recipeId"] . "','" . $_POST["txtComment"] . "','" . $date . "','" . $_SESSION['name'] . "')";
        if ($objQuery = mysqli_query($objCon, $strSQL)) {
            echo 200;
            exit();
        } else {
            echo 400;
            exit();

        }
    } else {
        echo 101;
        exit();
    }
} else {
    header("location:../../../index.php");
    mysqli_close($objCon);
}

?>