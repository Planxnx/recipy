<?php
session_start();
ob_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = checkInput($_POST["txtname"]);
    $description = checkInput($_POST["txtdescription"]);
    $category = checkInput($_POST["ddlcategory"]);
    $ingredient = checkInput($_POST["txtingredient"]);
    $howTo = checkInput($_POST["txthowTo"]);
    $recipeImg = checkInput($_POST["recipeImg"]);

    $strSQL = "INSERT INTO recipe(uid,name,description,category,ingredient,howTo,created_by,logo) VALUES ('" . $_SESSION["uid"] . "','" . $name . "','" . $description . "','" . $category . "','" . $ingredient . "','" . $howTo . "','" . $_SESSION["name"] . "','" . $recipeImg . "')";
    $objQuery = mysqli_query($objCon, $strSQL);
    header("location:../../../recipe.php?recipeId=" . mysqli_insert_id($objCon));
    mysqli_close($objCon);
}
else{
    header("location:../../../index.php");
    mysqli_close($objCon);
}

function checkInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

?> 