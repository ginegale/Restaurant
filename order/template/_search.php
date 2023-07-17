<?php
require_once("{_TABLE_NAME_VARIABLE_}_function.php");
?>
<html>

<head>
    <meta charset="UTF-8" />
    <title>MM's Bag [{_TABLE_NAME_}]</title>
    <script>
        function confirm_delete({{TABLE_PRIMARY_KEY}}) {
            var r = confirm("Do you want to delete {{TABLE_PRIMARY_KEY}} " + {{TABLE_PRIMARY_KEY}} + "?");
            if (r == true) {
             window.open("{_TABLE_NAME_VARIABLE_}_delete.php?{{TABLE_PRIMARY_KEY}}=" + {{TABLE_PRIMARY_KEY}}, "_self");
            }
        }
    </script>
</head>

<body>
    <h1>All {_TABLE_NAME_}</h1>
    <form action="{_TABLE_NAME_VARIABLE_}_search.php" method="post">
        Search: <input type="text" name="text_to_search" value="%" />
        <input type="submit" value="SEARCH" name="btn" />
    </form>
    <br /><br />
    <?php
    if (isset($_POST['btn'])) {
        require_once("{_TABLE_NAME_VARIABLE_}_function.php");
        ${_TABLE_NAME_VARIABLE_} = search{_TABLE_NAME_}(trim($_POST['text_to_search']), "name");
        if (count(${_TABLE_NAME_VARIABLE_}) > 0) {
            echo "<table border='1' style='border-collapse:collapse;'>";
            echo "<tr>";
            $keys = array_keys(${_TABLE_NAME_VARIABLE_}[0]);
            for ($i = 0; $i < count($keys); $i++) {
                $key = ucfirst($keys[$i]);
                echo "<th>$key</th>";
            }
            echo "<th>" . "Edit" . "</th>";
            echo "<th>" . "Delete" . "</th>";
            echo "</tr>";
            for ($i = 0; $i < count(${_TABLE_NAME_VARIABLE_}); $i++) {
                if ($i % 2 == 0) {
                    echo "<tr style='background-color:#cccccc;'>";
                } else {
                    echo "<tr>";
                }
                for ($j = 0; $j < count($keys); $j++) {
                    $key = $keys[$j];
                    echo "<td >" . ${_TABLE_NAME_VARIABLE_}[$i][$key] . "</td>";
                }
                $id = ${_TABLE_NAME_VARIABLE_}[$i]['id'];
                echo "<td>" . "<a href='{_TABLE_NAME_VARIABLE_}_insert_form.php?action=edit&{{TABLE_PRIMARY_KEY}}=${{TABLE_PRIMARY_KEY}}'>Edit</a>" . "</td>";
                echo "<td>" . "<button onclick='confirm_delete(${{TABLE_PRIMARY_KEY}})'>Delete</button>" . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "Please pressed the search button";
    }

    ?>
    <br />
    <a href="index.php">Back</a>
</body>

</html>