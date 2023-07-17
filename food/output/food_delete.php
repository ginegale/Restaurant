<?php
require_once("food_function.php");
$id = $_GET["id"];
deleteFood($id);
?>
<br />
<a href="food_show_all.php">Back</a>