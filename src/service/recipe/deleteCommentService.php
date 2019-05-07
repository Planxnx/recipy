<?php
session_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["uid"])) {
        echo 102;
        exit();
    }
    if ($_SESSION["uid"] == $_POST["uid"] || $_SESSION["role"] == 'admin') {
        $sql = "DELETE FROM recipe_comment WHERE id = ". $_POST['commentId'];
        if ($objQuery = mysqli_query($objCon, $sql)) {
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