<?php
session_start();
if (!isset($_SESSION["uid"])) {
    $URL = "sign_in.php";
    echo "<script type='text/javascript'> alert('Please SignIn to Create new Recipe') </script>";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="src/img/icon.png"/>
    <title>Recipy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./src/css/default.css">
    <link rel="stylesheet" href="./src/css/index.css">
    <link rel="stylesheet" href="./src/css/create_recipe.css">
    <script src="https://cdn.jsdelivr.net/npm/mobile-detect@1.4.3/mobile-detect.min.js"></script>
    <script src="./src/js/display_check.js"></script>
</head>

<body>
<div class="topNav shadow">
    <div class="homeButton">
        <a href="index.php"> <img style="width: 80%" src="src/img/logo.png"></a>
    </div>
    <div class="topButton">
        <?php
        if (isset($_SESSION["uid"])) {
        ?>
        <div class="profile-btn">
            <?php
            echo "คุณ " . $_SESSION["name"];
            echo " &nbsp&nbsp&nbsp";
            ?>
            <br>
            <a href="./editProfile.php">Edit Profile</a><br>
            <a href="./src/service/auth/signOutService.php">Sign out</a>
            <?php
            } else {
            ?>
            <div class="profile-btn" style="margin-top: 0;">
                <button class="shadow" onclick="window.location.href = './sign_in.php';">Sign In</button> <?php
                }
                ?>
            </div>
            <button class="shadow" onclick="window.location.href = './create_recipe.php';">Create new Recipe</button>
            <button class="shadow" onclick="window.location.href = './ranking.php';">Vote Ranking</button>
        </div>
        <div class="search-container">
            <form id="searchform">
                <input style="float:left" type="text" name="searchText" id="searchText"
                       placeholder="search recipe here">
                <button type="submit" id="btnSearch"><i class="fa fa-search"></i></button>
                <div class="tooltip tooltip-icon">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <span class="tooltiptext tooltip-right " style="width: 800%;">
                        try Intelligent Search <br>
                        Ex. Ingredient / Recipe Name / How to
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="content">
    <div id="list-data">
    </div>
    <div id="create-data" class="form-box shadow">
        <div class="form-header">
            <span>Create new recipe</span>
        </div>
        <form id="form1" enctype="multipart/form-data" method="POST"
              action="./src/service/recipe/create_recipe_service.php">
            <label for="txtname">Recipe Name</label><br>
            <input name="txtname" type="text" id="txtname" required><br>
            <label for="recipeImg">Food Image</label>
            <div class="tooltip" style="font-size: 17px;">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span class="tooltiptext tooltip-right " style="width: 1600%;">
                        Image size limit: less than 2 Mb   and Landscape Recommend
                    </span>
            </div>
            <br>
            <input required type="file" name="recipeImg"><br>
            <label for="ddlcategory">Category of Recipe</label><br>
            <select required name="ddlcategory" id="ddlcategory">
                <option value="Everyday">Everyday</option>
                <option value="Quick & Easy">Quick & Easy</option>
                <option value="Healthy">Healthy</option>
                <option value="Dessert">Dessert</option>
                <option value="Cake & Baking">Cake & Baking</option>
                <option value="Drinks">Drinks</option>
            </select><br>
            <label for="txtdescription">Description</label><br>
            <textarea required name="txtdescription" id="txtdescription" cols="30" rows="3"></textarea><br>
            <label for="txtingredient">Ingredient</label>
            <div class="tooltip" style="font-size: 17px;">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span class="tooltiptext tooltip-right " style="width: 1600%;">
                        Click button for add new input box ( maximum 16 fields allowed)
                    </span>
            </div>
            <br>
            <!--            <textarea required name="txtingredient" id="txtingredient" cols="30" rows="10"></textarea><br>-->
            <div class="input_fields_wrap">
                <input required type="text" name="txtingredient[]" placeholder="name Ex. Chicken ">
                <input required type="text" name="txtamount[]" placeholder="amount Ex. 2.1 Kg ">
                <input required type="text" name="txtingredient[]" placeholder="name Ex. Sugar ">
                <input required type="text" name="txtamount[]" placeholder="amount Ex. 2 tsp ">
            </div>
            <button type="button" id="addField" class="addField shadow" style="float: left;font-size: 13px;padding:0;margin-top: 1%;">  add more Ingredient 
            </button>
            <br>
            <label for="txthowTo">How to</label>
            <div class="tooltip" style="font-size: 17px;">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span class="tooltiptext tooltip-right " style="width: 1600%;">
                        Shift + Enter for Line Break
                    </span>
            </div>
            <br>
            <textarea required name="txthowTo" id="txthowTo" cols="30" rows="10"></textarea><br>
            <button id="submitForm" class="shadow" type="submit">Create</button>
        </form>
    </div>
</div>
<script src="./src/js/jquery-3.4.0.min.js"></script>
<script>
    var max_fields = 14;
    var x = 0;
    $(document).ready(function () {
        $('#searchform').on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                url: "./src/service/search/search.php",
                type: "post",
                data: {searchText: $("#searchText").val()},
                beforeSend: function () {
                    $("#list-data").hide();
                },
                complete: function () {
                    $("#create-data").hide();
                    $("#list-data").show();
                },
                success: function (data) {
                    $("#list-data").html(data);
                    console.log("search");
                }
            });
        });

        $("#addField").on("click", function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(".input_fields_wrap").append('<div><input required type="text" name="txtingredient[]" placeholder="name"> <input required type="text" name="txtamount[]" placeholder="amount"> <a href="#" class="remove_field">&#10006;</a></div>');
            }
        });
        $(".input_fields_wrap").on("click", ".remove_field", function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
</script>
</body>

</html>