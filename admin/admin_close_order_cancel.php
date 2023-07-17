<?php
require_once('../mk_function.php');
$order_id = $_GET['order_id'];
$data = changeOrderStatus($order_id, 'cancel');
$order_json = json_encode($data);
echo $order_json;
?>