<?php
session_start();
include 'config.php';
$sql = "SELECT * FROM recipe WHERE recipeId =" . $_GET['recipeId'];
$query = mysqli_query($objCon, $sql);
?>
<!DOCTYPE html>
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

            <form class="form-inline" name="searchform" id="searchform">
                <div class="form-group">
                    <input type="text" name="searchText" id="searchText" class="form-control"
                           placeholder="search here"
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
                if ($result = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $result['name']; ?></td>
                        <td><?php echo $result['category']; ?></td>
                        <td><?php echo $result['ingredient']; ?></td>
                        <td><?php echo $result['howTo']; ?></td>
                        <td><?php echo $result['created_by']; ?></td>
                    </tr>
                    <?php $i++;
                }
                ?>
                </tbody>
            </table>
            <img style="width: 50%" src="./src/service/recipe/images/<?php echo $result['recipeImg']; ?>">
            <div id="voteBox">
                <br>
                <span class="glyphicon glyphicon-search"> Vote </span>
                <br>
                <?php
                $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND voteType = 'like';";
                $query = mysqli_query($objCon, $sql);
                $likeCount = mysqli_num_rows($query);
                $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND voteType = 'dislike';";
                $query = mysqli_query($objCon, $sql);
                $dislikeCount = mysqli_num_rows($query);
                ?>
                <span>LIKE: <?php echo $likeCount; ?>  </span>
                <span> DISLIKE: <?php echo $dislikeCount; ?></span>
                <?php
                if (isset($_SESSION["uid"])) {
                    $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND uid = '" . $_SESSION["uid"] . "';";
                    $query = mysqli_query($objCon, $sql);
                    if (!$result = mysqli_fetch_assoc($query)) {
                        $enableVote = true;
                    }
                }
                ?>
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" <?php if (empty($enableVote)) echo "disabled" ?>
                            onclick="voteRecipe('like')" id="voteBtn">
                        <span class="glyphicon glyphicon-search">Like</span>
                    </button>
                    <button type="button" class="btn btn-primary" <?php if (empty($enableVote)) echo "disabled" ?>
                            onclick="voteRecipe('dislike')" id="voteBtn">
                        <span class="glyphicon glyphicon-search">Dislike</span>
                    </button>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#btnSearch").click(function () {
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
    function voteRecipe(data) {
        $.ajax({
            url: "./src/service/recipe/voteService.php",
            type: "POST",
            data: {
                voteType: data,
                recipeId: <?php echo $_GET['recipeId'] ?>,
                uid: <?php echo $_SESSION['uid'] ?>
            },
            success: function (data) {
                $("#voteBox").load(location.href + " #voteBox");
            }
        });
    }

    document.getElementById("btnCreateRecipe").onclick = function () {
        location.href = "create_recipe.php";
    };
</script>
</body>
</html>