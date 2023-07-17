<?php
require_once("{_TABLE_NAME_VARIABLE_}_function.php");
${{TABLE_PRIMARY_KEY}} = $_GET["{{TABLE_PRIMARY_KEY}}"];
delete{_TABLE_NAME_}(${{TABLE_PRIMARY_KEY}});
?>
<br />
<a href="{_TABLE_NAME_VARIABLE_}_show_all.php">Back</a>