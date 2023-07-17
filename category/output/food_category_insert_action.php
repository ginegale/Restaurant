<?php
require_once("food_category_function.php");
session_start();

$name = trim($_POST["name"]);
$submit = $_POST["submit"];

$_SESSION["name"] = $name;

if (!isset($submit)) {
    header("location:food_category_insert_form.php");
}
if ($name == "") {
    header("location:food_category_insert_form.php?return=1");
    exit;
}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header("location:food_category_insert_form.php?return=5");
//     exit;
// }
$isSuccess = insertNewFood_category($name);

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
    <a href="food_category_insert_form.php">Back to Insert New Customer</a>
</body>

</html>