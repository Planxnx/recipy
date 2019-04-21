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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="src/img/icon.png"/>
    <title>Recipy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./src/css/default.css">
    <link rel="stylesheet" href="./src/css/recipe.css">

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
                <button class="shadow" onclick="window.location.href = './signIn.php';">Sign In</button> <?php
                }
                ?>
            </div>
            <button class="shadow" onclick="window.location.href = './create_recipe.php';">Create new Recipe</button>
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
        <div class="column-info">
            <?php
            if ($resultRecipe = mysqli_fetch_assoc($query)) {
            ?>
            <img class="shadow" src="./src/service/recipe/images/<?php echo $resultRecipe['recipeImg']; ?>">
            <span class="data-detail"><?php echo $resultRecipe['name']; ?>ู</span> <br>
            <span class="data-detail"><?php echo $resultRecipe['category']; ?></span> <br>
            <span class="data-detail"><?php echo $resultRecipe['created_by']; ?></span><br>
            <p>
                <?php echo nl2br($resultRecipe['description']); ?>
            </p>
            <div class="data-vote">
                <?php
                $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND voteType = 'like';";
                $query = mysqli_query($objCon, $sql);
                $likeCount = mysqli_num_rows($query);
                $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND voteType = 'dislike';";
                $query = mysqli_query($objCon, $sql);
                $dislikeCount = mysqli_num_rows($query);
                if (isset($_SESSION["uid"])) {
                    $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND uid = '" . $_SESSION["uid"] . "';";
                    $query = mysqli_query($objCon, $sql);
                    if (!$result = mysqli_fetch_assoc($query)) {
                        $enableVote = true;
                    }
                }
                ?>
                <button <?php if (empty($enableVote)) echo "disabled" ?> type="button" class="shadow">
                    <span>LIKE :  <?php echo $likeCount; ?></span>
                </button>
                <button <?php if (empty($enableVote)) echo "disabled" ?> type="button" class="shadow">
                    <span>DISLIKE : <?php echo $dislikeCount; ?></span>
                </button>
            </div>
        </div>
        <div class="column-detail shadow">
            <div class="data-ingredient">
                <span class="data-header">Ingredient</span>
                <p>
                    <?php echo nl2br($resultRecipe['ingredient']); ?>
                </p>
            </div>
            <div class="data-how">
                <span class="data-header">How to</span>
                <p>
                    <?php echo nl2br($resultRecipe['howTo']); ?>
                </p>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(function () {
        $("#btnSearch").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
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
                    console.log("search");
                }
            });
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
</script>
</body>
</html>