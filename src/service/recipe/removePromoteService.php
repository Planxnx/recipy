<?php
session_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $strSQL = "UPDATE recipe SET promote = FALSE WHERE recipeId = '" . $_POST['recipeId'] . "'";
    if ($objQuery = mysqli_query($objCon, $strSQL)) {
        echo 200;
        exit();
    } else {
        echo 400;
        exit();
    }

} else {
    header("location:../../../index.php");
    mysqli_close($objCon);
}

?>