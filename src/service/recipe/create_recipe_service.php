<?php
session_start();
ob_start();
include("../../../config.php");
require_once('../../lib/class.upload.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_POST["txtname"] = mysqli_real_escape_string($objCon, $_POST["txtname"]);
    $_POST["txtdescription"] = mysqli_real_escape_string($objCon, $_POST["txtdescription"]);
    $_POST["txthowTo"] = mysqli_real_escape_string($objCon, $_POST["txthowTo"]);
    $txtingredient = $_POST['txtingredient'];
    $txtamount = $_POST['txtamount'];

    $name = checkInput($_POST["txtname"]);
    $description = checkInput($_POST["txtdescription"]);
    $category = checkInput($_POST["ddlcategory"]);
    $ingredient = checkInput($_POST["txtingredient"]);
    $howTo = checkInput($_POST["txthowTo"]);
    $upload_image = new upload($_FILES['recipeImg']);
    if ($upload_image->uploaded) {
        $upload_image->image_resize = true;
        $upload_image->image_ratio_crop = true;
        $upload_image->image_y = 300;
        $upload_image->image_x = 300;
        $upload_image->allowed = array('application/pdf', 'application/msword', 'application/octet-stream', 'image/*');
        $upload_image->file_new_name_body = md5(mt_rand());
        $upload_image->process("images");
        if (true) {
            $image_name = $upload_image->file_dst_name;
            $upload_image->clean();
            $strSQL = "INSERT INTO recipe(uid,name,description,category,howTo,created_by,recipeImg) VALUES ('" . $_SESSION["uid"] . "','" . $name . "','" . $description . "','" . $category . "','" . $howTo . "','" . $_SESSION["name"] . "','" . $image_name . "')";
            $objQuery = mysqli_query($objCon, $strSQL);
            $recipeId = mysqli_insert_id($objCon);
            foreach ($txtingredient as $key => $value) {
                $strSQL = "INSERT INTO recipe_ingredient (recipeId,name,amount) VALUES ('" . $recipeId . "','" . $value . "','" . $txtamount[$key] . "')";
                $objQuery = mysqli_query($objCon, $strSQL);
            }
            header("location:../../../recipe.php?recipeId=" . $recipeId);
            mysqli_close($objCon);
            exit();
        } else {
            echo "upload image fail";
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
    return $data;
}

?> 