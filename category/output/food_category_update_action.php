<?php
require_once("food_category_function.php");
session_start();

$id = trim($_POST["id"]);
$name = trim($_POST["name"]);
$submit = $_POST["submit"];

$_SESSION["name"] = $name;

if (!isset($submit)) {
    header("location:food_category_insert_form.php");
}
if ($name == "") {
    header("location:food_category_insert_form.php?action=edit&return=1");
    exit;
}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header("location:food_category_insert_form.php?return=5");
//     exit;
// }
$isSuccess = updateFood_category($id, $name);

session_unset();
session_destroy();
?>
<html>

<head>
    <meta charset="UTF-8" />
</head>

<body>
    <h1>
        <?php echo $isSuccess ? "Update Successfully" : "Update Failed" ?>
    </h1>
    <br />
    <a href="index.php">Back</a>
    <br />
    <a href="food_category_insert_form.php">Back to Insert New Customer</a>
</body>

</html>