<?php
session_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strlen($_POST['recipeId']) < 155) {
        $timestamp = time();
        $date = date("F d, Y h:i:s A", $timestamp);
        $strSQL = "INSERT INTO recipe_comment(uid,recipeId,comment,comment_date,name) VALUES ('" . $_POST["uid"] . "','" . $_POST["recipeId"] . "','" . $_POST["txtComment"] . "','" . $date . "','" . $_POST["name"] . "')";
        if ($objQuery = mysqli_query($objCon, $strSQL)){
            echo 200;
        }else {
            echo 400;
        }
    }else{
        echo 101;
    }
} else {
    header("location:../../../index.php");
    mysqli_close($objCon);
}

?>