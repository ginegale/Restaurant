<?php
require_once("{_TABLE_NAME_VARIABLE_}_function.php");
?>
<html>

<head>
    <meta charset="UTF-8" />
    <script type="text/javascript" src="jquery-3.6.4.min.js"></script>
    <title>MM's Bag [{_TABLE_NAME_}]</title>
    <script>
        $(document).ready(function () {
            loadTable();
        });
        function loadTable() {
            $("#table").load("{_TABLE_NAME_VARIABLE_}_show_all_table.php", function (responseTxt, statusTxt, xhr) {

            });
        }
        function confirm_delete({{TABLE_PRIMARY_KEY}}) {
            var r = confirm("Do you want to delete {{TABLE_PRIMARY_KEY_UCFIRST}} " + {{TABLE_PRIMARY_KEY}} + "?");
            if (r == true) {
                //window.open("delete_customer.php?id=" + id, "_self");
                //ajax
                $("#data").load("{_TABLE_NAME_VARIABLE_}_delete.php?{{TABLE_PRIMARY_KEY}}=" + {{TABLE_PRIMARY_KEY}}, function (responseTxt, statusTxt, xhr) {
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
    <h1>All {_TABLE_NAME_}</h1>
    <div id="data"></div>
    <div id="table"></div>
    <br />
    <a href="index.php">Back</a>
</body>

</html>