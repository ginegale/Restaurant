<?php
require_once('mk_function.php');
isset($_POST['order_id']) ? $order_id = $_POST['order_id'] : $order_id = "";
isset($_POST['status']) ? $status = $_POST['status'] : $status = "";
$status = explode('|', $status);
$data = getAllOrderDetailByOrderId($order_id, $status);
$orderdetail_json = json_encode($data);
echo $orderdetail_json;
//print_r($status);
?>