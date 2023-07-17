<?php
function createMysqlConnection()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mk";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->query("SET NAMES UTF8;");
    return $conn;
}
function insertNewFood_category($name)
{
    $conn = createMysqlConnection();
    $sql = "INSERT INTO food_category (id, name)
    VALUE(0, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $isSuccess = false;
    if ($stmt->execute() === TRUE) {
        $isSuccess = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
    return $isSuccess;
}

function updateFood_category($id, $name)
{
    $conn = createMysqlConnection();
    $sql = "UPDATE food_category SET name=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);
    $isSuccess = false;
    if ($stmt->execute() === TRUE) {
        $isSuccess = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
    return $isSuccess;
}

function deleteFood_category($id)
{
    $conn = createMysqlConnection();
    $sql = "DELETE FROM food_category WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute() === TRUE) {
        echo "Deleted Successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

function getAllFood_category()
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM food_category ORDER BY id";
    $result = $conn->query($sql);
    $food_category = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $food_category_row = array(
                "id" => $row["id"],
                "name" => $row["name"]
            );
            array_push($food_category, $food_category_row);
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    return $food_category;
}

function getFood_categoryById($id)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM food_category WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    //either get_result() or bind_result(parameter) is fine.*****
    $result = $stmt->get_result();

    $food_category = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $food_category_row = array(
                "id" => $row["id"],
                "name" => $row["name"]
            );
            array_push($food_category, $food_category_row);
        }
    } else {
        echo "0 results";
    }
    $stmt->close();
    $conn->close();
    return $food_category;
}

function searchFood_category($name_search, $column_name_to_search)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM food_category WHERE `$column_name_to_search` LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name_search);
    $stmt->execute();
    //$result = $stmt->get_result(); 
    //either get_result() or bind_result(parameter) is fine.*****
    $stmt->bind_result($id, $name);

    $food_category = array();
    while ($stmt->fetch()) {
        $food_category_row = array(
            "id" => $id,
            "name" => $name
        );
        array_push($food_category, $food_category_row);
    }
    $stmt->close();
    $conn->close();
    return $food_category;
}
?>