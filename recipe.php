<?php
session_start();
include 'config.php';
$sql = "SELECT * FROM recipe WHERE recipeId =" . $_GET['recipeId'];
$query = mysqli_query($objCon, $sql);
$resultRecipe = mysqli_fetch_assoc($query)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="src/img/icon.png"/>
    <title>Recipy: <?php echo $resultRecipe['name']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./src/css/default.css">
    <link rel="stylesheet" href="./src/css/index.css">
    <link rel="stylesheet" href="./src/css/recipe.css">
    <script src="./src/js/jquery-3.4.0.min.js"></script>
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
        <div class="column-info">
            <?php
            if ($resultRecipe) {
            ?>
            <img class="shadow" src="./src/service/recipe/images/<?php echo $resultRecipe['recipeImg']; ?>">
            <span class="data-detail"><?php echo $resultRecipe['name']; ?></span> <br>
            <span class="data-detail"><?php echo $resultRecipe['category']; ?></span> <br>
            <span class="data-detail">by <?php echo $resultRecipe['created_by']; ?></span><br>
            <p>
                <?php echo nl2br($resultRecipe['description']); ?>
            </p>
            <div class="data-vote" id="data-vote">
                <?php
                $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND voteType = 'like';";
                $query = mysqli_query($objCon, $sql);
                $likeCount = mysqli_num_rows($query);
                $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND voteType = 'dislike';";
                $query = mysqli_query($objCon, $sql);
                $dislikeCount = mysqli_num_rows($query);
                $scores = $likeCount - $dislikeCount;
                $updateSql = "UPDATE recipe SET vote_score = " . $scores . " WHERE recipeId = '" . $_GET['recipeId'] . "' ";
                $query = mysqli_query($objCon, $updateSql);
                if (isset($_SESSION["uid"])) {
                    $sql = "SELECT * FROM recipe_vote WHERE recipeId = '" . $_GET['recipeId'] . "' AND uid = '" . $_SESSION["uid"] . "';";
                    $query = mysqli_query($objCon, $sql);
                    if (!$result = mysqli_fetch_assoc($query)) {
                        $enableVote = true;
                    }
                }
                ?>
                <button <?php if (empty($enableVote)) echo "disabled" ?> type="button" onclick="voteRecipe('like')"
                                                                         class="shadow">
                    <span>LIKE :  <?php echo $likeCount; ?></span>
                </button>
                <button <?php if (empty($enableVote)) echo "disabled" ?> type="button" onclick="voteRecipe('dislike')"
                                                                         class="shadow">
                    <span>DISLIKE : <?php echo $dislikeCount; ?></span>
                </button>
            </div>
        </div>
        <div class="column-detail">
            <div class="detail-recipe shadow">
                <div class="data-ingredient">
                    <span class="data-header">Ingredient</span>
                    <div class="list-ingredient">
                        <div class="ingredient-header">
                            <div class="ingredient-number"> </div>
                            <div class="ingredient-left">Name</div>
                            <div class="ingredient-right">Amount</div>
                        </div>
                        <?php
                        $sql = "SELECT * FROM recipe_ingredient WHERE recipeId =" . $_GET['recipeId'];
                        $query = mysqli_query($objCon, $sql);
                        $i = 1;
                        while ($resultIngredient = mysqli_fetch_assoc($query)) {
                            ?>
                            <div class="ingredient-item">
                                <div class="ingredient-number"><span><?php echo $i; ?></span></div>
                                <div class="ingredient-left"><?php echo $resultIngredient['name']; ?></div>
                                <div class="ingredient-right"><?php echo $resultIngredient['amount']; ?></div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
                <div class="data-how">
                    <span class="data-header">How to</span>
                    <p>
                        <?php echo nl2br($resultRecipe['howTo']); ?>
                    </p>
                </div>
            </div>
            <div id="comment-recipe" class="comment-recipe shadow">
                <span class="data-header">Comments</span>
                <div id="list-comment">
                    <?php
                    $sqlComment = "SELECT * FROM recipe_comment WHERE recipeId =" . $_GET['recipeId'];
                    $queryComment = mysqli_query($objCon, $sqlComment);
                    while ($resultComment = mysqli_fetch_assoc($queryComment)) {
                        ?>
                        <div class="comment-box">
                            <div class="comment-info">
                                <img src="./src/img/profile-icon.png" alt="">
                            </div>
                            <div class="comment-data">
                                <div class="comment-data-header">
                                    <span><u><?php echo $resultComment['name']; ?></u></span>
                                    <span style="font-size: 12px;"> <?php echo $resultComment['comment_date']; ?></span>
                                </div>
                                <div class="comment-data-body">
                                    <p>
                                        <?php echo nl2br($resultComment['comment']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="comment-box" style="margin-top: 5%">
                        <div class="comment-add">
                            <img src="./src/img/profile-icon.png" alt="">
                        </div>
                        <div class="comment-data">
                            <div class="comment-data-body">
                                <textarea name="txtComment" id="txtComment"></textarea><br>
                                <button type="button" onclick="addComment()">Comment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<script>
    $('#searchform').on('submit', function (e) {
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
                $("#data-vote").load(location.href + " #data-vote");
            }
        });
    }

    function addComment() {
        console.log("comment")
        $.ajax({
            url: "./src/service/recipe/commentService.php",
            type: "POST",
            data: {
                txtComment: $("#txtComment").val(),
                recipeId: <?php echo $_GET['recipeId'] ?>,
                uid: <?php echo $_SESSION['uid'] ?>,
                name: "<?php echo $_SESSION["name"] ?>"
            },
            success: function (data) {
                if (data == 101) {
                    alert("Maximum comment words is 155 characters")
                } else if (data == 400) {
                    alert("Fail to Comment")
                    console.log("status:400")
                } else {
                    $("#list-comment").load(location.href + " #list-comment");
                    console.log(`message:${data}`)
                }
            }
        });
    }
</script>
</body>
</html>