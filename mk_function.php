<?php
require_once('order/output/mk_order_function.php');
require_once('order_detail/output/mk_order_detail_function.php');

function createTable($table_no)
{
    $order = isTableAlreadyOpenBill($table_no);
    if ($order === FALSE) {
        $status = "open";
        \order\insertNewMk_order($table_no, $status);
        $order = \order\searchMk_openOrder($table_no);
    }
    return $order;
}

function orderFood($food_id, $order_id)
{
    $qty = 1;
    $status = "wait_confirm";
    \order_detail\insertNewMk_order_detail($food_id, $order_id, $qty, $status);
}

function isTableAlreadyOpenBill($table_no)
{
    $order = \order\searchMk_openOrder($table_no);
    if (count($order) == 0) {
        return FALSE;
    }
    return $order;
}

function getAllOrderDetailByOrderId($order_id, $status)
{
    return \order_detail\getMkOrderDetailByIdAndStatus($order_id, $status);
}

function confirmOrderDetail($order_detail_id)
{
    $mk_order_detail = \order_detail\getMk_order_detailById($order_detail_id);
    //print_r($mk_order_detail);
    if (count($mk_order_detail) == 0) {
        echo "ERROR Order Detail ID Does Not Exit! ";
        exit;
    }
    if ($mk_order_detail[0]['status'] != "wait_confirm") {
        exit;
    }
    $id = $order_detail_id;
    $food_id = $mk_order_detail[0]['food_id'];
    $order_id = $mk_order_detail[0]['order_id'];
    $qty = $mk_order_detail[0]['qty'];
    $status = "confirmed";
    \order_detail\updateMk_order_detail($id, $food_id, $order_id, $qty, $status);
}

function changeOrderDetailStatus($order_detail_id, $newStatus)
{
    $mk_order_detail = \order_detail\getMk_order_detailById($order_detail_id);
    
    $id = $order_detail_id;
    $food_id = $mk_order_detail[0]['food_id'];
    $order_id = $mk_order_detail[0]['order_id'];
    $qty = $mk_order_detail[0]['qty'];
    $status = $newStatus;
    \order_detail\updateMk_order_detail($id, $food_id, $order_id, $qty, $status);
    return \order_detail\getMk_order_detailById($order_detail_id);
}

function changeOrderStatus($order_id, $newStatus)
{
    $mk_order = \order\getMk_orderById($order_id);
    
    $id = $order_id;
    $table_no = $mk_order[0]['table_no'];
    $status = $newStatus;
    \order\updateMk_order($id, $table_no, $status);
    return \order\getMk_orderById($order_id);
}
?>