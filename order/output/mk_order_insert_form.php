<?php
session_start();
require_once("mk_order_function.php");

$isEdit = false;
if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $isEdit = true;
    $id = $_GET['id'];
    $values = \order\getMk_orderById($id);
    if (count($values) > 0) {
        $id = $values[0]["id"];
        $_SESSION["id"] = $id;
        $table_no = $values[0]["table_no"];
        $_SESSION["table_no"] = $table_no;
        $status = $values[0]["status"];
        $_SESSION["status"] = $status;
        $insert_time = $values[0]["insert_time"];
        $_SESSION["insert_time"] = $insert_time;
    }
}
?>
<html>

<head>
    <title></title>
</head>

<body>
    <?php
    if (isset($_GET['return']) and $_GET['return'] == 1) {
        echo "<p style='color:red;'>please fill out your table number</p>";
    }
    if (isset($_GET['return']) and $_GET['return'] == 2) {
        echo "<p style='color:red;'>please fill out your order status</p>";
    }
    ?>
    <h4>EDIT FOOD ORDERS</h4>
    <?php
    if ($isEdit) {
        echo "<form action='../order/output/mk_order_update_action.php' method='post'>";
    } else {
        echo "<form action='../order/output/mk_order_insert_action.php' method='post'>";
    }
    ?>
    <table>
        <?php
        if ($isEdit) {
            echo "<input type='hidden' name='id' value='$id' />";
        }
        ?>
        <tr>
            <th style="text-align:right;font-size:14px;">TABLE NO</th>
            <td><input type="text" name="table_no"
                    value="<?php echo isset($_SESSION['table_no']) ? $_SESSION['table_no'] : ""; ?>" /></td>
        </tr>
        <tr>
            <th style="text-align:right;font-size:14px;">STATUS</th>
            <td><input type="text" name="status"
                    value="<?php echo isset($_SESSION['status']) ? $_SESSION['status'] : ""; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;font-size:14px;"><input type="submit" name="submit" value="SAVE" />
            </td>
        </tr>
    </table>
    </form>
</body>

</html>