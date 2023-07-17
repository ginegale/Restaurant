<?php
require_once("food_function.php");
isset( $_GET['cat_id'] ) ? $cat_id = $_GET['cat_id'] : $cat_id = "";
$data = searchFood($cat_id, "cat_id");
echo json_encode($data);
?>