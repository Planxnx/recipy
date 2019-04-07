<?php
//sleep(1);
include 'searchEngine.php';
?>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <th>Search Result</th>
            <tr>
                <th></th>
                <th>name</th>
                <th>category</th>
                <th>ingredient</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($fullResult as $value) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>"><?php echo $value['name']; ?></a>
                    </td>
                    <td><?php echo $value['category']; ?></td>
                    <td><?php echo $value['ingredient']; ?></td>
                </tr>
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
                <th>ingredient</th>
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
                    <td><?php echo $value['ingredient']; ?></td>
                </tr>
                <?php $i++;
//                if($i>10)break;
            }
            ?>
            </tbody>
        </table>
    </div>

<?php mysqli_close($objCon); ?>