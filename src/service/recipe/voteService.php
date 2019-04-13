<?php
session_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strSQL = "INSERT INTO recipe_vote(uid,recipeId,voteType) VALUES ('" . $_POST["uid"] . "','" . $_POST["recipeId"] . "','" . $_POST["voteType"] . "')";
    $objQuery = mysqli_query($objCon, $strSQL);
} else {
    header("location:../../../index.php");
    mysqli_close($objCon);
}

?>