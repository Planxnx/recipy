<?php
session_start();
if (!isset($_SESSION["uid"])) {
    $URL = "signIn.php";
    echo "<script type='text/javascript'> alert('Please SignIn to Create new Recipe') </script>";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>

<html>
<body>
<center><h3>Create New Recipe</h3></center>
<form name="form1"  enctype="multipart/form-data" method="post" action="./src/service/recipe/create_recipe_service.php">
    <center>
        <table border="0" width="250" style="width: 200px">
            <tbody>
            <tr>
                <td width="50">
                    <input type="file" name="recipeImg" id="recipeImg">
                </td>
                <td width="50">
                    <table border="0">
                        <tbody>
                        <tr>
                            <td>Food Name</td>
                        </tr>
                        <tr>
                            <td><input name="txtname" type="text" id="txtname" required></td>
                        </tr>
                        <tr>
                            <td>Category Of Food</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="ddlcategory" id="ddlcategory">
                                    <option value="Everyday">Everyday</option>
                                    <option value="Quick & Easy">Quick & Easy</option>
                                    <option value="Healthy">Healthy</option>
                                    <option value="Dessert">Dessert</option>
                                    <option value="Cake & Baking">Cake & Baking</option>
                                    <option value="Drinks">Drinks</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" width="200">Description</td>
            </tr>
            <tr>
                <td colspan="2" width="200">
                    <textarea name="txtdescription" id="txtdescription" cols="30" rows="5"></textarea>

                </td>
            </tr>
            <tr>
                <td colspan="2" width="200">Ingredients</td>
            </tr>
            <tr>
                <td colspan="2" width="200">
                    <textarea required name="txtingredient" id="txtingredient" cols="30" rows="10"></textarea>
            </tr>
            <tr>
                <td colspan="2" width="200">How to</td>
            </tr>
            <tr>
                <td colspan="2" width="200">
                    <textarea required name="txthowTo" id="txthowTo" cols="30" rows="10"></textarea>
            </tr>
            <tr>
                <td colspan="2" width="200"><input type="submit" name="Submit" value="Create"> &nbsp;</td>
            </tr>
            </tbody>
        </table>
    </center>
</form>
</body>
</html>