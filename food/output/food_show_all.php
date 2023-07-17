<?php
require_once("food_function.php");
?>
<html>

<head>
    <meta charset="UTF-8" />
    <script type="text/javascript" src="jquery-3.6.4.min.js"></script>
    <title>MM's Bag [Food]</title>
    <script>
        $(document).ready(function () {
            loadTable();
        });
        function loadTable() {
            $("#table").load("food_show_all_table.php", function (responseTxt, statusTxt, xhr) {

            });
        }
        function confirm_delete(id) {
            var r = confirm("Do you want to delete Id " + id + "?");
            if (r == true) {
                //window.open("delete_customer.php?id=" + id, "_self");
                //ajax
                $("#data").load("food_delete.php?id=" + id, function (responseTxt, statusTxt, xhr) {
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
    <h1>All Food</h1>
    <div id="data"></div>
    <div id="table"></div>
    <br />
    <a href="index.php">Back</a>
</body>

</html>