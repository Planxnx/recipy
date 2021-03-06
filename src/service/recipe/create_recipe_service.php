<?php
session_start();
ob_start();
include("../../../config.php");
require_once('../../lib/class.upload.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_POST["txtname"] = mysqli_real_escape_string($objCon, $_POST["txtname"]);
    $_POST["txtdescription"] = mysqli_real_escape_string($objCon, $_POST["txtdescription"]);
    $_POST["txthowTo"] = mysqli_real_escape_string($objCon, $_POST["txthowTo"]);
    $_POST["tag_name"] = mysqli_real_escape_string($objCon, $_POST["tag_name"]);

    $name = checkInput($_POST["txtname"]);
    $description = checkInput($_POST["txtdescription"]);
    $category = checkInput($_POST["ddlcategory"]);
    $howTo = checkInput($_POST["txthowTo"]);
    $upload_image = new upload($_FILES['recipeImg']);
    $txtingredient = $_POST['txtingredient'];
    $txtamount = $_POST['txtamount'];
    $tag_name =  explode(" ", trim($_POST["tag_name"]));

    if ($upload_image->uploaded) {
        $upload_image->image_resize = true;
        $upload_image->image_y = 300;
        $upload_image->image_x = 300;
        $upload_image->image_ratio_crop = true;
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
            foreach ($tag_name as $key => $value) {
                $strSQL = "INSERT INTO recipe_tag (recipeId,name) VALUES ('" . $recipeId . "','" . $value . "')";
                $objQuery = mysqli_query($objCon, $strSQL);
            }
            if ($recipeId) {
                header("location:../../../recipe.php?recipeId=" . $recipeId);
                mysqli_close($objCon);
                exit();
            } else {
                $URL = "../../../index.php";
                mysqli_close($objCon);
                echo "<script type='text/javascript'>alert('Fail to Create Recipe');</script>";
                echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            }

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