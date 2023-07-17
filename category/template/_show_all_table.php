<?php
require_once("{_TABLE_NAME_VARIABLE_}_function.php");
$data = getAll{_TABLE_NAME_}();
if (count($data) > 0) {
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr>";
    $keys = array_keys($data[0]);
    for ($i = 0; $i < count($keys); $i++) {
        $key = ucfirst($keys[$i]);
        echo "<th>$key</th>";
    }
    echo "<th>" . "Edit" . "</th>";
    echo "<th>" . "Delete" . "</th>";
    echo "</tr>";
    for ($i = 0; $i < count($data); $i++) {
        if ($i % 2 == 0) {
            echo "<tr style='background-color:#cccccc;'>";
        } else {
            echo "<tr>";
        }
        for ($j = 0; $j < count($keys); $j++) {
            $key = $keys[$j];
            echo "<td >" . $data[$i][$key] . "</td>";
        }
        ${{TABLE_PRIMARY_KEY}} = $data[$i]['{{TABLE_PRIMARY_KEY}}'];
        echo "<td>" . "<a href='{_TABLE_NAME_VARIABLE_}_insert_form.php?action=edit&{{TABLE_PRIMARY_KEY}}=${{TABLE_PRIMARY_KEY}}'>Edit</a>" . "</td>";
        echo "<td>" . "<button onclick='confirm_delete(${{TABLE_PRIMARY_KEY}})'>Delete</button>" . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>