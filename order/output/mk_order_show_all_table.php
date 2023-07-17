<?php
require_once("mk_order_function.php");
$data = \order\getAllMk_order();
if (count($data) > 0) {
    echo "<table class='table table-striped table-hover w-auto' style='font-size:14px;'><thead><tr>";
    $keys = array_keys($data[0]);
    for ($i = 0; $i < count($keys); $i++) {
        $key = strtoupper(str_replace("_", " ", $keys[$i]));
        echo "<th scope='col'>$key</th>";
    }
    echo "<th scope='col'>" . "EDIT" . "</th>";
    echo "<th scope='col'>" . "DELETE" . "</th>";
    echo "<th scope='col'>" . "DETAIL" . "</th>";
    echo "</tr></thead>";
    echo "<tbody>";
    for ($i = 0; $i < count($data); $i++) {
        // if ($i % 2 == 0) {
        //     echo "<tr style='background-color:#cccccc;'>";
        // } else {
        //     echo "<tr>";
        // }
        echo "<tr>";
        for ($j = 0; $j < count($keys); $j++) {
            $key = $keys[$j];
            echo "<td >" . $data[$i][$key] . "</td>";
        }
        $id = $data[$i]['id'];
        $status = $data[$i]['status'];
        echo "<td>" . "<button onclick='editForm($id)'>Edit</button>" . "</td>";
        echo "<td>" . "<button onclick='confirm_delete($id)'>Delete</button>" . "</td>";
        echo "<td>" . "<a href='order_detail.php?order_id=$id&status=$status'>Detail</a>" . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}
?>