<?php
session_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sqlCheckVote = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_POST['recipeId'] . "' AND uid = '" . $_SESSION['uid'] . "';";
    $query = mysqli_query($objCon, $sqlCheckVote);
    $checkResult = mysqli_fetch_assoc($query);

    if (empty($checkResult)) {
        $strSQL = "INSERT INTO recipe_vote(uid,recipeId,voteType) VALUES ('" . $_SESSION['uid'] . "','" . $_POST["recipeId"] . "','" . $_POST["voteType"] . "')";
        $objQuery = mysqli_query($objCon, $strSQL);
    }else if($checkResult['voteType'] == $_POST["voteType"]){
        $strSQL = "DELETE FROM recipe_vote WHERE id = ". $checkResult['id'];
        $objQuery = mysqli_query($objCon, $strSQL);
    } else if ($checkResult['voteType'] != $_POST["voteType"]) {
        $strSQL = "UPDATE recipe_vote SET voteType = '" . $_POST['voteType'] . "' WHERE recipeId = '" . $_POST['recipeId'] . "'AND uid = '" . $_SESSION['uid'] . "';";
        $objQuery = mysqli_query($objCon, $strSQL);
    }

    $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_POST['recipeId'] . "' AND voteType = 'like';";
    $query = mysqli_query($objCon, $sql);
    $likeCount = mysqli_num_rows($query);
    $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND voteType = 'dislike';";
    $query = mysqli_query($objCon, $sql);
    $dislikeCount = mysqli_num_rows($query);
    $scores = $likeCount - $dislikeCount;
    $updateSql = "UPDATE recipe SET vote_score = " . $scores . " WHERE recipeId = '" . $_GET['recipeId'] . "' ";
    $query = mysqli_query($objCon, $updateSql);
} else {
    header("location:../../../index.php");
    mysqli_close($objCon);
}

?>