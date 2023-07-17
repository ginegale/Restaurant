<?php
require_once('../order_detail/output/mk_order_detail_function.php');
$order_id = $_GET['order_id'];
$status_x = $_GET['status'];
$status = array();
$detail = \order_detail\getMkOrderDetailByIdAndStatus($order_id, $status);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../jquery-3.6.4.min.js"></script>
    <link href="../bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7a1e391625.js" crossorigin="anonymous"></script>
    <title>Order Detail</title>
    <script>
        var cancel_url = "admin_cancel_order_detail.php?order_detail_id=";
        var served_url = "admin_served_order_detail.php?order_detail_id=";
        function RefreshTable(url, selector) {
            $(document).on('click', selector, function () {
                var update_icon = $(this);
                var id = this.id.split('_').pop();
                $.get(url + id, function (data) {
                    var updated_data = JSON.parse(data);
                    $('#status_' + id).html(updated_data[0].status);
                });
            });
        }

        $(document).ready(function () {
            $('.fa-xmark, .fa-bowl-food').hover(function () {
                $(this).addClass('fa-shake');
            }, function () {
                $(this).removeClass('fa-shake');
            });
            RefreshTable(cancel_url, '[id^="cancel_"]');
            RefreshTable(served_url, '[id^="served_"]');
            $('#order_paid').click(function () {
                $.get("admin_close_order_paid.php?order_id=<?php echo $order_id; ?>", function (data) {
                    var updated_data = JSON.parse(data);
                    $('#order_status').html(updated_data[0].status.toUpperCase());
                    $('#order_status').css("color", "green");
                });
            });
            $('#order_cancel').click(function () {
                $.get("admin_close_order_cancel.php?order_id=<?php echo $order_id; ?>", function (data) {
                    var updated_data = JSON.parse(data);
                    $('#order_status').html(updated_data[0].status.toUpperCase());
                    $('#order_status').css("color", "red");
                });
            });
        });
    </script>

</head>

<body style='margin:auto 40px;'>
    <div style='margin:20px auto;display:flex;justify-content: space-between;'>
        <h4>ORDER ID #
            <?php echo $order_id; ?>
        </h4>
        <h4>ORDER STATUS # <span id='order_status'>
                <?php echo strtoupper($status_x); ?>
            </span></h4>
        <span style="float: right;">
            <a href="index.php"><i class="fa-solid fa-house fa-2xl"></i></a>
            <a class="btn btn-outline-success" id="order_paid">PAID</a>
            <a class="btn btn-outline-danger" id="order_cancel">CANCEL ORDER</a>
        </span>
    </div>
    <div class='table-responsive'>
        <table id='order_detail_table' class='table table-striped table-hover' style='font-size:14px;'>
            <?php
            if (count($detail) > 0) {
                $keys = array_keys($detail[0]);
                echo "<thead><tr>";
                for ($i = 0; $i < count($keys); $i++) {
                    $key = strtoupper(str_replace("_", " ", $keys[$i]));
                    if ($key !== "FOOD ID X" && $key !== "ORDER ID" && $key !== "IMAGE") {
                        echo "<th scope='col'>" . $key . "</th>";
                    }
                }
                echo "<th scope='col'>CANCEL</th>";
                echo "<th scope='col'>SERVED</th>";
                echo "</tr></thead>";
                echo "<tbody>";
                for ($i = 0; $i < count($detail); $i++) {
                    echo "<tr><td>" . $detail[$i]['id'] . "</td>";
                    echo "<td>" . $detail[$i]['food_id'] . "</td>";
                    echo "<td style='display:none;'>" . $detail[$i]['order_id'] . "</td>";
                    echo "<td>" . $detail[$i]['qty'] . "</td>";
                    echo "<td id='status_" . $detail[$i]['id'] . "'>" . $detail[$i]['status'] . "</td>";
                    echo "<td>" . $detail[$i]['insert_time'] . "</td>";
                    echo "<td style='display:none;'>" . $detail[$i]['food_id_x'] . "</td>";
                    echo "<td>" . $detail[$i]['name'] . "</td>";
                    echo "<td>" . $detail[$i]['description'] . "</td>";
                    echo "<td>" . $detail[$i]['price'] . "</td>";
                    echo "<td style='display:none;'>" . $detail[$i]['image'] . "</td>";
                    echo "<td>" . $detail[$i]['cat_id'] . "</td>";
                    echo "<td><a id='cancel_" . $detail[$i]['id'] . "'><i class='fa-solid fa-xmark fa-lg'></i></a></td>";
                    echo "<td><a id='served_" . $detail[$i]['id'] . "'><i class='fa-solid fa-bowl-food fa-lg'></i></a></td></tr>";
                }
                echo "</tbody>";
            }
            ?>
        </table>
    </div>
    <script src="../bootstrap-5.3.0-alpha3-dist/js/bootstrap.min.js"></script>
</body>

</html>