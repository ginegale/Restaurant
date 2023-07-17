<?php
require_once("mk_order_function.php");
$id = $_GET["id"];
\order\deleteMk_order($id);
?>
<!-- <br /> -->
<!-- <a href="mk_order_show_all.php">Back</a> -->