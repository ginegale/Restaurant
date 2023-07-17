<?php
require_once("mk_order_detail_function.php");
session_start();

$food_id = trim($_POST["food_id"]);
$order_id = trim($_POST["order_id"]);
$qty = trim($_POST["qty"]);
$status = trim($_POST["status"]);
$submit = $_POST["submit"];

$_SESSION["food_id"] = $food_id;
$_SESSION["order_id"] = $order_id;
$_SESSION["qty"] = $qty;
$_SESSION["status"] = $status;

if (!isset($submit)) {
    header("location:mk_order_detail_insert_form.php");
}
if ($food_id == "") {
    header("location:mk_order_detail_insert_form.php?return=1");
    exit;
}
if ($order_id == "") {
    header("location:mk_order_detail_insert_form.php?return=2");
    exit;
}
if ($qty == "") {
    header("location:mk_order_detail_insert_form.php?return=3");
    exit;
}
if ($status == "") {
    header("location:mk_order_detail_insert_form.php?return=4");
    exit;
}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header("location:mk_order_detail_insert_form.php?return=5");
//     exit;
// }
$isSuccess = \order_detail\insertNewMk_order_detail($food_id, $order_id, $qty, $status);

session_unset();
session_destroy();
?>
<html>

<head>
    <meta charset="UTF-8" />
</head>

<body>
    <h1>
        <?php echo $isSuccess ? "Insert Successfully" : "Insert Failed" ?>
    </h1>
    <br />
    <a href="index.php">Back</a>
    <br />
    <a href="mk_order_detail_insert_form.php">Back to Insert New Customer</a>
</body>

</html>