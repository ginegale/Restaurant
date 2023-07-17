<?php
require_once("../order/output/mk_order_function.php");
?>
<html>

<head>
    <meta charset="UTF-8" />
    <script type="text/javascript" src="../jquery-3.6.4.min.js"></script>
    <link href="../bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css" rel="stylesheet">
    <title>All Food Orders</title>
    <script>
        $(document).ready(function () {
            loadTable();
        });
        function loadTable() {
            $("#table").load("../order/output/mk_order_show_all_table.php");
        }
        function confirm_delete(id) {
            var r = confirm("Do you want to delete Id " + id + "?");
            if (r == true) {
                $("#data").load("../order/output/mk_order_delete.php?id=" + id, function (responseTxt, statusTxt, xhr) {
                    if (statusTxt == "success") {
                        loadTable();
                    }
                    else if (statusTxt == "error") {
                        alert("Error: " + xhr.status + ": " + xhr.statusTxt);
                    }
                });
            }
        }
        function editForm(id)
        {
            $("#insert_form").css("visibility", "visible");
            $("#insert_form").load("../order/output/mk_order_insert_form.php?action=edit&id="+id);
        }
    </script>
</head>

<body style='margin:30px;'>
    <h4 style='margin:20px auto;'>ALL FOOD ORDERS</h4>
    <div id="data"></div>
    <div id="table" class='table-responsive-sm'></div>
    <br/><br/>
    <h4 style='margin:20px auto;'></h4>
    <div id="insert_form" style='visibility: hidden;'></div>
    <a href="index.php" style='display:none;'>Back</a>

    <script src="../bootstrap-5.3.0-alpha3-dist/js/bootstrap.min.js"></script>
</body>

</html>