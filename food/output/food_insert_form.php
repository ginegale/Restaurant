<?php
session_start();
require_once("food_function.php");

$isEdit = false;
if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $isEdit = true;
    $id = $_GET['id'];
    $values = getFoodById($id);
    if (count($values) > 0) {
        $id = $values[0]["id"];
        $_SESSION["id"] = $id;
$name = $values[0]["name"];
        $_SESSION["name"] = $name;
$description = $values[0]["description"];
        $_SESSION["description"] = $description;
$price = $values[0]["price"];
        $_SESSION["price"] = $price;
$image = $values[0]["image"];
        $_SESSION["image"] = $image;
$cat_id = $values[0]["cat_id"];
        $_SESSION["cat_id"] = $cat_id;
    }
}
?>
<html>

<head>
    <title>MM's Bag [Food]</title>
</head>

<body>
    <?php
    if (isset($_GET['return']) and $_GET['return'] == 1) {
        echo "<p style='color:red;'>please fill out your food name</p>";
    }
if (isset($_GET['return']) and $_GET['return'] == 2) {
        echo "<p style='color:red;'>please fill out your food description</p>";
    }
if (isset($_GET['return']) and $_GET['return'] == 3) {
        echo "<p style='color:red;'>please fill out your food price</p>";
    }
if (isset($_GET['return']) and $_GET['return'] == 4) {
        echo "<p style='color:red;'>please fill out your food image path</p>";
    }
if (isset($_GET['return']) and $_GET['return'] == 5) {
        echo "<p style='color:red;'>please fill out your food category code</p>";
    }
    ?>
    <h1>Insert New Food</h1>
    <?php
    if ($isEdit) {
        echo "<form action='food_update_action.php' method='post'>";
    } else {
        echo "<form action='food_insert_action.php' method='post'>";
    }
    ?>
    <table>
        <?php
        if ($isEdit) {
            echo "<input type='hidden' name='id' value='$id' />";
        }
        ?>
        <tr>
            <th style="text-align: right;">Name </th>
            <td><input type="text" name="name"
                value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ""; ?>" /></td>
        </tr>
<tr>
            <th style="text-align: right;">Description </th>
            <td><input type="text" name="description"
                value="<?php echo isset($_SESSION['description']) ? $_SESSION['description'] : ""; ?>" /></td>
        </tr>
<tr>
            <th style="text-align: right;">Price </th>
            <td><input type="text" name="price"
                value="<?php echo isset($_SESSION['price']) ? $_SESSION['price'] : ""; ?>" /></td>
        </tr>
<tr>
            <th style="text-align: right;">Image </th>
            <td><input type="text" name="image"
                value="<?php echo isset($_SESSION['image']) ? $_SESSION['image'] : ""; ?>" /></td>
        </tr>
<tr>
            <th style="text-align: right;">Cat_id </th>
            <td><input type="text" name="cat_id"
                value="<?php echo isset($_SESSION['cat_id']) ? $_SESSION['cat_id'] : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;"><input type="submit" name="submit" value="SAVE" /></td>
        </tr>
    </table>
    </form>
</body>

</html>