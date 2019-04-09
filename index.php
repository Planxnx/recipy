<!DOCTYPE html>
<?php
include 'config.php';
$sql = "SELECT * FROM recipe ORDER BY RAND() ";
$query = mysqli_query($objCon, $sql);
session_start();
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
        <div class="col-md-12">
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
            <form class="form-inline" name="searchform" id="searchform">
                <div class="form-group">
                    <input type="text" name="searchText" id="searchText" class="form-control" placeholder="search here"
                           autocomplete="off">
                </div>
                <button type="button" class="btn btn-primary" id="btnSearch">
                    <span class="glyphicon glyphicon-search"></span>
                    Search
                </button>
            </form>
        </div>
    </div>
    <div class="loading" style="margin-top: 1.5%">
        <h4>waiting</h4>
    </div>
    <div class="row" id="list-data" style="margin-top: 10px;">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <th>Random Recipe</th>
                <tr>
                    <th></th>
                    <th>name</th>
                    <th>category</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                while ($value = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>"><?php echo $value['name']; ?></a>
                        </td>
                        <td><?php echo $value['category']; ?></td>
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
</script>
</body>
</html>