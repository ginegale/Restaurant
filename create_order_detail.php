<?php
require_once('mk_function.php');
$food_id = $_POST['food_id'];
$order_id = $_POST['order_id'];
orderFood($food_id, $order_id);
?>