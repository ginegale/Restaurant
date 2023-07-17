<?php
namespace order_detail;
use RuntimeException;

function createMysqlConnection()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mk";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (mysqli_connect_errno()) {
        throw new RuntimeException('mysqli connection error: ' . mysqli_connect_error());
    }
    mysqli_set_charset($conn, 'utf8mb4');
    return $conn;
}
function insertNewMk_order_detail($food_id, $order_id, $qty, $status)
{
    $conn = createMysqlConnection();
    $sql = "INSERT INTO mk_order_detail (id, food_id, order_id, qty, status)
        VALUE(0, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $food_id, $order_id, $qty, $status);
    $isSuccess = false;
    if ($stmt->execute() === TRUE) {
        $isSuccess = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    mysqli_close($conn);
    return $isSuccess;
}

function updateMk_order_detail($id, $food_id, $order_id, $qty, $status)
{
    $conn = createMysqlConnection();
    $sql = "UPDATE mk_order_detail SET food_id=?, order_id=?, qty=?, status=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisi", $food_id, $order_id, $qty, $status, $id);
    $isSuccess = false;
    if ($stmt->execute() === TRUE) {
        $isSuccess = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    mysqli_close($conn);
    return $isSuccess;
}

function deleteMk_order_detail($id)
{
    $conn = createMysqlConnection();
    $sql = "DELETE FROM mk_order_detail WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute() === TRUE) {
        echo "Deleted Successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    mysqli_close($conn);
}

function getAllMk_order_detail()
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM mk_order_detail ORDER BY id";
    $result = $conn->query($sql);
    $mk_order_detail = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mk_order_detail_row = array(
                "id" => $row["id"],
                "food_id" => $row["food_id"],
                "order_id" => $row["order_id"],
                "qty" => $row["qty"],
                "status" => $row["status"],
                "insert_time" => $row["insert_time"]
            );
            array_push($mk_order_detail, $mk_order_detail_row);
        }
    } else {
        echo "0 results";
    }
    mysqli_close($conn);
    return $mk_order_detail;
}

function getMk_order_detailById($id)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM mk_order_detail WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    //either get_result() or bind_result(parameter) is fine.*****
    $result = $stmt->get_result();

    $mk_order_detail = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mk_order_detail_row = array(
                "id" => $row["id"],
                "food_id" => $row["food_id"],
                "order_id" => $row["order_id"],
                "qty" => $row["qty"],
                "status" => $row["status"],
                "insert_time" => $row["insert_time"]
            );
            array_push($mk_order_detail, $mk_order_detail_row);
        }
    } else {
        echo "0 results";
    }
    $stmt->close();
    $conn->close();
    return $mk_order_detail;
}

function getMkOrderDetailByIdAndStatus($order_id_x, $status)
{
    $conn = createMysqlConnection();
    $sql = "SELECT *, mk_order_detail.id AS order_detail_id, food.id AS foodid FROM mk_order_detail
    INNER JOIN food ON food.id = mk_order_detail.food_id 
    WHERE mk_order_detail.order_id = ?";
    if (count($status) > 0) {
        $sql = $sql . " AND (";
        for ($i = 0; $i < count($status); $i++) {
            $sql = $sql . "  mk_order_detail.status = '" . $status[$i] . "'";
            if ($i < count($status) - 1) {
                $sql = $sql . " OR ";
            }
        }
        $sql = $sql . " ) ";
    }
    $sql = $sql . " ORDER BY  mk_order_detail.status, mk_order_detail.insert_time ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id_x);
    $stmt->execute();

    $result = $stmt->get_result();

    $mk_order_detail = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mk_order_detail_row = array(
                "id" => $row["order_detail_id"],
                "food_id" => $row["food_id"],
                "order_id" => $row["order_id"],
                "qty" => $row["qty"],
                "status" => $row["status"],
                "insert_time" => $row["insert_time"],

                "food_id_x" => $row["foodid"],
                "name" => $row["name"],
                "description" => $row["description"],
                "price" => $row["price"],
                "image" => $row["image"],
                "cat_id" => $row["cat_id"]
            );
            array_push($mk_order_detail, $mk_order_detail_row);
        }
    } else {

    }
    $stmt->close();
    mysqli_close($conn);
    return $mk_order_detail;
}

function searchMk_order_detail($name_search, $column_name_to_search)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM mk_order_detail WHERE `$column_name_to_search` LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name_search);
    $stmt->execute();
    $stmt->bind_result($id, $food_id, $order_id, $qty, $status, $insert_time);

    $mk_order_detail = array();
    while ($stmt->fetch()) {
        $mk_order_detail_row = array(
            "id" => $id,
            "food_id" => $food_id,
            "order_id" => $order_id,
            "qty" => $qty,
            "status" => $status,
            "insert_time" => $insert_time
        );
        array_push($mk_order_detail, $mk_order_detail_row);
    }
    $stmt->close();
    mysqli_close($conn);
    return $mk_order_detail;
}
?>