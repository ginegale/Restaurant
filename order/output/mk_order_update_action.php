<?php
require_once("mk_order_function.php");
session_start();

$id = trim($_POST["id"]);
$table_no = trim($_POST["table_no"]);
$status = trim($_POST["status"]);
$submit = $_POST["submit"];

$_SESSION["table_no"] = $table_no;
$_SESSION["status"] = $status;

if (!isset($submit)) {
    header("location:mk_order_insert_form.php");
}
if ($table_no == "") {
    header("location:mk_order_insert_form.php?action=edit&return=1");
    exit;
}
if ($status == "") {
    header("location:mk_order_insert_form.php?action=edit&return=2");
    exit;
}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header("location:mk_order_insert_form.php?return=5");
//     exit;
// }
$isSuccess = \order\updateMk_order($id, $table_no, $status);

session_unset();
session_destroy();
?>
<html>

<head>
    <meta charset="UTF-8" />
    <script type="text/javascript" src="jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/7a1e391625.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.fa-circle-left').hover(function () {
                $(this).addClass('fa-fade');
            }, function () {
                $(this).removeClass('fa-fade');
            });
        });
    </script>
</head>

<body style='margin:20px;'>
    <h2>
        <?php echo $isSuccess ? "<i>Update Successfully<i>" : "<i>Update Failed<i>" ?>
    </h2>
    <br /><br />
    <a href="../../admin/index.php"><i class="fa-solid fa-circle-left fa-xl"></i></a>
    <!-- <br />
    <a href="mk_order_insert_form.php">Back to Insert New Customer</a> -->
</body>

</html>