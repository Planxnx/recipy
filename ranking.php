<?php
session_start();
include 'config.php';
$sql = "SELECT * FROM recipe ORDER BY vote_score DESC";
$query = mysqli_query($objCon, $sql);
$_SESSION['currentPage'] = $_SERVER['REQUEST_URI'];
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
    <link rel="stylesheet" href="./src/css/index.css">
    <link rel="stylesheet" href="./src/css/ranking.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
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
            <button class="shadow" onclick="window.location.href = './create_recipe.php';">Create new
                Recipe
            </button>
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
        <div class="rank-container shadow">
            <div class="list-header">
                <div class="tooltip tooltip-icon">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <span class="tooltiptext tooltip-left " style="width: 800%;">
                            Calculate score from Like - Dislike
                        </span>
                </div>
                <span>Top 10 Highest Vote Score</span>
            </div>
            <div class="list-rank">
                <div class="box-vote-header">
                    <div class="vote-number">
                        <span>Ranks</span>
                    </div>
                    <div class="vote-name">
                        <span>Recipe Name</span>
                    </div>
                    <div class="vote-score">
                        <span>Score</span>
                    </div>
                </div>
                <?php $i = 1;
                while ($value = mysqli_fetch_assoc($query)) { ?>
                    <div class="box-vote">
                        <div class="vote-number">
                            <span><?php echo $i; ?></span>
                        </div>
                        <div class="vote-name">
                            <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
                                <span><?php echo $value['name']; ?></span>
                            </a>
                        </div>
                        <div class="vote-score">
                            <span><?php echo $value['vote_score']; ?></span>
                        </div>
                    </div>
                    <?php $i++;
                    if ($i > 10) break;
                }
                mysqli_close($objCon);
                ?>
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
                    searchText: $("#searchText").val()
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
</script>
</body>


</html>