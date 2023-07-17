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
function insertNewFood($name, $description, $price, $image, $cat_id) 
{
    $conn = createMysqlConnection();
    $sql = "INSERT INTO food (id, name, description, price, image, cat_id)
    VALUE(0, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $cat_id);
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

function updateFood($id, $name, $description, $price, $image, $cat_id)
{
    $conn = createMysqlConnection();
    $sql = "UPDATE food SET name=?, description=?, price=?, image=?, cat_id=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsii", $name, $description, $price, $image, $cat_id, $id);
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

function deleteFood($id)
{
    $conn = createMysqlConnection();
    $sql = "DELETE FROM food WHERE id = ?";
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

function getAllFood()
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM food ORDER BY id";
    $result = $conn->query($sql);
    $food = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $food_row = array(
                "id" => $row["id"], 
                "name" => $row["name"], 
                "description" => $row["description"], 
                "price" => $row["price"], 
                "image" => $row["image"], 
                "cat_id" => $row["cat_id"]
            );
            array_push($food, $food_row);
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    return $food;
}

function getFoodById($id)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM food WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    //either get_result() or bind_result(parameter) is fine.*****
    $result = $stmt->get_result();

    $food = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $food_row = array(
                "id" => $row["id"], 
                "name" => $row["name"], 
                "description" => $row["description"], 
                "price" => $row["price"], 
                "image" => $row["image"], 
                "cat_id" => $row["cat_id"]
            );
            array_push($food, $food_row);
        }
    } else {
        echo "0 results";
    }
    $stmt->close();
    $conn->close();
    return $food;
}

function searchFood($name_search, $column_name_to_search)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM food WHERE `$column_name_to_search` LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $name_search);
    $stmt->execute();
    //$result = $stmt->get_result(); 
    //either get_result() or bind_result(parameter) is fine.*****
    $stmt->bind_result($id, $name, $description, $price, $image, $cat_id);

    $food = array();
    while ($stmt->fetch()) {
        $food_row = array(
            "id" => $id, 
            "name" => $name, 
            "description" => $description, 
            "price" => $price, 
            "image" => $image, 
            "cat_id" => $cat_id
        );
        array_push($food, $food_row);
    }
    $stmt->close();
    $conn->close();
    return $food;
}
?>