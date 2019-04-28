<?php
include '../../../config.php';

$_POST['searchText'] = mysqli_real_escape_string($objCon, $_POST['searchText']);

if ($_POST['searchText'] == '') {
    $sql = "SELECT * FROM recipe ";
    $sqlSimilar = " ";
} else {
    $search_val = explode(" ", trim($_POST['searchText']));
    $sql = "SELECT * FROM recipe WHERE name = '" . $_POST['searchText'] . "' ;";
    foreach ($search_val as $item) {
        $sql .= "SELECT * FROM recipe WHERE name = '" . $item . "';";
    }

    $sqlIngredient = "SELECT recipeId FROM recipe_ingredient WHERE ";
    foreach ($search_val as $key => $item) {
        if ($key == 0) {
            $sqlIngredient .= "recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name = '" . $item . "') ";
        } else {
            $sqlIngredient .= "AND recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name = '" . $item . "')";
        }
    }
    $sqlIngredient .= "GROUP BY recipeId";
    $query = mysqli_query($objCon, $sqlIngredient);
    while ($result = mysqli_fetch_array($query)) {
        $sql .= "SELECT * FROM recipe WHERE recipeId = '" . $result['recipeId'] . "';";
    }

    $sqlIngredient = "SELECT recipeId FROM recipe_ingredient WHERE ";
    foreach ($search_val as $key => $item) {
        if ($key == 0) {
            $sqlIngredient .= "recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name LIKE '%" . $item . "%') ";
        } else {
            $sqlIngredient .= "AND recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name LIKE '%" . $item . "%')";
        }
    }
    $sqlIngredient .= "GROUP BY recipeId";
    $query = mysqli_query($objCon, $sqlIngredient);
    while ($result = mysqli_fetch_array($query)) {
        $sql .= "SELECT * FROM recipe WHERE recipeId = '" . $result['recipeId'] . "';";
    }

    ///////////////////////////////////
    $sqlSimilar = "";
    $sql = "SELECT * FROM recipe WHERE name LIKE '%" . $_POST['searchText'] . "%' ;";
    foreach ($search_val as $item) {
        $sql .= "SELECT * FROM recipe WHERE name LIKE '%" . $item . "%';";
    }

    $sqlIngredient = "SELECT recipeId FROM recipe_ingredient WHERE ";
    foreach ($search_val as $key => $item) {
        if ($key == 0) {
            $sqlIngredient .= "recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name = '" . $item . "') ";
        } else {
            $sqlIngredient .= "OR recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name = '" . $item . "')";
        }
    }
    $sqlIngredient .= "GROUP BY recipeId";
    $query = mysqli_query($objCon, $sqlIngredient);
    while ($result = mysqli_fetch_array($query)) {
        $sql .= "SELECT * FROM recipe WHERE recipeId = '" . $result['recipeId'] . "';";
    }

    $sqlIngredient = "SELECT recipeId FROM recipe_ingredient WHERE ";
    foreach ($search_val as $key => $item) {
        if ($key == 0) {
            $sqlIngredient .= "recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name LIKE '%" . $item . "%') ";
        } else {
            $sqlIngredient .= "OR recipeId IN (SELECT recipeId FROM recipe_ingredient WHERE name LIKE '%" . $item . "%')";
        }
    }
    $sqlIngredient .= "GROUP BY recipeId";
    $query = mysqli_query($objCon, $sqlIngredient);
    while ($result = mysqli_fetch_array($query)) {
        $sqlSimilar .= "SELECT * FROM recipe WHERE recipeId = '" . $result['recipeId'] . "';";
    }
}
$fullResult = array();
$fullSimilarResult = array();
$i = 1;
if (mysqli_multi_query($objCon, $sql)) {
    do {
        if ($resultAll = mysqli_store_result($objCon)) {
            while ($result = mysqli_fetch_array($resultAll)) {
                $fullResult[] = $result;
            }
            mysqli_free_result($resultAll);
        }
    } while (mysqli_next_result($objCon));
}
$fullResult = array_unique($fullResult, SORT_REGULAR);

if (mysqli_multi_query($objCon, $sqlSimilar)) {
    do {
        if ($resultAll = mysqli_store_result($objCon)) {
            while ($result = mysqli_fetch_array($resultAll)) {
                $fullSimilarResult[] = $result;
            }
            mysqli_free_result($resultAll);
        }
    } while (mysqli_next_result($objCon));
}
$fullSimilarResult = array_unique($fullSimilarResult, SORT_REGULAR);

$key = 0;
foreach ($fullSimilarResult as $value) {
    foreach ($fullResult as $item) {
        if ($value['name'] == $item['name']) {
            unset($fullSimilarResult[$key]);
        }
    }
    $key++;
}

?>