<?php
include '../../../config.php';

$_POST['searchText'] = mysqli_real_escape_string($objCon,$_POST['searchText']);

abstract class BasicEnum
{
    private static $constCacheArray = NULL;

    private static function getConstants()
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();
        if ($strict) {
            return array_key_exists($name, $constants);
        }
        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}

abstract class category extends BasicEnum
{
    const Everyday = true;
    const QuickEasy = true;
    const Easy = true;
    const Quick = true;
    const Healthy = true;
    const Dessert = true;
    const CakeBaking = true;
    const Cake = true;
    const Baking = true;
    const Drinks = true;
}

if ($_POST['searchText'] == '') {
    $sql = "SELECT * FROM recipe ";
    $sqlSimilar = " ";
} else {
    $search_val = explode(" ", trim($_POST['searchText']));
    $sql = "SELECT * FROM recipe WHERE name = '" . $_POST['searchText'] . "' ;";
    foreach ($search_val as $item) {
        $sql .= "SELECT * FROM recipe WHERE name = '" . $item . "';";
    }

    $x = 0;
    foreach ($search_val as $item) {
        if (category::isValidName($item)) {
            if ($x == 0) {
                $sql .= "SELECT * FROM recipe WHERE category LIKE '%" . $item . "%'";
                foreach ($search_val as $value) {
                    if (category::isValidName($value)) {
                        $sql .= "AND category LIKE '%" . $item . "%'";
                    } else {
                        $sql .= "AND ingredient LIKE '%" . $item . "%'";
                    }
                }
                $sql .= ";";
            } else {
                $sql .= "SELECT * FROM recipe WHERE category LIKE '%" . $item . "%'";
                foreach ($search_val as $value) {
                    if (category::isValidName($value)) {
                        $sql .= "AND category LIKE '%" . $item . "%'";
                    } else {
                        $sql .= "AND ingredient LIKE '%" . $item . "%'";
                    }
                }
                $sql .= ";";
            }
        } else {
            $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
            foreach ($search_val as $value) {
                $sql .= "AND category LIKE '%" . $item . "%'";
            }
            $sql .= ";";
        }
        $x++;
    }

    $x = 0;
    foreach ($search_val as $item) {
        if (category::isValidName($item)) {
            if ($x == 0) {
                $sql .= "SELECT * FROM recipe WHERE category LIKE '%" . $item . "%'";
                foreach ($search_val as $value) {
                    if (category::isValidName($value)) {
                        $sql .= "AND category LIKE '%" . $item . "%'";
                    } else {
                        $sql .= "AND howTo LIKE '%" . $item . "%'";
                    }
                }
                $sql .= ";";
            } else {
                $sql .= "SELECT * FROM recipe WHERE category LIKE '%" . $item . "%'";
                foreach ($search_val as $value) {
                    if (category::isValidName($value)) {
                        $sql .= "AND category LIKE '%" . $item . "%'";
                    } else {
                        $sql .= "AND howTo LIKE '%" . $item . "%'";
                    }
                }
                $sql .= ";";
            }
        } else {
            if ($x == 0) {
                $sql .= "SELECT * FROM recipe WHERE howTo = '" . $item . "'";
                foreach ($search_val as $value) {
                    if (category::isValidName($value)) {
                        $sql .= "AND category LIKE '%" . $item . "%'";
                    } else {
                        $sql .= "AND howTo LIKE '%" . $item . "%'";
                    }
                }
                $sql .= ";";
            } else {
                $sql .= "SELECT * FROM recipe WHERE howTo = '" . $item . "'";
                foreach ($search_val as $value) {
                    if (category::isValidName($value)) {
                        $sql .= "AND category LIKE '%" . $item . "%'";
                    } else {
                        $sql .= "AND howTo LIKE '%" . $item . "%'";
                    }
                }
                $sql .= ";";
            }
        }
        $x++;
    }


    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            if (category::isValidName($item)) {
                $sql .= "SELECT * FROM recipe WHERE category LIKE '%" . $item . "%'";
            } else {
                $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
            };
        } else {
            if ($item != '') {
                if (category::isValidName($item)) {
                    $sql .= "AND category LIKE '%" . $item . "%'";
                } else {
                    $sql .= "AND ingredient LIKE '%" . $item . "%'";
                };
            }
        }
        $x++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else if ($i % 2 == 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";


    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $x++;
    }
    $sql .= ";";

    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            if (category::isValidName($item)) {
                $sql .= "SELECT * FROM recipe WHERE category LIKE '%" . $item . "%'";
            } else {
                $sql .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
            };
        } else {
            if ($item != '') {
                if (category::isValidName($item)) {
                    $sql .= "AND category LIKE '%" . $item . "%'";
                } else {
                    $sql .= "AND howTo LIKE '%" . $item . "%'";
                };
            }
        }
        $x++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else if ($i % 2 == 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";
    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else if ($i % 2 == 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE name LIKE '%" . $item . "%'";
        } else if ($i % 2 == 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE name LIKE '%" . $item . "%'";
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND ingredient LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            if (category::isValidName($item)) {
                $sql .= "SELECT * FROM recipe WHERE category LIKE '%" . $item . "%'";
            } else {
                $sql .= "SELECT * FROM recipe WHERE name LIKE '%" . $item . "%'";
            };
        } else {
            if ($item != '') {
                if (category::isValidName($item)) {
                    $sql .= "AND category LIKE '%" . $item . "%'";
                } else {
                    $sql .= "AND name LIKE '%" . $item . "%'";
                };
            }
        }
        $x++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else if ($i % 2 == 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";
    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE name LIKE '%" . $item . "%'";
        } else if ($i % 2 == 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE name LIKE '%" . $item . "%'";
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND name LIKE '%" . $item . "%'";
            }
        } else if ($i % 2 != 0) {
            if ($item != '') {
                $sql .= "AND howTo LIKE '%" . $item . "%'";
            }
        }
        $i++;
    }
    $sql .= ";";

    $i = 0;
    foreach ($search_val as $item) {
        if ($i == 0) {
            $sql .= "SELECT * FROM recipe WHERE name LIKE '%" . $item . "%'";
        } else {
                $sql .= "AND name LIKE '%" . $item . "%'";
        }
        $i++;
    }
    $sql .= ";";

    //similar search
    $sqlSimilar = " ";

    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            $sqlSimilar = "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else if ($x % 2 != 0) {
            if ($item != '') {
                $sqlSimilar .= "OR ingredient LIKE '%" . $item . "%'";
            }
        } else {
            $sqlSimilar .= "AND ingredient LIKE '%" . $item . "%'";
        }
        $x++;
    }
    $sqlSimilar .= ";";
    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            $sqlSimilar .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else if ($x % 2 == 0) {
            if ($item != '') {
                $sqlSimilar .= "OR ingredient LIKE '%" . $item . "%'";
            }
        } else {
            $sqlSimilar .= "AND ingredient LIKE '%" . $item . "%'";
        }
        $x++;
    }
    $sqlSimilar .= ";";

    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            $sqlSimilar .= "SELECT * FROM recipe WHERE ingredient LIKE '%" . $item . "%'";
        } else {
            if ($item != '') {
                $sqlSimilar .= "OR ingredient LIKE '%" . $item . "%'";
            }
        }
        $x++;
    }
    $sqlSimilar .= ";";

    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            $sqlSimilar = "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else if ($x % 2 != 0) {
            if ($item != '') {
                $sqlSimilar .= "OR howTo LIKE '%" . $item . "%'";
            }
        } else {
            $sqlSimilar .= "AND howTo LIKE '%" . $item . "%'";
        }
        $x++;
    }
    $sqlSimilar .= ";";
    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            $sqlSimilar .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else if ($x % 2 == 0) {
            if ($item != '') {
                $sqlSimilar .= "OR howTo LIKE '%" . $item . "%'";
            }
        } else {
            $sqlSimilar .= "AND howTo LIKE '%" . $item . "%'";
        }
        $x++;
    }
    $sqlSimilar .= ";";

    $x = 0;
    foreach ($search_val as $item) {
        if ($x == 0) {
            $sqlSimilar .= "SELECT * FROM recipe WHERE howTo LIKE '%" . $item . "%'";
        } else {
            if ($item != '') {
                $sqlSimilar .= "OR howTo LIKE '%" . $item . "%'";
            }
        }
        $x++;
    }
    $sqlSimilar .= ";";
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