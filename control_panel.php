<?php
session_start();
include 'config.php';
if ($_SESSION["role"] != 'admin') {
    $URL = "index.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

$strSQL = "SELECT * FROM recipe WHERE promote = TRUE";
$objQuery = mysqli_query($objCon, $strSQL);
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="src/img/icon.png"/>
    <title>Recipy: Vote Ranking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./src/css/default.css">
    <link rel="stylesheet" href="./src/css/control_panel.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>

<body>
<div id="content">
    <div id="list-data">
        <div class="rank-container shadow">
            <div class="list-header">
                <span>Recipe Control Panel</span>
            </div>
            <div id="control-list" class="list-rank">
                <div class="box-vote-header">
                    <div class="recipe-number">
                        <span> </span>
                    </div>
                    <div class="recipe-name">
                        <span>Recipe Name</span>
                    </div>
                    <div class="recipe-status">
                        <span>Action</span>
                    </div>
                </div>
                <?php $i = 1;
                while ($value = mysqli_fetch_assoc($objQuery)) { ?>
                    <div class="box-recipe">
                        <div class="recipe-number">
                            <span><?php echo $i; ?></span>
                        </div>
                        <div class="recipe-name">
                            <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
                                <span><?php echo $value['name']; ?></span>
                            </a>
                        </div>
                        <div class="recipe-status">
                            <a style="cursor: pointer"
                               onclick="removePromote(<?php echo $value['recipeId']; ?>)">Remove</a>
                        </div>
                    </div>
                    <?php $i++;
                }
                ?>
            </div>
            <hr>
            <div id="recipe-select">
                <div class="select-header">
                    <span>Select Promote Recipe</span>
                </div>
                <select id="selectRecipe" >
                    <?php
                    $sql = "SELECT * FROM recipe WHERE promote = FALSE ";
                    $objQuery = mysqli_query($objCon, $sql);
                    while ($value = mysqli_fetch_assoc($objQuery)) { ?>
                        <option value="<?php echo $value['recipeId']; ?>"><?php echo $value['recipeId']; ?> : <?php echo $value['name']; ?> </option>
                        <?php
                    }
                    ?>
                </select>
                <button id="submitRecipe" onclick="promoteRecipe()" class="shadow" type="submit">Promote</button>
                <div class="back-button">
                    <a href="index.php">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#btnSearch").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $.ajax({
                url: "./src/service/search/search.php",
                type: "post",
                data: {
                    searchText: $("#selectRecipe").val()
                },
                beforeSend: function () {
                    $(".loading").show();
                    $("#list-data").hide();
                },
                complete: function () {
                    $(".loading").hide();
                    $("#list-data").show();
                },
                success: function (data) {
                    $("#list-data").html(data);
                    console.log("search");
                }
            });
        });
    });
    const promoteRecipe = () => {
        console.log($("#selectRecipe").val())
        $.ajax({
            url: "./src/service/recipe/promoteService.php",
            type: "POST",
            data: {
                recipeId: $("#selectRecipe").val()
            },
            success: function (data) {
                if (data == 400) {
                    alert("Fail to Promote")
                    console.log("status:400")
                } else {
                    $("#list-data").load(location.href + " #list-data");
                    console.log(`message:${data}`)
                }
            }
        });
    }
    const removePromote = (recipeId) => {
        $.ajax({
            url: "./src/service/recipe/removePromoteService.php",
            type: "POST",
            data: {
                recipeId: recipeId
            },
            success: function (data) {
                if (data == 400) {
                    alert("Fail to Remove Promote")
                    console.log("status:400")
                } else {
                    $("#list-data").load(location.href + " #list-data");
                    console.log(`message:${data}`)
                }
            }
        });
    }
</script>
</body>


</html>