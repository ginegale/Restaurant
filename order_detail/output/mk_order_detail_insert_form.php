<?php
session_start();
require_once("mk_order_detail_function.php");

$isEdit = false;
if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $isEdit = true;
    $id = $_GET['id'];
    $values = \order_detail\getMk_order_detailById($id);
    if (count($values) > 0) {
        $id = $values[0]["id"];
        $_SESSION["id"] = $id;
        $food_id = $values[0]["food_id"];
        $_SESSION["food_id"] = $food_id;
        $order_id = $values[0]["order_id"];
        $_SESSION["order_id"] = $order_id;
        $qty = $values[0]["qty"];
        $_SESSION["qty"] = $qty;
        $status = $values[0]["status"];
        $_SESSION["status"] = $status;
        $insert_time = $values[0]["insert_time"];
        $_SESSION["insert_time"] = $insert_time;
    }
}
?>
<html>

<head>
    <title>MM's Bag [Mk_order_detail]</title>
</head>

<body>
    <?php
    if (isset($_GET['return']) and $_GET['return'] == 1) {
        echo "<p style='color:red;'>please fill out your food code</p>";
    }
    if (isset($_GET['return']) and $_GET['return'] == 2) {
        echo "<p style='color:red;'>please fill out your order code</p>";
    }
    if (isset($_GET['return']) and $_GET['return'] == 3) {
        echo "<p style='color:red;'>please fill out your quantity</p>";
    }
    if (isset($_GET['return']) and $_GET['return'] == 4) {
        echo "<p style='color:red;'>please fill out your status</p>";
    }
    ?>
    <h1>Insert New Mk_order_detail</h1>
    <?php
    if ($isEdit) {
        echo "<form action='mk_order_detail_update_action.php' method='post'>";
    } else {
        echo "<form action='mk_order_detail_insert_action.php' method='post'>";
    }
    ?>
    <table>
        <?php
        if ($isEdit) {
            echo "<input type='hidden' name='id' value='$id' />";
        }
        ?>
        <tr>
            <th style="text-align: right;">Food_id </th>
            <td><input type="text" name="food_id"
                    value="<?php echo isset($_SESSION['food_id']) ? $_SESSION['food_id'] : ""; ?>" /></td>
        </tr>
        <tr>
            <th style="text-align: right;">Order_id </th>
            <td><input type="text" name="order_id"
                    value="<?php echo isset($_SESSION['order_id']) ? $_SESSION['order_id'] : ""; ?>" /></td>
        </tr>
        <tr>
            <th style="text-align: right;">Qty </th>
            <td><input type="text" name="qty" value="<?php echo isset($_SESSION['qty']) ? $_SESSION['qty'] : ""; ?>" />
            </td>
        </tr>
        <tr>
            <th style="text-align: right;">Status </th>
            <td><input type="text" name="status"
                    value="<?php echo isset($_SESSION['status']) ? $_SESSION['status'] : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;"><input type="submit" name="submit" value="SAVE" /></td>
        </tr>
    </table>
    </form>
</body>

</html>