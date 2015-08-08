<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['sec_id'] = dbInteger($_POST['section']);
$fields['sec_enable'] = dbInteger(0);
sectionUpdate($fields);
unset($fields);

echo 'ok';

closeDataBase();
?>