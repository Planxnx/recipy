<?php
session_start();
include 'config.php';
$sql = "SELECT * FROM recipe WHERE recipeId =" . $_GET['recipeId'];
$query = mysqli_query($objCon, $sql);
$resultRecipe = mysqli_fetch_assoc($query);
$_SESSION['currentPage'] = $_SERVER['REQUEST_URI'];
$ingredientTemp = array();
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
        <a href="index.php"> <img style="width: 70%" src="src/img/logo.png"></a>
    </div>
    <div class="topButton">
        <?php
        if (isset($_SESSION["uid"])) {
        ?>
        <div class="profile-btn">
            <?php
            if ($_SESSION["role"] == 'admin') {
                ?>
                <span>
                        <a style="color: #fefefe;font-size: 17px"
                           href="control_panel.php">คุณ <?php echo $_SESSION["name"]; ?> </a>&nbsp&nbsp&nbsp
                    </span>
                <?php
            } else {
                echo "คุณ " . $_SESSION["name"];
                echo " &nbsp&nbsp&nbsp";
            }
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
                    $enableVote = true;
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
                            $ingredientTemp[$i] = $resultIngredient['name'];
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
                <div class="recipe-tag">
                    <?php
                    $sql = "SELECT * FROM recipe_tag WHERE recipeId =" . $_GET['recipeId'];
                    $query = mysqli_query($objCon, $sql);
                    $i = 1;
                    while ($resultIngredient = mysqli_fetch_assoc($query)) {
                        if ($i == 1) {
                            ?>
                            <span>Tag : </span><span><?php echo $resultIngredient['name']; ?></span>
                            <?php
                        } else {
                            ?>
                            <span>, <?php echo $resultIngredient['name']; ?></span>
                            <?php
                        }
                        $i++;
                    }
                    ?>
                </div>
<!--
                <div style="text-align: right; margin-right: 2%">
                     <span style="margin-left: 2%;cursor: pointer;font-size: 17px;"
                           onclick="removeRecipe(<?php echo $_GET['recipeId']; ?>)"><i
                                 class="fa fa-trash-o" aria-hidden="true"></i></span>
                </div>
-->
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
                                    <span style="margin-left: 2%;cursor: pointer"
                                          onclick="removeComment(<?php echo $resultComment['id']; ?>,<?php echo $resultComment['uid']; ?>)"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></span>
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
            <div id="comment-recipe" class="comment-recipe shadow">
                <span class="data-header">Related</span>
                <div id="list-related">
                    <?php
                    $sqlIngredient = "SELECT recipeId FROM recipe_ingredient WHERE ";
                    foreach ($ingredientTemp as $key => $item) {
                        if ($key == 1) {
                            $sqlIngredient .= "recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name = '" . $item . "') ";
                        } else {
                            $sqlIngredient .= "OR recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name = '" . $item . "')";
                        }
                    }
                    $sqlIngredient .= "GROUP BY recipeId";
                    $queryIngredient = mysqli_query($objCon, $sqlIngredient);
                    $sql = "";
                    while ($result = mysqli_fetch_array($queryIngredient)) {
                        $sql .= "SELECT * FROM recipe WHERE recipeId = '" . $result['recipeId'] . "';";
                    }
                    if (mysqli_multi_query($objCon, $sql)) {
                        do {
                            if ($resultAll = mysqli_store_result($objCon)) {
                                while ($result = mysqli_fetch_array($resultAll)) {
                                    $resultRelated[] = $result;
                                }
                                mysqli_free_result($resultAll);
                            }
                        } while (mysqli_next_result($objCon));
                    }
                    foreach ($resultRelated as $key => $item) {
                        if ($item['name'] != $resultRecipe['name'] && $key < 3) {
                            ?>
                            <div class="related-box">
                                <a href="recipe.php?recipeId=<?php echo $item['recipeId'] ?>">
                                    <div class="relatedImg">
                                        <img src="./src/service/recipe/images/<?php echo $item['recipeImg']; ?>">
                                    </div>
                                    <span><u><?php echo $item['name']; ?></u></span> <br>
                                    <span style="font-size: 12px;"> <?php echo $item['category']; ?></span>
                                </a>
                            </div>
                            <?php
                        }
                    }
                    ?>
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

    const addComment = () => {
        console.log("comment")
        $.ajax({
            url: "./src/service/recipe/commentService.php",
            type: "POST",
            data: {
                txtComment: $("#txtComment").val(),
                recipeId: <?php echo $_GET['recipeId'] ?>
            },
            success: function (data) {
                if (data == 101) {
                    alert("Comment Length: 1 - 155 characters")
                } else if (data == 102) {
                    alert('Please Sign In to Comment!')
                    document.location.href = 'sign_in.php';
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
    const voteRecipe = (data) => {
        $.ajax({
            url: "./src/service/recipe/voteService.php",
            type: "POST",
            data: {
                voteType: data,
                recipeId: <?php echo $_GET['recipeId'] ?>,
            },
            success: function (data) {
                $("#data-vote").load(location.href + " #data-vote");
            }
        });
    }
    const removeComment = (commentId, uid) => {
        $.ajax({
            url: "./src/service/recipe/deleteCommentService.php",
            type: "POST",
            data: {
                uid: uid,
                commentId: commentId
            },
            success: function (data) {
                if (data == 101) {
                    alert("You don't own this comment!")
                } else if (data == 102) {
                    alert('Please Sign In to delete comment!')
                } else if (data == 400) {
                    alert("Fail to Delete")
                    console.log("status:400")
                } else {
                    $("#list-comment").load(location.href + " #list-comment");
                    console.log(`message:${data}`)
                }
            }
        });
    }
    const removeRecipe = (recipeId) =>{
        $.ajax({
            url: "./src/service/recipe/deleteRecipeService.php",
            type: "POST",
            data: {
                recipeId: recipeId,
            },
            success: function (data) {
                if (data == 101) {
                    alert("You don't own this Recipe!")
                } else if (data == 102) {
                    alert('Please Sign In to delete Recipe!')
                } else if (data == 400) {
                    alert("Fail to Delete")
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