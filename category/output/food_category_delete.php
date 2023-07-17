<?php
require_once("food_category_function.php");
$id = $_GET["id"];
deleteFood_category($id);
?>
<br />
<a href="food_category_show_all.php">Back</a>