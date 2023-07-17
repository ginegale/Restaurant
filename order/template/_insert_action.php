<?php
require_once("{_TABLE_NAME_VARIABLE_}_function.php");
session_start();

{{##START LOOP ALL COLUMNS##}}
{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
${_COLUMN_FIELD_} = trim($_POST["{_COLUMN_FIELD_}"]);
{{##END LOOP ALL COLUMNS##}}
$submit = $_POST["submit"];

{{##START LOOP ALL COLUMNS##}}
{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
$_SESSION["{_COLUMN_FIELD_}"] = ${_COLUMN_FIELD_};
{{##END LOOP ALL COLUMNS##}}

if (!isset($submit)) {
    header("location:{_TABLE_NAME_VARIABLE_}_insert_form.php");
}
{{##START LOOP ALL COLUMNS##}}
{{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
if (${_COLUMN_FIELD_} == "") {
    header("location:{_TABLE_NAME_VARIABLE_}_insert_form.php?return={_COLUMN_INDEX_}");
    exit;
}
{{##END LOOP ALL COLUMNS##}}

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     header("location:{_TABLE_NAME_VARIABLE_}_insert_form.php?return=5");
//     exit;
// }
$isSuccess = insertNew{_TABLE_NAME_}({{##START LOOP ALL COLUMNS##}}
                                    {{EXCEPT LIST}}id,insert_time{{END EXCEPT LIST}}
                                    {{SEPARATOR}}, {{END SEPARATOR}}
                                    ${_COLUMN_FIELD_} 
                                    {{##END LOOP ALL COLUMNS##}});

session_unset();
session_destroy();
?>
<html>

<head>
    <meta charset="UTF-8" />
</head>

<body>
    <h1>
        <?php echo $isSuccess ? "Insert Successfully" : "Insert Failed" ?>
    </h1>
    <br />
    <a href="index.php">Back</a>
    <br />
    <a href="{_TABLE_NAME_VARIABLE_}_insert_form.php">Back to Insert New Customer</a>
</body>

</html>