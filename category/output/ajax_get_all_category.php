<?php 
require_once("food_category_function.php");
$data = getAllFood_category();
echo json_encode($data);
?>