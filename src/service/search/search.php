<?php
//sleep(1);
include 'searchEngine.php';
?>

<?php
$i = 1;
foreach ($fullResult as $value) { ?>
    <div class="box-data column">
        <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
            <img style="width: 50%" src="./src/service/recipe/images/<?php echo $value['recipeImg']; ?>">
            <span class="data-detail"><?php echo $value['name']; ?></span> <br>
            <span class="data-detail"><?php echo $value['category']; ?></span>
        </a>
    </div>
    <?php $i++;
//                if($i>10)break;
}
?>
    </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
        <th>look like your result</th>
        <tr>
            <th></th>
            <th>name</th>
            <th>category</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($fullSimilarResult as $value) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>"><?php echo $value['name']; ?></a>
                </td>
                <td><?php echo $value['category']; ?></td>
            </tr>
            <?php $i++;
//                if($i>10)break;
        }
        ?>
        </tbody>
    </table>
    </div>

<?php mysqli_close($objCon); ?>