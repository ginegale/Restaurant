<?php
require_once("mk_order_function.php");
?>
<html>

<head>
    <meta charset="UTF-8" />
    <script type="text/javascript" src="jquery-3.6.4.min.js"></script>
    <title>MM's Bag [Mk_order]</title>
    <script>
        $(document).ready(function () {
            loadTable();
        });
        function loadTable() {
            $("#table").load("mk_order_show_all_table.php", function (responseTxt, statusTxt, xhr) {

            });
        }
        function confirm_delete(id) {
            var r = confirm("Do you want to delete ID " + id + "?");
            if (r == true) {
                //window.open("delete_customer.php?id=" + id, "_self");
                //ajax
                $("#data").load("mk_order_delete.php?id=" + id, function (responseTxt, statusTxt, xhr) {
                    if (statusTxt == "success") {
                        loadTable();
                    }
                    else if (statusTxt == "error") {
                        alert("Error: " + xhr.status + ": " + xhr.statusTxt);
                    }
                });
            }
            else {

            }
        }
    </script>
</head>

<body>
    <h1>All Mk_order</h1>
    <div id="data"></div>
    <div id="table"></div>
    <br />
    <a href="index.php">Back</a>
</body>

</html>