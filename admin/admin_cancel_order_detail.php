<?php 
require_once('../mk_function.php');
$order_detail_id = $_GET['order_detail_id'];
$newStatus = "cancel";
$data = changeOrderDetailStatus($order_detail_id, $newStatus);
$orderdetail_json = json_encode($data);
echo $orderdetail_json;
?>