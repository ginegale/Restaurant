<?php
namespace order;
use mysqli;

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
function insertNewMk_order($table_no, $status)
{
    $conn = createMysqlConnection();
    $sql = "INSERT INTO mk_order (id, table_no, status)
        VALUE(0, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $table_no, $status);
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

function updateMk_order($id, $table_no, $status)
{
    $conn = createMysqlConnection();
    $sql = "UPDATE mk_order SET table_no=?, status=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $table_no, $status, $id);
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

function deleteMk_order($id)
{
    $conn = createMysqlConnection();
    $sql = "DELETE FROM mk_order WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute() === TRUE) {
        echo "<i>Deleted Successfully</i>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

function getAllMk_order()
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM mk_order ORDER BY id";
    $result = $conn->query($sql);
    $mk_order = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mk_order_row = array(
                "id" => $row["id"],
                "table_no" => $row["table_no"],
                "status" => $row["status"],
                "insert_time" => $row["insert_time"]
            );
            array_push($mk_order, $mk_order_row);
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    return $mk_order;
}

function getMk_orderById($id)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM mk_order WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    //either get_result() or bind_result(parameter) is fine.*****
    $result = $stmt->get_result();

    $mk_order = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $mk_order_row = array(
                "id" => $row["id"],
                "table_no" => $row["table_no"],
                "status" => $row["status"],
                "insert_time" => $row["insert_time"]
            );
            array_push($mk_order, $mk_order_row);
        }
    } else {
        echo "0 results";
    }
    $stmt->close();
    $conn->close();
    return $mk_order;
}

function searchMk_order($name_search, $column_name_to_search)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM mk_order WHERE `$column_name_to_search` LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name_search);
    $stmt->execute();
    //$result = $stmt->get_result(); 
    //either get_result() or bind_result(parameter) is fine.*****
    $stmt->bind_result($id, $table_no, $status, $insert_time);

    $mk_order = array();
    while ($stmt->fetch()) {
        $mk_order_row = array(
            "id" => $id,
            "table_no" => $table_no,
            "status" => $status,
            "insert_time" => $insert_time
        );
        array_push($mk_order, $mk_order_row);
    }
    $stmt->close();
    $conn->close();
    return $mk_order;
}

//////////////NOT FROM CODE GEN//////////////
function searchMk_openOrder($table_no)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM mk_order WHERE `table_no` = ? AND `status` = 'open' ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $table_no);
    $stmt->execute();
    $stmt->bind_result($id, $table_no, $status, $insert_time);

    $mk_order = array();
    while ($stmt->fetch()) {
        $mk_order_row = array(
            "id" => $id,
            "table_no" => $table_no,
            "status" => $status,
            "insert_time" => $insert_time
        );
        array_push($mk_order, $mk_order_row);
    }
    $stmt->close();
    mysqli_close($conn);
    return $mk_order;
}

?>