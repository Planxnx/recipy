<?php
session_start();
ob_start();
include("../../../config.php");
require_once('../../lib/class.upload.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = checkInput($_POST["txtname"]);
    $description = checkInput($_POST["txtdescription"]);
    $category = checkInput($_POST["ddlcategory"]);
    $ingredient = checkInput($_POST["txtingredient"]);
    $howTo = checkInput($_POST["txthowTo"]);
    $upload_image = new upload($_FILES['recipeImg']);
    if ($upload_image->uploaded) {
        $upload_image->file_new_name_body = md5(mt_rand());
        $upload_image->process("images");
        if ($upload_image->processed) {
            $image_name = $upload_image->file_dst_name;
            $upload_image->clean();

            $strSQL = "INSERT INTO recipe(uid,name,description,category,ingredient,howTo,created_by,recipeImg) VALUES ('" . $_SESSION["uid"] . "','" . $name . "','" . $description . "','" . $category . "','" . $ingredient . "','" . $howTo . "','" . $_SESSION["name"] . "','" . $image_name . "')";
            $objQuery = mysqli_query($objCon, $strSQL);
            header("location:../../../recipe.php?recipeId=" . mysqli_insert_id($objCon));
            mysqli_close($objCon);
            exit();
        }else{
            echo "not upload";
            exit();
        }
    } else {
        header("location:../../../index.php");
        mysqli_close($objCon);
        exit();
    }
} else {
    header("location:../../../index.php");
    mysqli_close($objCon);
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

?> 