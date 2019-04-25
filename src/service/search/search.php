<?php
//sleep(1);
include 'searchEngine.php';
?>
    <div class="list-header">
        <span>Your results</span>
    </div>
<?php
$i = 1;
foreach ($fullResult as $value) { ?>
    <div class="box-data column">
        <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
            <div class="crop">
                <img src="./src/service/recipe/images/<?php echo $value['recipeImg']; ?>">
            </div>
            <span style="font-weight: 500;" class="data-detail"><?php echo $value['name']; ?></span> <br>
            <span style="font-size: 13px;" class="data-detail"><?php echo $value['category']; ?></span>
        </a>
    </div>
    <?php $i++;
//                if($i>10)break;
}
?>
<?php
if ($fullSimilarResult) {
    ?>
    <hr style="width: 100%;border: 0;height: 0;border-top: 1px solid rgba(0, 0, 0, 0.1);border-bottom: 1px solid rgba(255, 255, 255, 0.3);">
    <div class="list-header">
        <span>Look like your result</span>
    </div>
    <?php
    $i = 1;
    foreach ($fullSimilarResult as $value) { ?>
        <div class="box-data column">
            <div class="crop">
                <img src="./src/service/recipe/images/<?php echo $value['recipeImg']; ?>">
            </div>
            <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
                <span style="font-weight: 500;" class="data-detail"><?php echo $value['name']; ?></span> <br>
                <span style="font-size: 13px;" class="data-detail"><?php echo $value['category']; ?></span>
            </a>
        </div>
        <?php $i++;
//                if($i>10)break;
    }
}
?>

<?php mysqli_close($objCon); ?>