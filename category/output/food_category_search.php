<?php
require_once("food_category_function.php");
?>
<html>

<head>
    <meta charset="UTF-8" />
    <title>MM's Bag [Food_category]</title>
    <script>
        function confirm_delete(id) {
            var r = confirm("Do you want to delete id " + id + "?");
            if (r == true) {
             window.open("food_category_delete.php?id=" + id, "_self");
            }
        }
    </script>
</head>

<body>
    <h1>All Food_category</h1>
    <form action="food_category_search.php" method="post">
        Search: <input type="text" name="text_to_search" value="%" />
        <input type="submit" value="SEARCH" name="btn" />
    </form>
    <br /><br />
    <?php
    if (isset($_POST['btn'])) {
        require_once("food_category_function.php");
        $food_category = searchFood_category(trim($_POST['text_to_search']), "name");
        if (count($food_category) > 0) {
            echo "<table border='1' style='border-collapse:collapse;'>";
            echo "<tr>";
            $keys = array_keys($food_category[0]);
            for ($i = 0; $i < count($keys); $i++) {
                $key = ucfirst($keys[$i]);
                echo "<th>$key</th>";
            }
            echo "<th>" . "Edit" . "</th>";
            echo "<th>" . "Delete" . "</th>";
            echo "</tr>";
            for ($i = 0; $i < count($food_category); $i++) {
                if ($i % 2 == 0) {
                    echo "<tr style='background-color:#cccccc;'>";
                } else {
                    echo "<tr>";
                }
                for ($j = 0; $j < count($keys); $j++) {
                    $key = $keys[$j];
                    echo "<td >" . $food_category[$i][$key] . "</td>";
                }
                $id = $food_category[$i]['id'];
                echo "<td>" . "<a href='food_category_insert_form.php?action=edit&id=$id'>Edit</a>" . "</td>";
                echo "<td>" . "<button onclick='confirm_delete($id)'>Delete</button>" . "</td>";
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