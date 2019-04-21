<?php
session_start();
include 'config.php';
$sql = "SELECT * FROM recipe ORDER BY RAND() ";
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
    <link rel="stylesheet" href="./src/css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>

<body>
<div class="topNav shadow">
    <div class="homeButton">
        <a href="index.php"> <img style="width: 80%" src="src/img/logo.png"></a>
    </div>
    <div class="topButton">
        <div>
            <button class="shadow" type="submit">Sign In</button>
        </div>
        <button class="shadow" type="submit">Create new Recipe</button>
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
<div id="content">
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span>Welcome to Recipy</span> <br>
                <span style="font-size: 14px">คอมมิวนิตี้สำหรับแบ่งปันสูตรอาหารทุกประเภท
                        สามารถค้นหาสูตรอาหารที่คุณต้องการได้ที่เว็บนี้</span>
                <hr>
            </div>
            <div class="modal-body">
                <div class="featured-header">
                    <span>Featured</span>
                </div>
                <div class="featured-body">
                        <span>
                            ✔ Intelligent Search <br>
                            หากคุณมีส่วนผสมในตู้เย็น แต่ไม่รู้จะทำเมนูอะไรทานดี ลองใช้ <span
                                    style="color: #EE801E">Intelligent Search</span> ดูสิ <br>
                            ช่องค้นหาเพียงช่องเดียวที่สามารถใส่คำค้นหาได้ทั้ง ชื่อสูตร , ส่วนผสม หรือ วิธีการทำ
                            เพื่อผลลัพธ์ของคุณ<br>
                            ตัวอย่างเช่น "กล้วย นม น้ำตาล ช็อกโกแลต" , "ไก่ ทอด" หรือ "แกงเขียวหวานไก่" <br>
                        </span>
                    <span style="font-size:13px;">
                            * เว้นวรรคด้วย Spacebar สำหรับการค้นหาหลายคำ
                        </span>
                </div>
                <div class="featured-body">
                        <span>
                            ✔ Community Vote <br>
                            สูตรอาหารนี้คุณทำแล้วถูกใจคุณหรือป่าว ? <br>
                            แบ่งปันความรู้สึกของคุณต่อสูตรอาหารด้วยการโหวตกัน
                        </span>
                </div>
                <div class="featured-footer">
                        <span>
                            ลองเอาเมาส์มาวางที่ไอคอนนี้สิ่
                        </span>
                    <div class="tooltip" style="font-size: 24px;">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span class="tooltiptext tooltip-right " style="width: 1300%;">
                                คุณจะเจอคำแนะนำสำหรับการใช้งาน หากคุณเอาเมาส์มาวางที่ไอคอนนี้
                            </span>
                    </div>
                </div>
            </div>
            <div>
                <input type="submit" name="btnConfirm" id="closeBtn" value="Close">
            </div>
            <hr style="color:#FFFFFF; border: none;">
        </div>
    </div>
    <div class="list-header">
        <span>Random Recipe</span>
    </div>
    <div id="list-data">
        <?php $i = 1;
        while ($value = mysqli_fetch_assoc($query)) { ?>
            <div class="box-data column">
                <a href="recipe.php?recipeId=<?php echo $value['recipeId'] ?>">
                    <img style="width: 50%" src="./src/service/recipe/images/<?php echo $value['recipeImg']; ?>">
                    <span class="data-detail"><?php echo $value['name']; ?></span> <br>
                    <span class="data-detail"><?php echo $value['category']; ?></span>
                </a>
            </div>
            <?php $i++;
            if ($i > 8) break;
        }
        mysqli_close($objCon);
        ?>
    </div>
</div>
<script src="./src/js/index.js"></script>
</body>


</html>