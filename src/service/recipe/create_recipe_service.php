<?php
ob_start();
include("../../../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = checkInput($_POST["txtname"]);
    $description = checkInput($_POST["txtdescription"]);
    $category = checkInput($_POST["ddlcategory"]);
    $ingredient = checkInput($_POST["txtingredient"]);
    $howTo = checkInput($_POST["txthowTo"]);
    $recipeImg = checkInput($_POST["recipeImg"]);

    $strSQL = "INSERT INTO recipe(name,description,category,ingredient,howTo,logo) VALUES ('" . $name . "','" . $description . "','" . $category . "','" . $ingredient . "','" . $howTo . "','" . $recipeImg . "')";
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
    $data = htmlspecialchars($data);
    return $data;
}

?> 