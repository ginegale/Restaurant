<?php
require_once('mk_function.php');
$table_no = $_POST['table_no'];
$order_json = json_encode(createTable($table_no));
echo $order_json;
?>