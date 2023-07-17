<?php
session_start();
require_once("{_TABLE_NAME_VARIABLE_}_function.php");

$isEdit = false;
if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $isEdit = true;
    ${{TABLE_PRIMARY_KEY}} = $_GET['{{TABLE_PRIMARY_KEY}}'];
    $values = get{_TABLE_NAME_}By{{TABLE_PRIMARY_KEY_UCFIRST}}(${{TABLE_PRIMARY_KEY}});
    if (count($values) > 0) {
        {{##START LOOP ALL COLUMNS##}}
        ${_COLUMN_FIELD_} = $values[0]["{_COLUMN_FIELD_}"];
        $_SESSION["{_COLUMN_FIELD_}"] = ${_COLUMN_FIELD_};
        {{##END LOOP ALL COLUMNS##}}
    }
}
?>
<html>

<head>
    <title>MM's Bag [{_TABLE_NAME_}]</title>
</head>

<body>
    <?php
    {{##START LOOP ALL COLUMNS##}}
    {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
    if (isset($_GET['return']) and $_GET['return'] == {_COLUMN_INDEX_}) {
        echo "<p style='color:red;'>please fill out your {_COLUMN_COMMENT_}</p>";
    }
    {{##END LOOP ALL COLUMNS##}}
    ?>
    <h1>Insert New {_TABLE_NAME_}</h1>
    <?php
    if ($isEdit) {
        echo "<form action='{_TABLE_NAME_VARIABLE_}_update_action.php' method='post'>";
    } else {
        echo "<form action='{_TABLE_NAME_VARIABLE_}_insert_action.php' method='post'>";
    }
    ?>
    <table>
        <?php
        if ($isEdit) {
            echo "<input type='hidden' name='id' value='${{TABLE_PRIMARY_KEY}}' />";
        }
        ?>
        {{##START LOOP ALL COLUMNS##}}
        {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
        <tr>
            <th style="text-align: right;">{_COLUMN_FIELD_UCFIRST_} </th>
            <td><input type="text" name="{_COLUMN_FIELD_}"
                value="<?php echo isset($_SESSION['{_COLUMN_FIELD_}']) ? $_SESSION['{_COLUMN_FIELD_}'] : ""; ?>" /></td>
        </tr>
        {{##END LOOP ALL COLUMNS##}}
        <tr>
            <td colspan="2" style="text-align: right;"><input type="submit" name="submit" value="SAVE" /></td>
        </tr>
    </table>
    </form>
</body>

</html>