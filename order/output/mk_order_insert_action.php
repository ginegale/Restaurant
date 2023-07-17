<?php
require_once("mk_order_function.php");
session_start();

$table_no = trim($_POST["table_no"]);
$status = trim($_POST["status"]);
$submit = $_POST["submit"];

$_SESSION["table_no"] = $table_no;
$_SESSION["status"] = $status;

if (!isset($submit)) {
    header("location:mk_order_insert_form.php");
}
if ($table_no == "") {
    header("location:mk_order_insert_form.php?return=1");
    exit;
}
if ($status == "") {
    header("location:mk_order_insert_form.php?return=2");
    exit;
}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header("location:mk_order_insert_form.php?return=5");
//     exit;
// }
$isSuccess = \order\insertNewMk_order($table_no, $status);

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
    <a href="mk_order_insert_form.php">Back to Insert New Customer</a>
</body>

</html>