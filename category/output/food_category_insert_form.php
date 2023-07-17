<?php
session_start();
require_once("food_category_function.php");

$isEdit = false;
if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $isEdit = true;
    $id = $_GET['id'];
    $values = getFood_categoryById($id);
    if (count($values) > 0) {
        $id = $values[0]["id"];
        $_SESSION["id"] = $id;
$name = $values[0]["name"];
        $_SESSION["name"] = $name;
    }
}
?>
<html>

<head>
    <title>MM's Bag [Food_category]</title>
</head>

<body>
    <?php
    if (isset($_GET['return']) and $_GET['return'] == 1) {
        echo "<p style='color:red;'>please fill out your food category name</p>";
    }
    ?>
    <h1>Insert New Food_category</h1>
    <?php
    if ($isEdit) {
        echo "<form action='food_category_update_action.php' method='post'>";
    } else {
        echo "<form action='food_category_insert_action.php' method='post'>";
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
            <td colspan="2" style="text-align: right;"><input type="submit" name="submit" value="SAVE" /></td>
        </tr>
    </table>
    </form>
</body>

</html>