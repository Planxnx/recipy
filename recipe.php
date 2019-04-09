<!DOCTYPE html>
<?php
include 'config.php';
$sql = "SELECT * FROM recipe WHERE recipeId =" . $_GET['recipeId'];
$query = mysqli_query($objCon, $sql);
session_start()
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/ico" href="src/img/icon.png"/>
    <title>Recipy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            margin-top: 20px;
        }

        .loading {
            background-image: url("src/img/logo.png");
            background-repeat: no-repeat;
            display: none;
            height: 100px;
            width: 100px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div id="top">
            <a href="index.php"> <img style="width: 15%" src="src/img/logo.png"></a>
            <?php
            if (isset($_SESSION["uid"])) {
                ?>
                <div align="right">

                    <?php

                    echo "คุณ " . $_SESSION["name"];
                    echo " &nbsp&nbsp&nbsp";
                    ?>
                    <a href="./src/service/auth/signOutService.php">
                        <button type="button" class="btn btn-primary" id="btnCreateRecipe">
                            <span class="glyphicon glyphicon-search">Sign out</span>
                        </button>
                    </a>
                </div> <?php
            } else {
                ?>
                <div align="right">
                    <a href="./signIn.php">
                        <button type="button" class="btn btn-primary" id="btnCreateRecipe">
                            <span class="glyphicon glyphicon-search">Sign in</span>
                        </button>
                    </a>
                </div> <?php
            }
            ?>
            <div align="right">
                <a href="create_recipe.php">
                    <button type="button" class="btn btn-primary" id="btnCreateRecipe">
                        <span class="glyphicon glyphicon-search"></span>
                        Create new Recipe
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="loading" style="margin-top: 1.5%">
        <h4>waiting</h4>
    </div>
    <div class="row" id="list-data" style="margin-top: 10px;">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <th>Recipe</th>
                <tr>
                    <th>name</th>
                    <th width="5%">category</th>
                    <th>ingredient</th>
                    <th>how to</th>
                    <th>create by</th>

                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                while ($result = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $result['name']; ?></td>
                        <td><?php echo $result['category']; ?></td>
                        <td><?php echo $result['ingredient']; ?></td>
                        <td><?php echo $result['howTo']; ?></td>
                        <td><?php echo $result['created_by']; ?></td>

                    </tr>
                    <?php $i++;
                    if ($i > 8) break;
                }
                mysqli_close($objCon);
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#btnSearch").click(function () {
            console.log("Click");
            $.ajax({
                url: "./src/service/search/search.php",
                type: "post",
                data: {searchText: $("#searchText").val()},
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
                }
            });
        });
        $("#searchform").on("keyup keypress", function (e) {
            var code = e.keycode || e.which;
            if (code == 13) {
                $("#btnSearch").click();
                return false;
            }
        });
    });
    document.getElementById("btnCreateRecipe").onclick = function () {
        location.href = "create_recipe.php";
    };
</script>
</body>
</html>