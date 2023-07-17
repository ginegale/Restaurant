<?php
function createMysqlConnection()
{
    $servername = "{_DATABASE_SERVER_LOCATION_}";
    $username = "{_DATABASE_SERVER_USERNAME_}";
    $password = "{_DATABASE_SERVER_PASSWORD_}";
    $dbname = "{_DATABASE_SERVER_NAME_}";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->query("SET NAMES UTF8;");
    return $conn;
}
function insertNew{_TABLE_NAME_}({{##START LOOP ALL COLUMNS##}}
                                {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
                                {{SEPARATOR}}, {{END SEPARATOR}}
                                ${_COLUMN_FIELD_} 
                                {{##END LOOP ALL COLUMNS##}}) 
{
    $conn = createMysqlConnection();
    $sql = "INSERT INTO {_TABLE_NAME_VARIABLE_} ({{##START LOOP ALL COLUMNS##}}
                                {{EXCEPT LIST}}insert_time{{END EXCEPT LIST}}
                                {{SEPARATOR}}, {{END SEPARATOR}}
                                {_COLUMN_FIELD_} 
                                {{##END LOOP ALL COLUMNS##}})
    VALUE(0, {{##START LOOP ALL COLUMNS##}}
            {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
            {{SEPARATOR}}, {{END SEPARATOR}}
            ?
            {{##END LOOP ALL COLUMNS##}})";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("{{##START LOOP ALL COLUMNS##}}{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}{{SEPARATOR}}{{END SEPARATOR}}{_COLUMN_TYPE_SMALL_}{{##END LOOP ALL COLUMNS##}}", {{##START LOOP ALL COLUMNS##}}
    {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
    {{SEPARATOR}}, {{END SEPARATOR}}
    ${_COLUMN_FIELD_} 
    {{##END LOOP ALL COLUMNS##}});
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

function update{_TABLE_NAME_}({{##START LOOP ALL COLUMNS##}}
                            {{EXCEPT LIST}}insert_time{{END EXCEPT LIST}}
                            {{SEPARATOR}}, {{END SEPARATOR}}
                            ${_COLUMN_FIELD_} 
                            {{##END LOOP ALL COLUMNS##}})
{
    $conn = createMysqlConnection();
    $sql = "UPDATE {_TABLE_NAME_VARIABLE_} SET {{##START LOOP ALL COLUMNS##}}
                                {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
                                {{SEPARATOR}}, {{END SEPARATOR}}
                                {_COLUMN_FIELD_}=?
                                {{##END LOOP ALL COLUMNS##}} WHERE {{TABLE_PRIMARY_KEY}}=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("{{##START LOOP ALL COLUMNS##}}{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}{{SEPARATOR}}{{END SEPARATOR}}{_COLUMN_TYPE_SMALL_}{{##END LOOP ALL COLUMNS##}}i", {{##START LOOP ALL COLUMNS##}}
    {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
    {{SEPARATOR}}, {{END SEPARATOR}}
    ${_COLUMN_FIELD_}
    {{##END LOOP ALL COLUMNS##}}, ${{TABLE_PRIMARY_KEY}});
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

function delete{_TABLE_NAME_}($id)
{
    $conn = createMysqlConnection();
    $sql = "DELETE FROM {_TABLE_NAME_VARIABLE_} WHERE {{TABLE_PRIMARY_KEY}} = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", ${{TABLE_PRIMARY_KEY}});
    if ($stmt->execute() === TRUE) {
        echo "Deleted Successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

function getAll{_TABLE_NAME_}()
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM {_TABLE_NAME_VARIABLE_} ORDER BY {{TABLE_PRIMARY_KEY}}";
    $result = $conn->query($sql);
    ${_TABLE_NAME_VARIABLE_} = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ${_TABLE_NAME_VARIABLE_}_row = array(
                {{##START LOOP ALL COLUMNS##}}
                {{SEPARATOR}}, 
                {{END SEPARATOR}}
                "{_COLUMN_FIELD_}" => $row["{_COLUMN_FIELD_}"]
                {{##END LOOP ALL COLUMNS##}}
            );
            array_push(${_TABLE_NAME_VARIABLE_}, ${_TABLE_NAME_VARIABLE_}_row);
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    return ${_TABLE_NAME_VARIABLE_};
}

function get{_TABLE_NAME_}By{{TABLE_PRIMARY_KEY_UCFIRST}}(${{TABLE_PRIMARY_KEY}})
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM {_TABLE_NAME_VARIABLE_} WHERE {{TABLE_PRIMARY_KEY}} = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", ${{TABLE_PRIMARY_KEY}});
    $stmt->execute();
    //either get_result() or bind_result(parameter) is fine.*****
    $result = $stmt->get_result();

    ${_TABLE_NAME_VARIABLE_} = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ${_TABLE_NAME_VARIABLE_}_row = array(
                {{##START LOOP ALL COLUMNS##}}
                {{SEPARATOR}}, 
                {{END SEPARATOR}}
                "{_COLUMN_FIELD_}" => $row["{_COLUMN_FIELD_}"]
                {{##END LOOP ALL COLUMNS##}}
            );
            array_push(${_TABLE_NAME_VARIABLE_}, ${_TABLE_NAME_VARIABLE_}_row);
        }
    } else {
        echo "0 results";
    }
    $stmt->close();
    $conn->close();
    return ${_TABLE_NAME_VARIABLE_};
}

function search{_TABLE_NAME_}($name_search, $column_name_to_search)
{
    $conn = createMysqlConnection();
    $sql = "SELECT*FROM {_TABLE_NAME_VARIABLE_} WHERE `$column_name_to_search` LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name_search);
    $stmt->execute();
    //$result = $stmt->get_result(); 
    //either get_result() or bind_result(parameter) is fine.*****
    $stmt->bind_result({{##START LOOP ALL COLUMNS##}}
                    {{SEPARATOR}}, {{END SEPARATOR}}
                    ${_COLUMN_FIELD_}
                    {{##END LOOP ALL COLUMNS##}});

    ${_TABLE_NAME_VARIABLE_} = array();
    while ($stmt->fetch()) {
        ${_TABLE_NAME_VARIABLE_}_row = array(
            {{##START LOOP ALL COLUMNS##}}
            {{SEPARATOR}}, 
            {{END SEPARATOR}}
            "{_COLUMN_FIELD_}" => ${_COLUMN_FIELD_}
            {{##END LOOP ALL COLUMNS##}}
        );
        array_push(${_TABLE_NAME_VARIABLE_}, ${_TABLE_NAME_VARIABLE_}_row);
    }
    $stmt->close();
    $conn->close();
    return ${_TABLE_NAME_VARIABLE_};
}
?>