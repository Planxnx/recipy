
<?php
define('servername', 'localhost');
define('username', 'root');
define('password', '');
define('dbname', 'recipy');
$database = 'recipy';
$objCon = mysqli_connect(servername, username, password, dbname);
$db = mysqli_select_db($objCon, $database);
mysqli_query($objCon, "SET NAMES UTF8");
?>