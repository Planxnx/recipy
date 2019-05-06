<?php
include 'searchService.php';
//include 'searchEngine.php';

function categoryConvert($category)
{
    if ($category == "Everyday") {
        return "recipeEveryday";
    } else if ($category == "Quick & Easy") {
        return "recipeEasy";
    } else if ($category == "Healthy") {
        return "recipeHealth";
    } else if ($category == "Dessert") {
        return "recipeDessert";
    } else if ($category == "Cake & Baking") {
        return "recipeBaking";
    } else if ($category == "Drinks") {
        return "recipeDrinks";
    }
}

if ($fullResult) {
    ?>
    <script src="./src/js/index.js"></script>
    <div class="list-header">
        <span>Found <?php echo $fullResultCount ?> results</span>
        <div class="dropdown">
            <button class="dropbtn">Fliter</button>
            <div class="dropdown-content">
                <a href="#" onclick="categoryFilter('recipeAll')">Show All</a>
                <a href="#" onclick="categoryFilter('recipeEveryday')">Everyday</a>
                <a href="#" onclick="categoryFilter('recipeEasy')">Quick & Easy</a>
                <a href="#" onclick="categoryFilter('recipeHealth')">Healthy</a>
                <a href="#" onclick="categoryFilter('recipeDessert')">Dessert</a>
                <a href="#" onclick="categoryFilter('recipeBaking')">Cake & Baking</a>
                <a href="#" onclick="categoryFilter('recipeDrinks')">Drinks</a>
            </div>
        </div>
    </div>
    <?php
    $i = 1;
    foreach ($fullResult as $value) { ?>
        <script>
            console.log("<?php echo $value['recipeId'] ?>");
        </script>
        <div class="box-data column <?php echo categoryConvert($value['category']); ?>">
            <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
                <div class="crop">
                    <img src="./src/service/recipe/images/<?php echo $value['recipeImg']; ?>">
                </div>
                <span style="font-weight: 500;" class="data-detail"><?php echo $value['name']; ?></span> <br>
                <span style="font-size: 13px;" class="data-detail "><?php echo $value['category']; ?></span>
            </a>
        </div>
        <?php $i++;
    }
} else if ($fullSimilarResult) {
    if (!$fullResult) {
        ?>
        <div class='list-header'>
            <span>Your results not found</span>
            <div class="dropdown">
                <button class="dropbtn">Fliter</button>
                <div class="dropdown-content">
                    <a href="#" onclick="categoryFilter('recipeAll')">Show All</a>
                    <a href="#" onclick="categoryFilter('recipeEveryday')">Everyday</a>
                    <a href="#" onclick="categoryFilter('recipeEasy')">Quick & Easy</a>
                    <a href="#" onclick="categoryFilter('recipeHealth')">Healthy</a>
                    <a href="#" onclick="categoryFilter('recipeDessert')">Dessert</a>
                    <a href="#" onclick="categoryFilter('recipeBaking')">Cake & Baking</a>
                    <a href="#" onclick="categoryFilter('recipeDrinks')">Drinks</a>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <br>
    <hr style="width: 100%;border: 0;height: 0;border-top: 1px solid rgba(0, 0, 0, 0.1);border-bottom: 1px solid rgba(255, 255, 255, 0.3);">
    <div class="list-header">
        <span>Try this!</span>
    </div>
    <?php
    $i = 1;
    foreach ($fullSimilarResult as $index => $value) {
        if ($index < 9) {
            ?>
            <div class="box-data column <?php echo categoryConvert($value['category']); ?>">
                <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
                    <div class="crop">
                        <img src="./src/service/recipe/images/<?php echo $value['recipeImg']; ?>">
                    </div>
                    <span style="font-weight: 500;" class="data-detail"><?php echo $value['name']; ?></span> <br>
                    <span style="font-size: 13px;" class="data-detail"><?php echo $value['category']; ?></span>
                </a>
            </div>
            <?php $i++;
        }
    }
}
?>

<?php mysqli_close($objCon); ?>