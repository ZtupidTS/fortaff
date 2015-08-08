<?php
include '../includes/allpageaj.php';

$fields = array();
$fields['sec_name'] = dbString($_POST['section']);
$fields['sec_enable'] = dbInteger(1);
sectionInsert($fields);
unset($fields);

echo 'ok';

closeDataBase();
?>