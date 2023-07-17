<?php
require_once("mk_order_detail_function.php");
$id = $_GET["id"];
\order_detail\deleteMk_order_detail($id);
?>
<br />
<a href="mk_order_detail_show_all.php">Back</a>