<?php
include 'searchService.php';

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
    $promoteSql = "SELECT * FROM recipe WHERE promote = TRUE ORDER BY RAND()";
    $promoteQuery = mysqli_query($objCon, $promoteSql);
    $i = 1;
    $promoteRecipeTemp = array();
    while ($promoteRecipe = mysqli_fetch_assoc($promoteQuery)) {
        $promoteRecipeTemp[$i] = $promoteRecipe['recipeId'];
        ?>
        <div id="recipe-<?php echo $promoteRecipe['recipeId'] ?>"
             class="box-data column <?php echo categoryConvert($promoteRecipe['category']); ?>">
            <a href="recipe.php?recipeId=<?php echo $promoteRecipe['recipeId'] ?>">
                <div class="crop promote-crop">
                    <div class="promote-tag">
                        <span>Promote by Recipy</span>
                    </div>
                    <img src="./src/service/recipe/images/<?php echo $promoteRecipe['recipeImg']; ?>">
                </div>
                <span style="font-weight: 500;" class="data-detail"><?php echo $promoteRecipe['name']; ?></span> <br>
                <span style="font-size: 13px;" class="data-detail "><?php echo $promoteRecipe['category']; ?></span>
            </a>
        </div>
        <?php
        if ($i > 1) break;
        $i++;
    }
    ?>
    <?php
    $i = 1;
    foreach ($fullResult as $value) { ?>
        <div id="recipe-<?php echo $value['recipeId'] ?>"
             class="box-data column <?php echo categoryConvert($value['category']); ?>">
            <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
                <div class="crop">
                    <img src="./src/service/recipe/images/<?php echo $value['recipeImg']; ?>">
                </div>
                <span style="font-weight: 500;" class="data-detail"><?php echo $value['name']; ?></span> <br>
                <span style="font-size: 13px;" class="data-detail "><?php echo $value['category']; ?></span>
            </a>
        </div>
        <script>
            $(document).ready(() => {
                $('[id]').each(function () {
                    console.log(this.id)
                    var ids = $('[id=' + this.id + ']');
                    if (ids.length > 1 && ids[0] == this) {
                        $(ids[1]).hide(0);
                    }
                });
            });
        </script>
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